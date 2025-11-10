<?php
$pageTitle = $pageTitle ?? "SiSehat"; 
$currentAction = $_GET['action'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle); ?> - SiSehat</title>

  <!-- CSS GLOBAL -->
  <link rel="stylesheet" href="public/css/style.css">

  <!-- CSS HALAMAN KHUSUS -->
<?php 
    if ($currentAction === 'dashboard') {
        echo '<link rel="stylesheet" href="public/css/dashboard.css">';
    } elseif ($currentAction === 'mealplan') {
        echo '<link rel="stylesheet" href="public/css/mealplan.css">';
    } elseif ($currentAction === 'mealplan_detail') {
        echo '<link rel="stylesheet" href="public/css/mealplandetail.css">';
    } elseif ($currentAction === 'kalori') {
        echo '<link rel="stylesheet" href="public/css/kalori.css">';
    }
?>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <header class="navbar">
    <div class="navbar-brand">SiSehat</div>
    <nav class="navbar-links">
      <a href="index.php?action=dashboard">Beranda</a>
      <a href="index.php?action=consultation">Konsultasi</a>
      <a href="index.php?action=bmi">BMI</a>
      <a href="index.php?action=workout">Workout</a>
      <a href="index.php?action=kalori">Kalori Harian</a>
      <a href="index.php?action=mealplan">Meal Plan</a>
      <a href="index.php?action=profile">Profil</a>
      <a href="index.php?action=logout" class="navbar-logout">⛑</a>
    </nav>
  </header>

  <main class="main-content">
