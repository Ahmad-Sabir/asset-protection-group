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
            tasks: <?php echo $workOrder->additionaltasks ?>,
            isLoading: false,
            errorTaskMessages: [],

            saveData(e) {
                if(this.form.due_date == '') {
                        this.form.due_date = document.getElementById('due_date').value;
                    }
                let storedata = new FormData(e.target);
                if(storedata.get('due_date') == '') {
                    storedata.set('due_date', document.getElementById('due_date').value);
                }
                this.isLoading = true;
                axios.post(e.target.action, storedata)
                    .then(response => {
                        this.errorTaskMessages = [];
                        this.isLoading = false;
                        if (response.data.statusCode == 201) {
                            setToastrAlert('success', response.data.message);
                            this.tasks.push({
                                id: response.data.data.id,
                                name: response.data.data.name,
                                due_date: response.data.data.due_date ? formatDate(response.data.data.due_date) : null,
                                task_detail: response.data.data.task_detail
                            })
                            this.resetForm()
                            setTimeout(() => {
                                    location.reload();
                                }, 2000);
                        } else {
                            setToastrAlert('error', 'Error occured please try again.');
                        }
                    })
                    .catch(error => {
                        if (error.response.status !== 500) {
                            setToastrAlert('error', error.response.data.message);
                            this.errorTaskMessages = error.response.data.errors;
                        }
                        this.isLoading = false;
                    });
            },
            editData(task, index) {
                this.form.name = task.name
                this.form.due_date = formatDate(task.due_date)
                this.form.task_detail = task.task_detail
                this.form.id = task.id
                this.id = index
            },
            updateData(e) {
                let updateData = new FormData(e.target);
                this.isLoading = true;
                updateData.append('_method', 'PATCH');
                let action='/admin/work-orders/additional-task/update/'+this.form.id;
                axios.post(action, updateData).then(response => {
                        this.errorTaskMessages = [];
                        this.isLoading = false;
                        if (response.data.statusCode == 200) {
                            setToastrAlert('success', response.data.message);
                            this.tasks.splice(this.id, 1, {
                                name: response.data.data.name,
                                due_date: response.data.data.due_date ? formatDate(response.data.data.due_date) : null,
                                task_detail: response.data.data.task_detail,
                                id: response.data.data.id,
                            })
                            setTimeout(() => {
                                    location.reload();
                                }, 2000);
                        } else {
                            setToastrAlert('error', 'Error occured please try again.');
                        }
                    })
                    .catch(error => {
                        this.isLoading = false;
                        if (error.response.status !== 500) {
                            setToastrAlert('error', error.response.data.message);
                            this.errorTaskMessages = error.response.data.errors;
                        }
                    });
            },
            deleteData(task, index) {
                this.tasks.id = task.id
                this.isLoading = true;
                axios.delete('/admin/work-orders/additional-task/delete/' + this.tasks.id).then(response => {
                    this.errorTaskMessages = [];
                    this.isLoading = false;
                    if (response.data.statusCode == 200) {
                        setToastrAlert('success', response.data.message);
                        this.tasks.splice(index, 1)
                    } else {
                        setToastrAlert('error', 'Error occured please try again.');
                    }
                })
            },
            resetForm() {
                this.form.name = ''
                this.form.due_date = ''
                this.form.task_detail = ''
                this.addMode = true
            },
            saveLogData(e) {
                let storedata = new FormData(e.target);
                this.isLoading = true;
                axios.post(e.target.action, storedata)
                    .then(response => {
                        this.errorTaskMessages = [];
                        this.isLoading = false;
                        if (response.data.statusCode == 200) {
                            if (response.data.data.total_log != null) {
                                var log = response.data.data.total_log;
                                var span = document.createElement("span");
                                span.style.display ='block';
                                span.innerHTML=log;
                                document.getElementById('log-time').prepend(span);
                                document.getElementById('log-input').value = log;
                            }
                            if (log){
                                setToastrAlert('success', response.data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            }
                        } else {
                            setToastrAlert('error', 'Error occured please try again.');
                        }
                    })
                    .catch(error => {
                        if (error.response.status !== 500) {
                            setToastrAlert('error', error.response.data.message);
                            this.errorTaskMessages = error.response.data.errors;
                        }
                        this.isLoading = false;
                    });
            },
            changeTaskStatus(e) {
                    let storedata = new FormData(e.target);
                    storedata.append('_method', 'PATCH');
                    this.isLoading = true;
                    axios.post(e.target.action, storedata)
                        .then(response => {
                            this.errorTaskMessages = [];
                            this.isLoading = false;
                            if (response.data.statusCode == 200) {
                                setToastrAlert('success', response.data.message);
                                var checkbox =document.getElementById('line-'+response.data.data.id);
                                if(response.data.data.status == 'Completed'){
                              checkbox.classList.add('line-through');
                            }
                            else {
                               checkbox.classList.remove('line-through');
                                 }
                                setTimeout(() => {
                                location.reload();
                                }, 3000);
                            } else {
                                setToastrAlert('error', 'Error occured please try again.');
                            }
                        })
                        .catch(error => {
                            if (error.response.status !== 500) {
                                setToastrAlert('error', error.response.data.message);
                                this.errorTaskMessages = error.response.data.errors;
                            }
                            this.isLoading = false;
                        });
                },
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
    window.onload = function() {
        if({{$pause}} == 0) {
            document.getElementById('start-timer').click();
        }
        var x = document.getElementById('work_type');
        x.style.display = "none";
    };
    window.addEventListener('load', () => {
        document.querySelector("[name='work_order_status']").addEventListener("change", (e) => {
            document.getElementById("on_hold_reason").style.display = "none";
                    if (e.target.value) {
                        if (e.target.value == 'On Hold') {
                            document.getElementById("on_hold_reason").style.display = "inline";
                        }
                    }
                });
    });
    function handleOrderType(event) {
        var value = event.target.value;
        if (value == 'Non Recurring') {
            document.getElementById('work_type').style.display = "none";
        }
        if (value == 'Recurring') {
            document.getElementById('work_type').style.display = "revert";
        }
    }

            var popovers = document.querySelectorAll('.popover-box');
            var popoverTriggers = document.querySelectorAll('.popover-trigger');

            for (var i = 0; i < popoverTriggers.length; i++) {
                popoverTriggers[i].addEventListener('click', function(event) {
                    this.parentElement.classList.toggle('popover-active');
                });
            }
            var popoverTrigger0 = document.querySelectorAll('.popover-trigger0');
            var start_timer = popoverTrigger0[0];
            var end_timer = popoverTrigger0[1];
            start_timer.addEventListener('click', function(event) {
                this.parentElement.classList.toggle('popover-active');
                start_timer.classList.add('d-none');
                end_timer.classList.remove('d-none');
                document.getElementById('start-timer').click();

            });
            end_timer.addEventListener('click', function(event) {
                document.getElementById('timer_status').value = 'end';
                this.parentElement.classList.toggle('popover-active');
                start_timer.classList.remove('d-none');
                end_timer.classList.add('d-none');
                document.getElementById('log-submit').click();
                pauseTimer();
                    s = 0;
                    m = 0;
                    h = 0;
                    window.clearInterval(SD);
                    var Timer = document.getElementById("timer");
                    Timer.innerHTML = pad(0) + ":" + pad(0) + ":" + pad(0);
            });
    function pad(val) { return (val > 9) ? val : '0' + val;}
        var s = {{$sec}} //second
        var m = {{$minute}} //minute
        var h = {{$hour}} //hour
        var Timer = document.getElementById("timer");
        var SD;

     function timeStart() {
         s++;
         if (s == 60) {
             s = 0;
             m = m + 1;
         } else {
             m = m;
         } if (m == 60) {
             m = 0;
             h += 1;
         }
         var log = pad(h)+':'+pad(m)+':'+pad(s);
            Timer.innerHTML = log;
            var log = pad(h)+':'+pad(m)+':'+pad(s);
            document.getElementById('log_time').value = log;
            saveLog(log);
     }

        function saveLog(log) {
            var id = document.getElementById('work_order_id').value;
            var logDatas = [];
                var logData = {
                    'id' : id,
                    'log' : log,
                };
                logDatas.push(JSON.stringify(logData));
                axios.patch('/admin/work-orders/update-log/' + logDatas).then(response => {
                    if (response.data.statusCode == 200) {

                    } else {
                        setToastrAlert('error', 'Error occured please try again.');
                    }
                })
        }
        document.getElementById("log-input")
            .addEventListener("keypress", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                var loginput = document.getElementById("log-input");
                log = loginput.value;
                var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(log);
                if (isValid) {
                    loginput.style.backgroundColor = '#bfa';
                    var id = document.getElementById('work_order_id').value;
                    var logDatas = [];
                    var logData = {
                            'id' : id,
                            'log' : log,
                        };
                    logDatas.push(JSON.stringify(logData));
                    axios.patch('/admin/work-orders/custom-log/' + logDatas).then(response => {
                        if (response.data.statusCode == 200) {
                            var span = document.createElement("span");
                            span.style.display ='block';
                            span.innerHTML=log;
                            document.getElementById('log-time').prepend(span);
                            setToastrAlert('success',response.data.message);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                        } else {
                            setToastrAlert('error', 'Error occured please try again.');
                        }
                    })
                } else {
                    loginput.style.backgroundColor = '#fba';
                    setToastrAlert('error','Invalid time format');
                }
                return false;
            }
        });

        function pauseTimer() {
            window.clearInterval(SD);
        }
        /* resettimer */
        function resetTimer() {
            s = 0;
            m = 0;
            h = 0;
            window.clearInterval(SD);
            Timer.innerHTML = pad(0) + ":" + pad(0) + ":" + pad(0);
            end_timer.click();
        }
        document.getElementById('start-timer').addEventListener('click', () => {
            document.getElementById('timer_status').value = 'start';
            document.getElementById("start-timer").style.display = "none";
            document.getElementById("pause-timer").style.display = "inline";
            window.clearInterval(SD);
            const select = document.getElementById('status_order');
            select.options.selectedIndex = 2;
            var log = pad(h)+':'+pad(m)+':'+pad(s);
            document.getElementById('log-input').value = log;
            document.getElementById('log_time').value = log;
            SD = window.setInterval(timeStart, 1000);
            document.getElementById('log-submit').click();
        });
        document.getElementById('pause-timer').addEventListener('click', () => {
            setToastrAlert('error','Log timer is paused');
            document.getElementById('timer_status').value = 'breakin';
            document.getElementById("pause-timer").style.display = "none";
            document.getElementById("start-timer").style.display = "inline";
            pauseTimer();
            document.getElementById('log-submit').click();

        });
        document.getElementById('reset-btn').addEventListener('click', () => {
            resetTimer();
        });
        window.onload = function() {
                if({{$pause}} == 0) {
                    var popoverTrigger0 = document.querySelectorAll('.popover-trigger0');
                    var start_timer = popoverTrigger0[0];
                    var end_timer = popoverTrigger0[1];
                    start_timer.parentElement.classList.toggle('popover-active');
                    start_timer.classList.add('d-none');
                    end_timer.classList.remove('d-none');
                    document.getElementById("start-timer").style.display = "none";
                    document.getElementById("pause-timer").style.display = "inline";
                    window.clearInterval(SD);
                    SD = window.setInterval(timeStart, 1000);

                }
                if({{$timer_status}} == 0) {
                    var popoverTrigger0 = document.querySelectorAll('.popover-trigger0');
                    var start_timer = popoverTrigger0[0];
                    var end_timer = popoverTrigger0[1];
                    start_timer.parentElement.classList.toggle('popover-active');
                    start_timer.classList.add('d-none');
                    end_timer.classList.remove('d-none');
                    document.getElementById("start-timer").style.display = "inline";
                    document.getElementById("pause-timer").style.display = "none";
                    window.clearInterval(SD);
                }
            };
    var check1 = document.querySelector("#flag");
        check1.onchange = function() {
        if(this.checked){
            document.querySelector(".fa-bookmark").classList.add('fa-solid');
            document.querySelector(".fa-bookmark").classList.remove('fa-regular');
        }
        else{
            document.querySelector(".fa-bookmark").classList.add('fa-regular');
            document.querySelector(".fa-bookmark").classList.remove('fa-solid');
        }
    }
    var due_date = document.getElementById('due_date');
        due_date.onchange = function() {
            var task_due_date = document.querySelector("#date_due");
            task_due_date.value = this.value;
        }
    function changeAssignee(option) {
        document.querySelector('#alpine_work_order')._x_dataStack[0].workOrder.assignee_user_id = option.value
    }
</script>
@endpush
