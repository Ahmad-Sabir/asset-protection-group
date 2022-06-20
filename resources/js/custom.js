window.submitForm = () => {
    return {
        formData: {},
        errorMessages: [],
        isLoading: false,

        onSubmitPost(e) {
            let storedata = new FormData(e.target);
            this.isLoading = true;
            axios.post(e.target.action, storedata)
                .then(response => {
                    this.errorMessages = [];
                    if (response.data.statusCode == 201) {
                        setToastrAlert('success', response.data.message);
                        setTimeout(() => {
                            window.location.href = response.data.data.redirect_url ? response.data.data.redirect_url : window.location;
                        }, 700);
                    } else {
                        setToastrAlert('error', 'Error occured please try again.');
                        this.isLoading = false;
                    }
                })
                .catch(error => {
                    if (error.response.status !== 500) {
                        setToastrAlert('error', error.response.data.message);
                        this.errorMessages = error.response.data.errors;
                    }
                    this.isLoading = false;
                });
        },
        onSubmitPut(e) {
            let updateData = new FormData(e.target);
            updateData.append('_method', 'PUT');
            this.isLoading = true;
            axios.post(e.target.action, updateData).then(response => {
                    this.errorMessages = [];
                    if (response.data.statusCode == 200) {
                        setToastrAlert('success', response.data.message);
                        setTimeout(() => {
                            window.location.href = response.data.data.redirect_url ? response.data.data.redirect_url : window.location;
                        }, 700);
                    } else {
                        setToastrAlert('error', 'Error occured please try again.');
                        this.isLoading = false;
                    }
                })
                .catch(error => {
                    this.isLoading = false;
                    if (error.response.status !== 500) {
                        setToastrAlert('error', error.response.data.message);
                        this.errorMessages = error.response.data.errors;
                    }
                });
        }
    }
}

window.setToastrAlert = (color, message) => {
    toastr.options = {
        preventDuplicates: true,
        closeButton: true,
        progressBar: true,
    };

    if (typeof toastr[color] === "function") {
        toastr[color](message);
        return;
    }

    toastr.info(message);
};

window.addEventListener('DOMContentLoaded', () => {
    window.searchString = '';
    let initializeSelectr = function (element) {
        let livewireId = element.closest('[wire\\:id]').getAttribute('wire:id');
        let selectr = new Selectr(element, {
            searchable: true,
            clearable: false
        });
        selectr.input.addEventListener('keyup', _.debounce(function (e) {
            if (/^[A-Za-z\d\-_\s]+$/.test(e.key)) {
                window.searchString = e.target.value;
                Livewire.components.emitSelf(livewireId, 'reactOnSearch', e.target.value)
            }
        }, 250));

        selectr.on('selectr.change', function(option) {
            let func = element.getAttribute('data-onchangefun');
            if (func) {
                window[func](option, element);
            }
        });

        return selectr;
    }

    Livewire.hook('message.processed', (message, component) => {
        let componentId = component.id;
        let element = document.querySelector(`[data-livewire="${componentId}"]`); // [data-livewire=${componentId}]
        let value = window.searchString || message.response.serverMemo.data.searchQuery || '';
        if (element?.hasAttribute('selectr-select') && typeof(element?.selectr) === 'undefined') {
            let componentData = message.response.serverMemo.data;
            let modelName = componentData.parentModel || '';

            let selectr = initializeSelectr(element);
            selectr.input.value = value;
            if (modelName.length > 0) {
                let modelValue = componentData[modelName];
                selectr.setValue(modelValue, true);
            }
            selectr.open();
            if (value.length > 0) {
                selectr.search();
            }
        }
    });

    document.querySelectorAll('[selectr-select]').forEach(element => {
        initializeSelectr(element)
    });
});

window.addEventListener('livewire-alert', event => {
    setToastrAlert(event.detail.color, event.detail.message);
    if (document.getElementById("export-pdf")) {
        document.getElementById("export-pdf").disabled = false;
    }
    if (document.getElementById("export-csv").disabled) {
        document.getElementById("export-csv").disabled = false;
    }
});
