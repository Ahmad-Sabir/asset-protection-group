<div class="popover-box">
    <x-button type="button" class="btn-outline-primary btn-outline-primary-timer popover-trigger"><em class="fa-solid fa-stopwatch"></em> Start Timer</x-button>
    <div class="popover-content">
        <span class="start-timer"><em class="fa-solid fa-play" id="start-timer"></em><em class="fa-solid fa-pause" id="pause-timer" style="display: none"></em> <span id="timer">hh:mm:ss</span><br><span id="reset-btn">Reset</span></span>
    </div>
</div>

<div class="popover-box ml-2">
    <x-button type="button" class="btn-outline-gray-timer popover-trigger"><em class="fa-solid fa-clock"></em>Log Time</x-button>
    <div class="popover-content">
        <span id="log-time"></span>
    </div>
</div>

@pushOnce('script')

<script>
    var popovers = document.querySelectorAll('.popover-box');
    var popoverTriggers = document.querySelectorAll('.popover-trigger');

    for (var i = 0; i < popoverTriggers.length; i++) {
        popoverTriggers[i].addEventListener('click', function(event) {
            this.parentElement.classList.toggle('popover-active');
        });
    }
    function pad(val) { return (val > 9) ? val : '0' + val;}
        var s = 0; //second
        var m = 0; //minute
        var h = 0; //hour
        var Timer = document.getElementById("timer");
        var SD;

        /* stopwatch */
        function stopwatch() {
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
            Timer.innerHTML = pad(h) + ":" + pad(m) + ":" + pad(s);
        }

        function startTimer() {
        SD = window.setInterval(stopwatch, 1000);
        }

        function pauseTimer() {
        window.clearInterval(SD);
        }

        /* resetStopwatch */
        function resetTimer() {
            s = -1;
            m = 0;
            h = 0;

        window.clearInterval(SD);
        Timer.innerHTML = pad(0) + ":" + pad(0) + ":" + pad(0);
        }

        document.getElementById('start-timer').addEventListener('click', () => {
                document.getElementById("start-timer").style.display = "none";
                document.getElementById("pause-timer").style.display = "inline";
                // startTimestamp = Date.now();
                // localStorage.setItem("start-timestamp", startTimestamp);
                startTimer();
        });

            document.getElementById('pause-timer').addEventListener('click', () => {
                    document.getElementById("pause-timer").style.display = "none";
                    document.getElementById("start-timer").style.display = "inline";
                    pauseTimer();
                    // localStorage.removeItem("start-timestamp");
                    var log = document.getElementById('timer').innerText;
                    var span = document.createElement("span");
                    span.style.display ='block';
                    span.innerHTML=log;
                    document.getElementById('log-time').append(span);
                    let url = "/admin/work-orders/save-log-time/"+log;
                    let xhr = new XMLHttpRequest();

                    xhr.open('get', url, true);
                    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
                    xhr.send();

                    xhr.onload = function () {
                        if(xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);
                            alert(log + 'Log time updated');
                        }
                    }

            });

            document.getElementById('reset-btn').addEventListener('click', () => {
                resetTimer();
            });
        </script>

@endPushOnce
