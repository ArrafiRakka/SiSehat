<?php include 'views/layouts/header.php'; ?>

<link rel="stylesheet" href="public/css/consultationhistory.css">

<div class="consultation-history-wrapper">
    <div class="history-header">
        <div class="history-header-content">
            <a href="index.php?action=consultation" class="btn-back-history">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="history-title">Riwayat Konsultasi</h1>
            <p class="history-subtitle">Lihat semua riwayat konsultasi Anda</p>
        </div>
    </div>

    <div class="history-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-message alert-success">
                ✓ <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-message alert-error">
                ⚠ <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($data['consultations'])): ?>
            <div class="empty-history">
                <div class="empty-icon">📋</div>
                <h3>Belum Ada Riwayat Konsultasi</h3>
                <p>Anda belum pernah melakukan konsultasi dengan ahli gizi.</p>
                <a href="index.php?action=consultation" class="btn-start-consultation">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Mulai Konsultasi
                </a>
            </div>
        <?php else: ?>
            <div class="history-list">
                <?php foreach ($data['consultations'] as $consultation): ?>
                    <?php
                    // Status badge
                    $statusClass = '';
                    $statusText = '';
                    switch ($consultation['status']) {
                        case 'active':
                            $statusClass = 'status-active';
                            $statusText = 'Aktif';
                            break;
                        case 'completed':
                            $statusClass = 'status-completed';
                            $statusText = 'Selesai';
                            break;
                        case 'pending':
                            $statusClass = 'status-pending';
                            $statusText = 'Menunggu';
                            break;
                        default:
                            $statusClass = 'status-cancelled';
                            $statusText = 'Dibatalkan';
                    }
                    
                    // Format tanggal
                    $date = new DateTime($consultation['created_at']);
                    $dateFormatted = $date->format('d M Y, H:i');
                    
                    // Get initials for avatar
                    $nameParts = explode(' ', $consultation['nutritionist_name']);
                    $initials = '';
                    foreach ($nameParts as $part) {
                        if (!empty($part)) {
                            $initials .= strtoupper($part[0]);
                            if (strlen($initials) >= 2) break;
                        }
                    }
                    ?>
                    
                    <div class="history-card">
                        <div class="history-card-header">
                            <div class="doctor-info-history">
                                <div class="doctor-avatar-history">
                                    <?= $initials ?>
                                </div>
                                <div class="doctor-details">
                                    <h3 class="doctor-name-history"><?= htmlspecialchars($consultation['nutritionist_name']) ?></h3>
                                    <p class="doctor-specialty-history"><?= htmlspecialchars($consultation['specialty']) ?></p>
                                </div>
                            </div>
                            <span class="status-badge-history <?= $statusClass ?>"><?= $statusText ?></span>
                        </div>
                        
                        <div class="history-card-body">
                            <div class="consultation-meta">
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                    <div class="meta-content">
                                        <span class="meta-label">Tanggal</span>
                                        <span class="meta-value"><?= $dateFormatted ?></span>
                                    </div>
                                </div>
                                
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                        </svg>
                                    </div>
                                    <div class="meta-content">
                                        <span class="meta-label">Pembayaran</span>
                                        <span class="meta-value"><?= ucfirst($consultation['payment_method']) ?></span>
                                    </div>
                                </div>
                                
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                    <div class="meta-content">
                                        <span class="meta-label">Biaya</span>
                                        <span class="meta-value">Rp <?= number_format($consultation['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($consultation['note'])): ?>
                                <div class="consultation-note-section">
                                    <div class="note-label">Catatan Konsultasi</div>
                                    <p class="note-text"><?= nl2br(htmlspecialchars($consultation['note'])) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="history-card-footer">
                            <?php if ($consultation['status'] === 'active'): ?>
                                <a href="index.php?action=consultation_chat&id=<?= $consultation['id'] ?>" 
                                   class="btn-action-history btn-primary-action">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    Lanjutkan Chat
                                </a>
                            <?php elseif ($consultation['status'] === 'completed'): ?>
                                <a href="index.php?action=consultation_result&id=<?= $consultation['id'] ?>" 
                                   class="btn-action-history btn-secondary-action">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                    Lihat Hasil
                                </a>
                            <?php else: ?>
                                <button class="btn-action-history btn-disabled" disabled>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="16" x2="12" y2="12"></line>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                    </svg>
                                    <?= $statusText ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>