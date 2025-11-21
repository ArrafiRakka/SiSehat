<?php include 'views/layouts/header.php'; ?>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Rekomendasi Workout</title>
<style>
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #e8dfdfff;
    color: #333;
  }
  a {
    text-decoration: none;
    color: inherit;
  }

  .container {
    max-width: 900px;
    margin: 30px auto 70px auto;
    padding: 0 20px;
  }

  h1.page-title {
    font-weight: 700;
    font-size: 1.35rem;
    margin-bottom: 20px;
  }

  .hero-calculator {
    background-color: #ce4c49;
    color: white;
    font-weight: 600;
    font-size: 2.1rem;
    padding: 50px 20px;
    margin-bottom: 25px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.15);
  }

  .card {
    background-color: #f8f8f8;
    border-radius: 12px;
    padding: 25px 30px;
    margin-bottom: 25px;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.07);
  }

  form h2 {
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 8px;
  }
  form p.description {
    font-weight: 400;
    font-size: 0.9rem;
    color: #777;
    margin-top: 0;
    margin-bottom: 25px;
    line-height: 1.3;
  }
  .form-group {
    margin-bottom: 14px;
  }
  label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 0.9rem;
  }
  select, input[type="text"], input[type="number"] {
    width: 100%;
    padding: 10px 15px;
    border: none;
    border-radius: 10px;
    background-color: #d9d9d9;
    font-size: 0.9rem;
    font-weight: 500;
    color: #666;
    outline-offset: 2px;
  }
  select:focus, input[type="text"]:focus, input[type="number"]:focus {
    outline: 2px solid #ce4c49;
    background-color: #eee;
  }
  
  .btn-group {
    margin-top: 10px;
  }
  button {
    border: none;
    border-radius: 10px;
    padding: 10px 25px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.15);
    margin-right: 10px;
    transition: filter 0.2s ease;
  }
  button.hitunghit {
    background-color: #ce4c49;
    color: white;
  }
  button.hitunghit:hover {
    filter: brightness(0.9);
  }
  button.reset {
    background-color: #eee;
    color: #333;
  }
  button.reset:hover {
    filter: brightness(0.95);
  }

  .tips h2 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 12px;
  }
  .tips ul {
    padding-left: 14px;
    margin-top: 0;
    margin-bottom: 0;
  }
  .tips ul li {
    font-weight: 400;
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 8px;
    line-height: 1.25;
    list-style: disc;
    list-style-position: inside;
    color: #ce4c49;
  }
  .tips ul li::marker {
    color: #ce4c49;
  }

  .calories-table {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap: 12px 20px;
    margin-bottom: 10px;
    font-size: 0.9rem;
  }
  .calories-cell {
    background: white;
    border-radius: 10px;
    padding: 10px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #111;
    box-shadow: 0 2px 4px rgb(0 0 0 / 0.05);
  }
  .calories-cell .workout-name {
    font-weight: 600;
  }
  .calories-cell .calories-value {
    color: #ce4c49;
    font-weight: 700;
    font-size: 0.85rem;
    white-space: nowrap;
  }
  .calories-note {
    font-size: 0.75rem;
    color: #777;
    font-style: italic;
  }

  .calculator-info h2 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 12px;
  }
  .calculator-info p {
    color: #555;
    font-size: 0.9rem;
    line-height: 1.3;
  }
  .formula {
    background: white;
    border-radius: 10px;
    padding: 16px 25px;
    margin: 12px 0 10px 0;
    font-weight: 700;
    color: #ce4c49;
    font-size: 1rem;
    text-align: center;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.10);
  }

</style>
</head>

