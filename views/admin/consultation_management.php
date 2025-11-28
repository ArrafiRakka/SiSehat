<?php include 'views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Konsultasi - Admin SiSehat</title>
    <link rel="stylesheet" href="public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <main class="main-content">
            <header>
                <h1>📋 Kelola Konsultasi</h1>
                <p>Pantau dan kelola seluruh konsultasi pengguna</p>
            </header>

            <?php if(isset($_GET['status'])): ?>
                <div class="alert alert-success">
                    <?php
                    switch($_GET['status']) {
                        case 'deleted': echo '✅ Konsultasi berhasil dihapus'; break;
                        case 'updated': echo '✅ Status konsultasi berhasil diupdate'; break;
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="filter-tabs">
                <a href="index.php?action=admin_consultations&status_filter=all" 
                   class="<?= (!isset($_GET['status_filter']) || $_GET['status_filter'] === 'all') ? 'active' : '' ?>">
                    Semua
                </a>
                <a href="index.php?action=admin_consultations&status_filter=pending" 
                   class="<?= (isset($_GET['status_filter']) && $_GET['status_filter'] === 'pending') ? 'active' : '' ?>">
                    Pending
                </a>
                <a href="index.php?action=admin_consultations&status_filter=active" 
                   class="<?= (isset($_GET['status_filter']) && $_GET['status_filter'] === 'active') ? 'active' : '' ?>">
                    Aktif
                </a>
                <a href="index.php?action=admin_consultations&status_filter=completed" 
                   class="<?= (isset($_GET['status_filter']) && $_GET['status_filter'] === 'completed') ? 'active' : '' ?>">
                    Selesai
                </a>
                <a href="index.php?action=admin_consultations&status_filter=cancelled" 
                   class="<?= (isset($_GET['status_filter']) && $_GET['status_filter'] === 'cancelled') ? 'active' : '' ?>">
                    Dibatalkan
                </a>
            </div>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Ahli Gizi</th>
                            <th>Status</th>
                            <th>Harga</th>
                            <th>Metode Bayar</th>
                            <th>Waktu Mulai</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($consultations)): ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 30px;">
                                    Tidak ada data konsultasi.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($consultations as $c): ?>
                                <tr>
                                    <td>#<?= $c['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($c['username']) ?></strong><br>
                                        <small><?= htmlspecialchars($c['email']) ?></small>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($c['nutritionist_name']) ?></strong><br>
                                        <small><?= htmlspecialchars($c['specialty']) ?></small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($c['status']) ?>">
                                            <?= strtoupper($c['status']) ?>
                                        </span>
                                    </td>
                                    <td>Rp <?= number_format($c['price'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($c['payment_method']) ?></td>
                                    <td>
                                        <?php if($c['start_time']): ?>
                                            <?= date('d/m/Y H:i', strtotime($c['start_time'])) ?>
                                        <?php else: ?>
                                            <em>Belum dimulai</em>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($c['duration_minutes']): ?>
                                            <?= $c['duration_minutes'] ?> menit
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index.php?action=admin_consultation_detail&id=<?= $c['id'] ?>" 
                                           class="btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>