<div class="chat-container">
    <h2 class="section-title">Chat Konsultasi</h2>
    <p class="section-subtitle">Mulai percakapan dengan ahli gizi untuk konsultasi langsung.</p>

    <div class="chat-box" id="chatBox">
        <div class="message left">
            <div class="bubble">Halo, selamat datang di sesi konsultasi! Silakan ceritakan kondisi Anda.</div>
        </div>
        <div class="message right">
            <div class="bubble">Halo dok, saya ingin tahu tentang pola makan sehat untuk berat badan ideal.</div>
        </div>
    </div>

    <form id="chatForm" class="chat-input" onsubmit="sendMessage(event)">
        <input type="text" id="chatMessage" placeholder="Ketik pesan..." required>
        <button type="submit">Kirim</button>
    </form>

    <div class="chat-footer">
        <a href="index.php?action=konsultasi_hasil" class="btn btn-success">Akhiri & Lihat Hasil Konsultasi</a>
    </div>
</div>

<script>
function sendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('chatMessage');
    const msg = input.value.trim();
    if (!msg) return;
    const box = document.getElementById('chatBox');

    const newMsg = document.createElement('div');
    newMsg.classList.add('message', 'right');
    newMsg.innerHTML = `<div class="bubble">${msg}</div>`;
    box.appendChild(newMsg);
    input.value = '';
    box.scrollTop = box.scrollHeight;
}
</script>
