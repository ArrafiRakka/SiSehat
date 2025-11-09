<?php
// Cek jika variabel $pageTitle tidak ada, beri default
$pageTitle = $pageTitle ?? "SiSehat"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - SiSehat</title>
    <link rel="stylesheet" href="public/css/Style.css">

      <?php 
        $currentAction = $_GET['action'] ?? '';
        if ($currentAction === 'dashboard') {
            echo '<link rel="stylesheet" href="/SiSehat/public/css/dashboard.css">';
        }
        ?>

      <?php 
        // Load CSS tambahan khusus halaman tertentu
        $currentAction = $_GET['action'] ?? '';
        if ($currentAction === 'mealplan') {
            echo '<link rel="stylesheet" href="/SiSehat/public/css/mealplan.css">';
        }
    ?>


</head>

<body>
    
    <header class="navbar">
        <div class="navbar-brand">SiSehat</div>
        <nav class="navbar-links">
            <a href="index.php?action=dashboard">Beranda</a>
            <a href="index.php?action=konsultasi">Konsultasi</a>
            <a href="index.php?action=workout">Workout</a>
            <a href="index.php?action=bmi">Kalori Harian</a> <a href="index.php?action=mealplan">Meal Plan</a>
            <a href="index.php?action=profile">Profil</a>
            <a href="index.php?action=logout" class="navbar-logout">
                ⛑
            </a>
        </nav>
    </header>
    
    <main class="main-content">