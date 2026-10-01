document.addEventListener('DOMContentLoaded', function () {
    const chatboxToggle = document.getElementById('chatboxToggle');
    const chatboxWindow = document.getElementById('chatboxWindow');
    const chatboxClose = document.getElementById('chatboxClose');
    const chatboxForm = document.getElementById('chatboxForm');
    const chatboxInput = document.getElementById('chatboxInput');
    const chatboxMessages = document.getElementById('chatboxMessages');
    const chatboxSend = document.getElementById('chatboxSend');

    if (!chatboxToggle || !chatboxWindow) {
        return;
    }

    chatboxToggle.addEventListener('click', function () {
        chatboxWindow.classList.toggle('show');

        if (chatboxWindow.classList.contains('show') && chatboxInput) {
            setTimeout(function () {
                chatboxInput.focus();
            }, 100);
        }
    });

    if (chatboxClose) {
        chatboxClose.addEventListener('click', function () {
            chatboxWindow.classList.remove('show');
        });
    }

    if (!chatboxForm) {
        return;
    }

    chatboxForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const message = chatboxInput.value.trim();

        if (message === '') {
            return;
        }

        addMessage(message, 'user');

        chatboxInput.value = '';
        chatboxInput.disabled = true;
        chatboxSend.disabled = true;

        const loadingMessage = addLoadingMessage();

        try {
            const formData = new FormData();
            formData.append('message', message);

            const response = await fetch('index.php?controller=chatbox&action=send', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            loadingMessage.remove();

            if (data.success) {
                addMessage(data.message, 'bot');
            } else {
                addMessage(data.message || 'Xin lỗi, hiện tại tôi chưa thể trả lời.', 'bot');
            }
        } catch (error) {
            loadingMessage.remove();

            addMessage('Không thể kết nối với trợ lý NamShop. Vui lòng thử lại.', 'bot');

            console.error(error);
        } finally {
            chatboxInput.disabled = false;
            chatboxSend.disabled = false;
            chatboxInput.focus();
        }
    });

    function addMessage(message, sender) {
        const messageWrapper = document.createElement('div');
        const messageContent = document.createElement('div');

        messageWrapper.className = sender === 'user'
            ? 'chat-message user-message'
            : 'chat-message bot-message';

        messageContent.className = 'chat-message-content';
        messageContent.textContent = message;

        messageWrapper.appendChild(messageContent);
        chatboxMessages.appendChild(messageWrapper);

        scrollToBottom();

        return messageWrapper;
    }

    function addLoadingMessage() {
        const messageWrapper = document.createElement('div');
        const messageContent = document.createElement('div');

        messageWrapper.className = 'chat-message bot-message';
        messageContent.className = 'chat-message-content';
        messageContent.textContent = 'Đang trả lời...';

        messageWrapper.appendChild(messageContent);
        chatboxMessages.appendChild(messageWrapper);

        scrollToBottom();

        return messageWrapper;
    }

    function scrollToBottom() {
        chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
    }
});