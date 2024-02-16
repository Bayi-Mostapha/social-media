import './bootstrap';

const axios = require('axios');

const userid = document.getElementById('auth-user').value;

const channel = Echo.private('private.user.' + userid);
channel.listen('.new-comment', (event) => {
    document.getElementById('notification-bubble').classList.remove('hidden');
})