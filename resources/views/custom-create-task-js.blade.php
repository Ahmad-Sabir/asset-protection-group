@push('script')
    <script>
        function TaskData() {
            return {
                addMode: true,
                id: '',
                form: {
                    id: '',
                    name: '',
                    due_date: '',
                    task_detail: '',
                },
                tasks: [],
                isLoading: false,
                errorTaskMessages: [],

                saveData(e) {
                    if(this.form.due_date == '') {
                        this.form.due_date = document.getElementById('due_date').value;
                    }
                    if(this.form.name == '') {
                        setToastrAlert('error', 'Task name is required.');
                        return false;
                    }
                    this.tasks.push({
                        id: this.form.id,
                        name: this.form.name,
                        due_date: this.form.due_date,
                        task_detail: this.form.task_detail
                    })
                    setToastrAlert('success', 'Task created successfully.');
                    this.resetForm()

                },
                editData(task, index) {
                    this.addMode = false
                    this.form.name = task.name
                    this.form.due_date = task.due_date
                    this.form.task_detail = task.task_detail
                    this.form.id = task.id
                    this.id = index
                },
                updateData(e) {
                    if(this.form.name == '') {
                        setToastrAlert('error', 'Task name is required.');
                        return false;
                    }
                    setToastrAlert('success', 'Task Updated Successfully.');
                    this.tasks.splice(this.id, 1, {
                        name: this.form.name,
                        due_date: this.form.due_date,
                        task_detail: this.form.task_detail,
                        id:this.form.id,
                     })
                },

                resetForm() {
                    this.form.name = ''
                    // this.form.due_date = ''
                    this.form.task_detail = ''
                    this.addMode = true
                }
            }
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [month, day, year].join('-');
        }
        window.addEventListener('load', () => {
            document.querySelector("[name='asset_type_id']").addEventListener("change", (e) => {
                if (e.target.value) {
                    axios.get('/admin/fetch-assets/' + e.target.value).then(response => {
                            if (response.data.statusCode == 201) {
                                var select = document.getElementById('asset');
                            select.innerHTML = '';
                            document.getElementById('locationName').value = '';
                            document.getElementById('location').value = '';
                            document.getElementById('warranty').value ='';
                            var option1 = document.createElement("option");
                            option1.text = "Select Asset";
                            option1.setAttribute('disabled', 'disabled');
                            option1.setAttribute('selected', 'selected');
                            select.appendChild(option1);
                            response.data.data.forEach(function (all_assets) {
                                var name = all_assets.name;
                                var id = all_assets.id;
                                var opt = document.createElement("option");
                                opt.value= id;
                                opt.innerHTML = name;
                                select.appendChild(opt);
                            });
                            } else {
                                setToastrAlert('error', 'Error occured please try again.');
                            }
                        })
                }
            });
            document.querySelector("[name='asset_id']").addEventListener("change", (e) => {
                if (e.target.value) {
                    axios.get('/admin/fetch-location/' + e.target.value).then(response => {
                        if (response.data.statusCode == 201) {
                            document.getElementById('locationName').value = response.data.data.name;
                            document.getElementById('location').value = response.data.data.id;
                            document.getElementById('warranty').value = response.data.data.warranty;
                        } else {
                            setToastrAlert('error', 'Error occured please try again.');
                        }
                    })
                }
            });
        });

        window.onload = function(){
            var x = document.getElementById('work_type');
            x.style.display = "none";
        };

        function handleOrderType(event) {
            var value = event.target.value;
            if (value == 'Non Recurring') {
                document.getElementById('work_type').style.display = "none";
            }
            if (value == 'Recurring') {
                document.getElementById('work_type').style.display = "block";
            }
        }
        var check1 = document.querySelector("#flag");
        check1.onchange = function() {
            if (this.checked) {
                document.querySelector(".fa-bookmark").classList.add('fa-solid');
                document.querySelector(".fa-bookmark").classList.remove('fa-regular');
            } else {
                document.querySelector(".fa-bookmark").classList.add('fa-regular');
                document.querySelector(".fa-bookmark").classList.remove('fa-solid');
            }
        }
        var due_date = document.getElementById('due_date');
        due_date.onchange = function() {
            var task_due_date = document.querySelector("#date_due");
            task_due_date.value = this.value;
        }
    </script>
    @endpush
