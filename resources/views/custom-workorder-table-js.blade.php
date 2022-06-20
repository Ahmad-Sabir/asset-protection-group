@pushOnce('script')
<script>
    function handleStatus(event) {
       var work_order_status = event.target.value;
       var work_order_ids = getCheckedCheckboxesFor('workOrderID');
       if(work_order_ids.length == 0){
           setToastrAlert('error','Please select atleast one Work Order');
        }
        else{
            var bulkUpdate = {
                    'id' : work_order_ids,
                    'status' : work_order_status,
                    'reason' : ''
                };
                if (work_order_status == 'On Hold') {
                    document.getElementById("hold_modal").click();
                    return false;
                }
            if (work_order_status == 'Open' || work_order_status == 'On Hold' || work_order_status == 'In Progress' || work_order_status == 'Completed') {
                var bulkIds = [];
                var bulkId = {
                    'id' : work_order_ids,
                };
                bulkIds.push(JSON.stringify(bulkId));
                axios.get('/admin/work-orders/check-OrderStatus/' + bulkIds).then(response => {
                        if (response.data.statusCode == 200) {
                            if (response.data.data.completed != 0) {
                            let confirmAction = confirm("It seems that there are work orders with ids [" +response.data.data.completed+ "] which is already completed. So do you still want to change its status?");
                            if (confirmAction) {
                                repeat(bulkUpdate);
                            } else {
                                return false;
                            }
                        }
                        if (response.data.data.open != 0) {
                            let confirmAction = confirm("It seems that there are work orders with ids [" +response.data.data.open+ "] which is already open. So do still want to change its status?");
                            if (confirmAction) {
                                repeat(bulkUpdate);
                            } else {
                                return false;
                            }
                        }
                        if (response.data.data.onhold != 0) {
                            let confirmAction = confirm("It seems that there are work orders with ids [" +response.data.data.onhold+ "] which is already on-hold. So do still want to change its status?");
                            if (confirmAction) {
                                repeat(bulkUpdate);
                            } else {
                                return false;
                            }
                        }
                        if(response.data.data.open == 0 && response.data.data.onhold == 0 && response.data.data.completed == 0) {
                        repeat(bulkUpdate);
                        }
                        } else {
                            setToastrAlert('error', 'Error occured please try again.');
                        }
                    })
            } else {
                repeat(bulkUpdate);
            }
        }
    }
    function repeat(bulkUpdate) {
        axios.post(`{{route('admin.work-orders.update.bulkStatus')}}`,
            bulkUpdate

                ).then(response => {
            if (response.data.statusCode == 200) {
                setToastrAlert('success',response.data.message);
                setTimeout(function(){
                    location.reload();
                }, 3000);
            } else {
                setToastrAlert('error', 'Error occured please try again.');
            }
        })
    }
    document.getElementById("on_hold_reason")
                .addEventListener("keypress", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    var onHoldReason = document.getElementById("on_hold_reason").value;
                    var work_order_ids = getCheckedCheckboxesFor('workOrderID');
                    if(onHoldReason != '') {
                    var bulkUpdate = {
                        'id' : work_order_ids,
                        'status' : 'On Hold',
                        'reason' : onHoldReason,
                    };
                    repeat(bulkUpdate);
                    } else {
                        setToastrAlert('error','Reason for on hold is required');
                    }
                }
            });
    function getCheckedCheckboxesFor(checkboxName) {
        var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
        Array.prototype.forEach.call(checkboxes, function(el) {
            values.push(el.value);
        });
        return values;
    }
    function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
    function locationFilter(option) {
        window.livewire.emitTo('work-order-table', 'manualFilter','location', option.value);
    }
</script>
@endPushOnce
