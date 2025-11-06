<?php
// File: views/auth/Login.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiSehat</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <div class="header-bar">SiSehat</div>
    
    <div class="auth-wrapper"> 
    
        <div class="form-container">
            <h2>LOGIN</h2>
            
            <?php if (!empty($error)): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="message success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form action="index.php?action=login" method="POST">
                <div class="form-group">
                    <label for="email_username">EMAIL/Username</label>
                    <input type="text" id="email_username" name="email_username" required>
                </div>
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-submit" name="login">LOGIN</button>
            </form>
            
            <div class="form-link">
                Belum Punya Akun? <a href="index.php?action=register">Register</a>
            </div>
        </div> </div> </body>
</html>