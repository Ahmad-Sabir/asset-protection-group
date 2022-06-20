@pushOnce('script')
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

                deleteData(task_id, type) {
                    axios.delete('/admin/work-orders/additional-task/delete-comment/' + task_id + '/' + type).then(response => {
                        this.errorTaskMessages = [];
                        this.isLoading = false;
                        if (response.data.statusCode == 200) {
                            setToastrAlert('error', response.data.message);
                            setTimeout(function(){
                                        location.reload();
                                    }, 3000);
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
                this.parentElement.classList.toggle('popover-active');
                start_timer.classList.remove('d-none');
                end_timer.classList.add('d-none');
                document.getElementById('timer_status').value = 'end';
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
                        var id = document.getElementById('work_order_id').value;
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
                var popoverTrigger0 = document.querySelectorAll('.popover-trigger0');
                var start_timer = popoverTrigger0[0];
                var end_timer = popoverTrigger0[1];
                if({{$pause}} == 0) {
                    start_timer.parentElement.classList.toggle('popover-active');
                    start_timer.classList.add('d-none');
                    end_timer.classList.remove('d-none');
                    document.getElementById("start-timer").style.display = "none";
                    document.getElementById("pause-timer").style.display = "inline";
                    window.clearInterval(SD);
                    SD = window.setInterval(timeStart, 1000);
                }
                if({{$timer_status}} == 0) {
                    start_timer.parentElement.classList.toggle('popover-active');
                    start_timer.classList.add('d-none');
                    end_timer.classList.remove('d-none');
                    document.getElementById("start-timer").style.display = "inline";
                    document.getElementById("pause-timer").style.display = "none";
                    window.clearInterval(SD);
                }
            };
            function statusChange() {
                var status = document.getElementById("status_order").value;
                var priority = document.getElementById("order_priority").value;
                var holdReason = document.getElementById("hold_reason").value;
                document.getElementById("on_hold_reason").style.display = "none";
                if (status == 'On Hold' && holdReason) {
                    document.getElementById("haveReason").style.display = "inline";
                }
                if (status == 'On Hold' && !holdReason){
                    document.getElementById("on_hold_reason").style.display = "inline";
                    return false;
                }
                var id = document.getElementById('work_order_id').value;
                var statusData = {
                    'id' : id,
                    'status' : status,
                    'priority' : priority,
                    'reason' : holdReason,
                };
                statusUpdate(statusData);
            }
            window.addEventListener('load', () => {
                document.getElementById("on_hold_reason")
                    .addEventListener("keypress", function(event) {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                        var holdReason = document.getElementById("hold_reason").value;
                        var id = document.getElementById('work_order_id').value;
                            var statusData = {
                                    'id' : id,
                                    'status' : 'On Hold',
                                    'reason' : holdReason,
                                };
                        if(holdReason != '') {
                            statusUpdate(statusData);
                        } else {
                            setToastrAlert('error','On hold reason required!');
                        }
                    }
                });
            });

            function statusUpdate(statusData){
                axios.post(`{{route('admin.work-orders.update.bulkStatus')}}`,
                statusData
                ).then(response => {
                    if (response.data.statusCode == 200) {
                        setToastrAlert('success',response.data.message);
                        var url = `{{$work_order_base_url ?? url()->previous()}}`;
                        setTimeout(function(){
                            window.location.href = url;
                        }, 3000);
                    } else {
                        setToastrAlert('error', 'Error occured please try again.');
                    }
                })
            }
            function taskStatus(id) {
                document.getElementById('task-submit-'+id).click();
            }
        </script>
    @endPushOnce
