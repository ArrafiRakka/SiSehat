<link rel="stylesheet" href="public/css/consultation.css">
<link rel="stylesheet" href="public/css/consultationchat.css">

<?php include 'views/layouts/header.php'; ?>

<?php
// Ambil data dari POST (dari payment page)
$doctorName = $_POST['doctor_name'] ?? 'Dr. Fitri Ananda, S.Gz';
$doctorId = $_POST['doctor_id'] ?? '1';
$doctorSpecialty = $_POST['doctor_specialty'] ?? 'Gizi Klinis';
$doctorCity = $_POST['doctor_city'] ?? 'Jakarta';
$doctorImg = $_POST['doctor_img'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($doctorName) . '&background=2D9CDB&color=fff&size=80';
?>

<div class="chat-page-wrapper">
    <!-- Sidebar Info Dokter -->
    <div class="chat-sidebar">
        <div class="doctor-profile-card">
            <div class="doctor-profile-header">
                <img src="<?= $doctorImg ?>" alt="<?= $doctorName ?>" class="doctor-profile-img">
                <span class="status-badge online">● Online</span>
            </div>
            <h3 class="doctor-profile-name"><?= $doctorName ?></h3>
            <p class="doctor-profile-specialty"><?= $doctorSpecialty ?></p>
            <p class="doctor-profile-location">📍 <?= $doctorCity ?></p>
            
            <div class="profile-divider"></div>
            
            <div class="consultation-info">
                <h4>Informasi Konsultasi</h4>
                <div class="info-item-small">
                    <span class="info-label">Mulai:</span>
                    <span class="info-value"><?= date('H:i') ?></span>
                </div>
                <div class="info-item-small">
                    <span class="info-label">Status:</span>
                    <span class="info-value status-active">Aktif</span>
                </div>
            </div>
        </div>

        <button class="btn-end-sidebar" onclick="endConsultation()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"></path>
            </svg>
            Akhiri Konsultasi
        </button>
    </div>

    <!-- Main Chat Area -->
    <div class="chat-main-area">
        <!-- Chat Header -->
        <div class="chat-header-modern">
            <div class="chat-header-left">
                <a href="index.php?action=consultation" class="btn-back-arrow">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="header-doctor-info">
                    <img src="<?= $doctorImg ?>" alt="<?= $doctorName ?>" class="header-doctor-avatar">
                    <div>
                        <h3 class="header-doctor-name"><?= $doctorName ?></h3>
                        <span class="header-status">● Online</span>
                    </div>
                </div>
            </div>
            <div class="chat-header-actions">
                <button class="icon-btn" title="Info">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages-modern" id="chatMessages">
            <!-- Welcome Card -->
            <div class="welcome-card">
                <div class="welcome-icon">👋</div>
                <h3>Selamat Datang di Konsultasi</h3>
                <p>Mulai percakapan dengan ahli gizi untuk konsultasi langsung.</p>
            </div>

            <!-- Pesan sambutan dari dokter -->
            <div class="message-wrapper doctor-wrapper">
                <img src="<?= $doctorImg ?>" alt="<?= $doctorName ?>" class="message-avatar-modern">
                <div class="message-bubble doctor-bubble">
                    <div class="message-header-bubble">
                        <span class="sender-name"><?= $doctorName ?></span>
                    </div>
                    <p class="message-text">Halo, selamat datang di sesi konsultasi! Silakan ceritakan kondisi Anda.</p>
                    <span class="message-time-bubble"><?= date('H:i') ?></span>
                </div>
            </div>

            <div class="message-wrapper doctor-wrapper">
                <img src="<?= $doctorImg ?>" alt="<?= $doctorName ?>" class="message-avatar-modern">
                <div class="message-bubble doctor-bubble">
                    <p class="message-text">Halo dok, saya ingin tahu tentang pola makan sehat untuk berat badan ideal.</p>
                    <span class="message-time-bubble"><?= date('H:i', strtotime('+1 minute')) ?></span>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-modern">
            <form id="chatForm" class="chat-form-modern">
                <button type="button" class="btn-attachment" title="Lampiran">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                </button>
                
                <div class="input-wrapper-modern">
                    <textarea 
                        id="messageInput" 
                        class="chat-input-field" 
                        placeholder="Ketik pesan..." 
                        rows="1"
                        required></textarea>
                </div>

                <button type="submit" class="btn-send-modern">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const doctorImg = '<?= $doctorImg ?>';
const doctorName = '<?= $doctorName ?>';

// Auto-resize textarea
const messageInput = document.getElementById('messageInput');
messageInput.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Handle form submit
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const message = messageInput.value.trim();
    if (!message) return;
    
    addMessage(message, 'user');
    
    messageInput.value = '';
    messageInput.style.height = 'auto';
    
    // Simulasi typing indicator
    showTypingIndicator();
    
    setTimeout(() => {
        hideTypingIndicator();
        const responses = [
            'Terima kasih atas informasinya. Bisakah Anda ceritakan lebih detail tentang pola makan Anda saat ini?',
            'Saya mengerti. Berapa lama Anda mengalami kondisi ini?',
            'Baik, untuk mencapai berat badan ideal, saya sarankan mengatur porsi makan dan rutin olahraga.',
            'Apakah ada riwayat penyakit atau alergi makanan tertentu yang perlu saya ketahui?',
            'Saya akan buatkan rencana makan yang sesuai dengan kebutuhan kalori harian Anda.'
        ];
        const randomResponse = responses[Math.floor(Math.random() * responses.length)];
        addMessage(randomResponse, 'doctor');
    }, 2000);
});

function addMessage(text, sender) {
    const chatMessages = document.getElementById('chatMessages');
    const messageWrapper = document.createElement('div');
    messageWrapper.className = `message-wrapper ${sender}-wrapper`;
    
    const currentTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    if (sender === 'doctor') {
        messageWrapper.innerHTML = `
            <img src="${doctorImg}" alt="${doctorName}" class="message-avatar-modern">
            <div class="message-bubble doctor-bubble">
                <div class="message-header-bubble">
                    <span class="sender-name">${doctorName}</span>
                </div>
                <p class="message-text">${text}</p>
                <span class="message-time-bubble">${currentTime}</span>
            </div>
        `;
    } else {
        messageWrapper.innerHTML = `
            <div class="message-bubble user-bubble">
                <p class="message-text">${text}</p>
                <span class="message-time-bubble">${currentTime}</span>
            </div>
        `;
    }
    
    chatMessages.appendChild(messageWrapper);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function showTypingIndicator() {
    const chatMessages = document.getElementById('chatMessages');
    const indicator = document.createElement('div');
    indicator.className = 'message-wrapper doctor-wrapper typing-indicator-wrapper';
    indicator.id = 'typingIndicator';
    indicator.innerHTML = `
        <img src="${doctorImg}" alt="${doctorName}" class="message-avatar-modern">
        <div class="typing-indicator">
            <span></span>
            <span></span>
            <span></span>
        </div>
    `;
    chatMessages.appendChild(indicator);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function hideTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.remove();
    }
}

function endConsultation() {
    if (confirm('Apakah Anda yakin ingin mengakhiri konsultasi?')) {
        window.location.href = 'index.php?action=consultation_result';
    }
}
</script>

<?php include 'views/layouts/footer.php'; ?>