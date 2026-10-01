
<div class="namshop-chatbox">
    <button type="button" class="chatbox-toggle" id="chatboxToggle" title="Tư vấn cùng NamShop">
        <i class="fa-solid fa-comments"></i>
    </button>

    <div class="chatbox-window" id="chatboxWindow">
        <div class="chatbox-header">
            <div class="chatbox-header-info">
                <div class="chatbox-avatar">
                    <i class="fa-solid fa-robot"></i>
                </div>

                <div>
                    <strong>Trợ lý NamShop</strong>
                    <span><i class="fa-solid fa-circle"></i> Đang hoạt động</span>
                </div>
            </div>

            <button type="button" class="chatbox-close" id="chatboxClose" title="Đóng">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="chatbox-messages" id="chatboxMessages">
            <div class="chat-message bot-message">
                <div class="chat-message-content">
                    Xin chào 👋 Tôi là trợ lý tư vấn của NamShop. Bạn đang tìm loại quần áo nào?
                </div>
            </div>
        </div>

        <form class="chatbox-form" id="chatboxForm">
            <input type="text" id="chatboxInput" placeholder="Nhập tin nhắn..." autocomplete="off">

            <button type="submit" id="chatboxSend" title="Gửi">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>
<script src="public/js/chatbox.js"></script>