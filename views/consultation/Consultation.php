<?php include __DIR__ . '/../layouts/Header.php'; ?>

<div class="consultation-container">
    <h2 class="section-title">Konsultasi dengan Ahli Gizi</h2>
    <p class="section-subtitle">Temukan ahli gizi terbaik untuk membantu kamu menjaga pola makan dan kesehatan tubuh.</p>

    <div class="consultation-search">
        <input type="text" id="searchName" placeholder="Cari berdasarkan nama...">
        <select id="filterGender">
            <option value="">Jenis Kelamin</option>
            <option value="Pria">Pria</option>
            <option value="Wanita">Wanita</option>
        </select>
        <select id="filterPrice">
            <option value="">Tarif Konsultasi</option>
            <option value="25000">&lt; Rp 25.000</option>
            <option value="50000">Rp 25.000 - Rp 50.000</option>
        </select>
    </div>

    <div class="nutritionist-list">
        <?php foreach ($nutritionists as $n): ?>
            <div class="nutritionist-card" data-gender="<?= $n['gender'] ?>" data-price="<?= $n['price'] ?>">
                <img src="<?= $n['img'] ?>" alt="<?= $n['name'] ?>">
                <div class="info">
                    <h3><?= $n['name'] ?></h3>
                    <p class="city"><?= $n['city'] ?></p>
                    <p class="exp">Pengalaman: <?= $n['exp'] ?></p>
                    <p class="price">Tarif: Rp <?= number_format($n['price'], 0, ',', '.') ?>,-</p>
                    <a href="index.php?action=konsultasi_bayar&id=<?= $n['id'] ?>" class="btn">Pilih Konsultasi</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('searchName').addEventListener('input', function() {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.nutritionist-card').forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        card.style.display = name.includes(value) ? 'flex' : 'none';
    });
});
</script>
