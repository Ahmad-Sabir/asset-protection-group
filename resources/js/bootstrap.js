import Echo from 'laravel-echo';
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


window.Pusher = require('pusher-js');

let laravelEcho = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_HOST,
    wsPort: process.env.MIX_PUSHER_PORT,
    wssPort: process.env.MIX_PUSHER_PORT,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

function truncate(str, no_words) {
    return str.split(" ").splice(0,no_words).join(" ") + '...';
}

function currentDate() {
    let today = new Date();
    let date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;
    let time = `${today.getHours()}:${today.getMinutes()}:${today.getSeconds()}`;
    return `${date} ${time}`;
}

laravelEcho.private(`workorders.${window.CURRENT_USER_ID}`)
    .listen('.work-order-assigned-event', (workOrder) => {
        axios.get('/admin/notification/' + workOrder.workOrder.id)
        .then(response => {
            if (response.status == 200) {
                document.getElementById('count').innerHTML = ++response.data.data.count;
                const li = document.createElement("li");
                const a = document.createElement("a");
                const span = document.createElement("span");
                const textnode = document.createTextNode(truncate(response.data.data.message, 6));
                li.appendChild(a);
                li.appendChild(span);
                li.classList.add("notification-hover", "text-sm");
                a.appendChild(textnode);
                a.setAttribute('href', `${response.data.data.path}?notification_id=${response.data.id}`);
                span.classList.add("px-2", "text-sm");
                const spanTxt = document.createTextNode(currentDate());
                span.appendChild(spanTxt);
                document.getElementById("notify").prepend(li);
                setToastrAlert('success', response.data.data.message);
            } else {
                setToastrAlert('error', 'Error occured please try again.');
                this.isLoading = false;
            }
        })
        .catch(error => {
            console.log(error);
        });
});
