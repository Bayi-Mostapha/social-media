import './bootstrap';

const axios = require('axios');

const form = document.getElementById('form');
const message = document.getElementById('input-message');
const listMessage = document.getElementById('list-messages');
const isTyping = document.getElementById('isTyping');
const isOnline = document.getElementById('isOnline');
const cidInput = document.getElementById('cid');
const other_id = parseInt(document.getElementById('other_id').value);
const error = document.getElementById('error');

scrollDown();

const channel = Echo.join('presence.chat.' + cidInput.value);

message.addEventListener('input', () => {
    if (message.value === '') {
        channel.whisper('stopTyping', {});
    } else {
        channel.whisper('typing', {});
    }
});

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const userInput = message.value;
    if (userInput === '') {
        error.classList.remove('hidden');
        return;
    }
    const cid = cidInput.value;
    axios.post('/chat-message', {
        message: userInput,
        cid: cid
    });
    message.value = '';
    channel.whisper('stopTyping', {});
    error.classList.add('hidden');
});

channel.here((users) => {
    const idExists = users.some(obj => obj.id === other_id);
    if (idExists) {
        isOnline.classList.add('bg-green-500');
        isOnline.classList.remove('bg-red-500');
    } else {
        isOnline.classList.remove('bg-green-500');
        isOnline.classList.add('bg-red-500');
    }
})
    .joining((user) => {
        isOnline.classList.add('bg-green-500');
        isOnline.classList.remove('bg-red-500');
    })
    .leaving((user) => {
        isOnline.classList.remove('bg-green-500');
        isOnline.classList.add('bg-red-500');
    })
    .listen('.chat', (event) => {
        renderMessage(event.user.id, event.user.name, event.message);
    })
    .listenForWhisper('typing', (e) => {
        isTyping.textContent = 'typing...';
    })
    .listenForWhisper('stopTyping', (e) => {
        isTyping.textContent = '';
    });

function renderMessage(uid, uname, value) {
    const li = document.createElement('li');
    const p1 = document.createElement('p');
    p1.classList.add('text-sm', 'text-gray-400');
    p1.textContent = uname;
    const p2 = document.createElement('p');
    p2.classList.add('font-semibold');
    p2.textContent = value;
    li.append(p1);
    li.append(p2);
    li.classList.add('my-2', 'p-3', 'rounded-md', 'w-fit');
    if (uid !== other_id) {
        li.classList.add('ml-auto', 'bg-blue-100');
    } else {
        li.classList.add('bg-gray-100');
    }

    listMessage.append(li);
    scrollDown();
}

function scrollDown() {
    listMessage.scrollTop = listMessage.scrollHeight;
}