<div class="container" style="max-width: 900px; margin: 30px auto 70px auto; padding: 0 20px;">
    
    <h1 class="page-title">Rekomendasi Workout</h1>

    <div class="hero-calculator" style="background-color: #ce2b26ff;">
        Buat Rencana Latihan Sesuai Targetmu
    </div>

    <section class="card calculator-form">
        <h2>Buat Rencana Sesi Workout</h2>
        <p class="description">
            Masukkan target kalori, tujuan kebugaran, dan durasi yang kamu miliki untuk mendapatkan rencana latihan yang dipersonalisasi.
        </p>
        
        <form method="POST" action="index.php?action=workout_recommendation">
            <div class="form-group">
                <label for="tujuan">Tujuan Kebugaran</label>
                <select id="tujuan" name="tujuan" aria-label="Pilih Tujuan Kebugaran">
                    <option value="" selected disabled>Pilih Tujuan</option>
                    <?php foreach ($tujuanOptions as $opt): ?>
                        <option value="<?= htmlspecialchars($opt) ?>" <?= ($tujuan === $opt) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="level">Tingkat Kebugaran</label>
                <select id="level" name="level" aria-label="Pilih Tingkat Kebugaran">
                    <option value="" selected disabled>Pilih Level</option>
                    <?php foreach ($levelOptions as $opt): ?>
                        <option value="<?= htmlspecialchars($opt) ?>" <?= ($level === $opt) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="targetKalori">Target Kalori yang Ingin Dibakar (kkal)</label>
                <input type="number" id="targetKalori" name="targetKalori" placeholder="Contoh: 300" min="1" value="<?= htmlspecialchars($targetKalori ?? '') ?>" />
            </div>

            <div class="form-group">
                <label for="duration">Durasi Waktu Tersedia (menit)</label>
                <input type="number" id="duration" name="duration" placeholder="Contoh: 45" min="1" value="<?= htmlspecialchars($duration ?? '') ?>" />
            </div>

            <div class="form-group">
                <label for="beratBadan">Berat Badan Saat Ini (kg)</label>
                <input type="number" id="beratBadan" name="beratBadan" placeholder="Masukkan berat badan" min="1" value="<?= htmlspecialchars($weight ?? '') ?>" />
            </div>
            
            <div class="btn-group">
                <button type="submit" name="request_recommendation" class="hitunghit" style="background-color: #e42e27ff;">
                    Dapatkan Rekomendasi
                </button>
                <button type="reset" class="reset">Reset</button>
            </div>
        </form>
    </section>

    <?php if (isset($recommendationResult) || isset($error)): ?>
    <section class="card hasil-perhitungan" id="hasilRekomendasi">
        <h2>Rencana Sesi Rekomendasi</h2>
        <?php if (!empty($error)): ?>
            <p style="color:#e74c3c; font-weight:600; font-size:0.9rem; margin-top:10px;">
                ⚠️ <?= htmlspecialchars($error) ?>
            </p>
        <?php else: ?>
            <p style="font-weight:600; font-size:1rem; margin-top:10px;">
                Total Estimasi Kalori Terbakar: 
                <span style="color:#3498db; font-size:1.1rem;">
                    <?= number_format($recommendationResult['total_kalori'] ?? 0, 2) ?> kkal
                </span>
                (Durasi Total: <?= $recommendationResult['total_durasi'] ?? 0 ?> menit)
            </p>

            <h3 style="margin-top: 20px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #34495e;">Rincian Sesi</h3>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($recommendationResult['sesi'] as $item): ?>
                    <li style="background: #f8f8f8; padding: 10px 15px; border-radius: 8px; margin-bottom: 10px; display: flex; justify-content: space-between;">
                        <span style="font-weight: 700; color: #ce4c49;">
                            <?= htmlspecialchars($item['fase']) ?>
                        </span>
                        <span>
                            <?= htmlspecialchars($item['nama']) ?> 
                            (<span style="font-weight: 600;"><?= $item['durasi'] ?> menit</span>)
                            <?php if ($item['kalori'] > 0): ?>
                                | 🔥 <?= number_format($item['kalori'], 0) ?> kkal
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <section class="card calculator-form">
    <div style="margin-top: 5px; padding-top: 15px; text-align: center;">
        <p style="margin: 0; font-size: 0.95rem; font-weight: 500;">
           <p style="font-size: 1.3rem; font-weight: 700;">Ingin hitung kalori?</p>
           <a href="index.php?action=workout" style="color: #ce4c49; font-weight: 700; text-decoration: underline;">
                Hitung kalori yang terbakar dari workout sekarang &rarr;
            </a>
        </p>
    </div>
  </section>

</div>

<?php include 'views/layouts/footer.php'; ?>