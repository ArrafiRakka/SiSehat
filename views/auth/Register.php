<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SiSehat</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="header-bar">SiSehat</div>
    <div class="form-container">
        <h2>REGISTER</h2>

        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">CONFIRM PASSWORD</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn-submit" name="register">REGISTER</button>
        </form>
        <div class="form-link">
            Sudah Punya Akun? <a href="index.php?action=login">Login</a>
        </div>
    </div>
</body>
</html>