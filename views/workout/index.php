<?php include 'views/layouts/Header.php'; ?>
<link rel="stylesheet" href="public/css/workout.css">

<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Hitung Kalori</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body bg-danger text-white text-center rounded-3 p-5">
            <h1 class="fw-bold">Workout Calculator</h1>
        </div>
    </div>

    <div class="card shadow-sm p-4 mb-5">
        <h4 class="fw-bold text-center mb-3">Hitung Kalori yang Terbakar</h4>
        <p class="text-center text-muted mb-4">
            Masukkan jenis workout, durasi, dan berat badan untuk menghitung kalori yang terbakar.
        </p>

        <form method="POST" action="?c=workout&m=calculate">
            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Workout</label>
                <select name="workout" class="form-select" required>
                    <option value="">Pilih Jenis Workout</option>
                    <?php foreach ($workouts as $w): ?>
                        <option value="<?= $w['name'] ?>" <?= isset($_POST['workout']) && $_POST['workout'] == $w['name'] ? 'selected' : '' ?>>
                            <?= $w['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Durasi (menit)</label>
                <input type="number" name="duration" class="form-control" placeholder="Masukkan durasi workout" value="<?= $_POST['duration'] ?? '' ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Berat Badan (kg)</label>
                <input type="number" name="weight" class="form-control" placeholder="Masukkan berat badan" value="<?= $_POST['weight'] ?? '' ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-danger px-4 me-2">Hitung Kalori</button>
                <a href="?c=workout&m=index" class="btn btn-outline-secondary px-4">Reset</a>
            </div>
        </form>

        <?php if (isset($result)): ?>
            <div class="alert alert-success text-center mt-4">
                <strong>Kalori Terbakar:</strong> <?= number_format($result, 2) ?> kkal
            </div>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h5 class="fw-bold mb-3">Tips Membakar Kalori Lebih Efektif</h5>
        <ul>
            <li>Kombinasikan cardio dan strength training untuk hasil maksimal</li>
            <li>Tingkatkan intensitas secara bertahap untuk menghindari cedera</li>
            <li>Konsistensi lebih penting daripada intensitas tinggi sesekali</li>
            <li>Jangan lupa pemanasan dan pendinginan untuk mencegah cedera</li>
        </ul>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h5 class="fw-bold mb-3">Jenis Workout & Kalori per Jam</h5>
        <div class="row">
            <?php foreach ($workouts as $w): ?>
                <div class="col-md-4 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span><?= $w['name'] ?></span>
                        <span class="text-danger fw-semibold"><?= round($w['met'] * 70, 0) ?> kal/jam</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="text-muted small mt-2">*Berdasarkan berat badan 70kg. Kalori aktual bervariasi tergantung berat badan dan intensitas.</p>
    </div>

    <div class="card shadow-sm p-4 mb-5">
        <h5 class="fw-bold text-center mb-3">Cara Kerja Kalkulator Kalori</h5>
        <p class="text-center text-muted">
            Kalkulator ini menggunakan nilai MET (Metabolic Equivalent of Task) untuk menghitung kalori yang terbakar berdasarkan rumus:
        </p>
        <p class="text-center fw-bold text-danger">Kalori = MET × Berat Badan (kg) × Durasi (jam)</p>
        <p class="text-center text-muted small">
            Semakin tinggi nilai MET, semakin banyak kalori yang terbakar per satuan waktu.
        </p>
    </div>
</div>







