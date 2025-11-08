<?php include 'views/layouts/Header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Workout Calculator</title>
<style>
  /* Reset & Base */
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #fff;
    color: #333;
  }
  a {
    text-decoration: none;
    color: inherit;
  }

  /* Container */
  .container {
    max-width: 900px;
    margin: 30px auto 70px auto;
    padding: 0 20px;
  }

  /* Heading */
  h1.page-title {
    font-weight: 700;
    font-size: 1.35rem;
    margin-bottom: 20px;
  }

  /* Workout Calculator Hero */
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

  /* Card style shared */
  .card {
    background-color: #f8f8f8;
    border-radius: 12px;
    padding: 25px 30px;
    margin-bottom: 25px;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.07);
  }

  /* Form */
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
  
  /* Buttons */
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

  /* Tips list */
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

  /* Workout & calories table-like cards: */
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

  /* Calculator explanation card */
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
<body>


<div class="container">
  <h1 class="page-title">Hitung Kalori</h1>

  <div class="hero-calculator">
    Workout Calculator
  </div>

  <section class="card calculator-form">
    <h2>Hitung Kalori yang Terbakar</h2>
    <p class="description">
      Ingin tahu seberapa efektif workout kamu? Masukkan jenis workout, durasi, dan berat badan untuk menghitung kalori yang terbakar.
    </p>
    <form method = "post" action="index.php?action=workout">
      <div class="form-group">
        <label for="jenisWorkout">Jenis Workout</label>
        <select id="jenisWorkout" name="jenisWorkout" aria-label="Pilih Jenis Workout">
          <option value="" selected disabled>Pilih Jenis Workout</option>
          <option value="lari">Lari</option>
          <option value="berenang">Berenang</option>
          <option value="situp">Sit-up</option>
          <option value="angkatBeban">Angkat Beban</option>
          <option value="zumba">Zumba</option>
          <option value="bersepeda">Bersepeda</option>
          <option value="pushup">Push-up</option>
          <option value="yoga">Yoga</option>
          <option value="aerobik">Aerobik</option>
          <option value="jumpingJack">Jumping Jack</option>
        </select>
      </div>
      <div class="form-group">
        <label for="durasi">Durasi (menit)</label>
        <input type="number" id="durasi" name="durasi" placeholder="Masukkan durasi workout" min="1" />
      </div>
      <div class="form-group">
        <label for="beratBadan">Berat Badan (kg)</label>
        <input type="number" id="beratBadan" name="beratBadan" placeholder="Masukkan berat badan" min="1" />
      </div>
      <div class="btn-group">
        <button type="submit" class="hitunghit">Hitung Kalori</button>
        <button type="reset" class="reset">Reset</button>
      </div>
    </form>
  </section>

  <?php if (isset($caloriesResult) || isset($error)): ?>
  <section class="card hasil-perhitungan" id="hasilKalori">
    <h2>Hasil Perhitungan Kalori</h2>
    <?php if (!empty($error)): ?>
      <p style="color:#ce4c49; font-weight:600; font-size:0.9rem; margin-top:10px;">
        ⚠️ <?= htmlspecialchars($error) ?>
      </p>
    <?php elseif (!empty($caloriesResult)): ?>
      <p style="font-weight:600; font-size:1rem; margin-top:10px;">
        Kamu membakar sekitar 
        <span style="color:#ce4c49; font-size:1.1rem;">
          <?= number_format($caloriesResult, 2) ?> kalori
        </span> 
        dari workout <strong><?= htmlspecialchars($workouts[$selectedKey]['name'] ?? $selectedKey) ?></strong>
        selama <?= htmlspecialchars($duration) ?> menit.
      </p>
    <?php endif; ?>
  </section>
  <?php endif; ?>



  <section class="card tips">
    <h2>Tips Membakar Kalori Lebih Efektif</h2>
    <ul>
      <li>Kombinasikan cardio dan strength training untuk hasil maksimal</li>
      <li>Tingkatkan intensitas secara bertahap untuk menghindari cedera</li>
      <li>Konsistensi lebih penting daripada intensitas tinggi sesekali</li>
      <li>Jangan lupa pemanasan dan pendinginan untuk mencegah cedera</li>
    </ul>
  </section>

  <section class="card calories-table-section">
    <h2>Jenis Workout & Kalori per Jam</h2>
    <div class="calories-table">
      <div class="calories-cell">
        <span class="workout-name">Lari</span>
        <span class="calories-value">560 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Bersepeda</span>
        <span class="calories-value">476 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Berenang</span>
        <span class="calories-value">490 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Push-up</span>
        <span class="calories-value">266 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Sit-up</span>
        <span class="calories-value">266 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Yoga</span>
        <span class="calories-value">175 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Angkat Beban</span>
        <span class="calories-value">420 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Aerobik</span>
        <span class="calories-value">511 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Zumba</span>
        <span class="calories-value">616 kal/jam</span>
      </div>
      <div class="calories-cell">
        <span class="workout-name">Jumping Jack</span>
        <span class="calories-value">560 kal/jam</span>
      </div>
    </div>
    <p class="calories-note">
      *Berdasarkan berat badan 70kg. Kalori aktual bervariasi tergantung berat badan dan intensitas.
    </p>
  </section>

  <section class="card calculator-info">
    <h2>Cara Kerja Kalkulator Kalori</h2>
    <p>
      Kalkulator ini menggunakan nilai MET (Metabolic Equivalent of Task) untuk menghitung kalori yang terbakar berdasarkan rumus:
    </p>
    <div class="formula">
      Kalori = MET × Berat Badan (kg) × Durasi (jam)
    </div>
    <p>
      MET adalah ukuran intensitas aktivitas fisik. Semakin tinggi nilai MET, semakin banyak kalori yang terbakar per unit waktu.
    </p>
  </section>
</div>

<script>
  // Setelah halaman dimuat
  document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const hasil = document.getElementById("hasilKalori");

    // Hanya jalan kalau ada hasil dan user baru submit form
    if (hasil && window.location.href.includes("hitung")) {
      hasil.scrollIntoView({ behavior: "smooth", block: "start" });
    }

    // Tambahkan event listener untuk kirim form
    form?.addEventListener("submit", function() {
      // Delay kecil biar scroll terjadi setelah reload selesai
      setTimeout(() => {
        const hasilBaru = document.getElementById("hasilKalori");
        if (hasilBaru) {
          hasilBaru.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }, 500);
    });
  });
</script>


</body>
</html>