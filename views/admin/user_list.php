<?php include 'views/layouts/header.php'; ?>

<style>
    .admin-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Segoe UI', sans-serif;
    }
    .admin-card {
        background: white;
        padding: 0; /* Padding 0 karena ada tabel */
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .table-header {
        padding: 20px 30px;
        border-bottom: 1px solid #eee;
        background: #fff;
    }
    .user-table {
        width: 100%;
        border-collapse: collapse;
    }
    .user-table th {
        background: #f8f9fa;
        padding: 15px 20px;
        text-align: left;
        font-size: 0.9rem;
        color: #666;
        border-bottom: 2px solid #eee;
    }
    .user-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    /* Badge Role */
    .role-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
    }
    .role-admin { background: #e3f2fd; color: #1565c0; }
    .role-user { background: #e8f5e9; color: #2e7d32; }

    /* Avatar Kecil */
    .user-avatar-sm {
        width: 35px;
        height: 35px;
        background: #db5757;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.85rem;
        margin-right: 10px;
    }
    .user-info {
        display: flex;
        align-items: center;
    }
</style>

<div class="admin-container">
    
    <div style="margin-bottom: 25px; text-align: center;">
        <h2 style="margin: 0; color: #2c3e50;">Kelola Pengguna</h2>
        <p style="margin: 5px 0 0; color: #7f8c8d;">Daftar semua pengguna yang terdaftar di SiSehat.</p>
    </div>

    <div class="admin-card">
        <div class="table-header">
            <h3 style="margin: 0; font-size: 1.1rem; color: #333;">Daftar User (Total: <?= count($users) ?>)</h3>
        </div>

        <div style="overflow-x: auto;">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <?php 
                            // Inisial Avatar
                            $initial = strtoupper(substr($u['username'], 0, 2));
                        ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-sm"><?= $initial ?></div>
                                    <span style="font-weight: 600; color: #333;"><?= htmlspecialchars($u['username']) ?></span>
                                </div>
                            </td>
                            <td style="color: #555;"><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <?php if ($u['role'] === 'admin'): ?>
                                    <span class="role-badge role-admin">Admin</span>
                                <?php else: ?>
                                    <span class="role-badge role-user">User</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="index.php?action=admin_users&delete_id=<?= $u['id'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus user <?= htmlspecialchars($u['username']) ?>? Data ini tidak bisa dikembalikan.')"
                                   style="color: #e74c3c; text-decoration: none; font-weight: bold; font-size: 0.9rem; border: 1px solid #e74c3c; padding: 6px 12px; border-radius: 6px;">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>