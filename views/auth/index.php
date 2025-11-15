<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Login/Register</title>
    <link rel="stylesheet" href="public/css/auth.css">
</head>
<body>

    <div class="container" id="container">
        
        <div class="form-container sign-up-container">
            <form action="index.php?action=register" method="POST">
                <h1>Register</h1>
                <input type="text" placeholder="Username" name="username" required />
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Password" name="password" required />
                <input type="password" placeholder="Confirm Password" name="confirm_password" required />
                <button class="form-btn">REGISTER</button>
                <p class="auth-link-mobile">
                    Sudah Punya Akun? <a href="#" id="login-link">Login</a>
                </p>
            </form>
        </div>

        <div class="form-container sign-in-container">
             <form action="index.php?action=login" method="POST">
                <h1>Login</h1>
                <input type="text" placeholder="Email/Username" name="email_username" required />
                <input type="password" placeholder="Password" name="password" required />
                <button class="form-btn">LOGIN</button>
                <p class="auth-link-mobile">
                    Belum Punya Akun? <a href="#" id="register-link">Register</a>
                </p>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Selamat Datang Kembali!</h1>
                    <p>Jika Anda sudah memiliki akun, silakan masuk.</p>
                    <button class="ghost" id="login">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Mulai Perjalanan Kesehatan Anda</h1>
                    <p>Jika Anda belum punya akun, silakan daftar dan bergabung.</p>
                    <button class="ghost" id="register">Register</button>
                </div>
            </div>
        </div>
    </div> 

    <script>
        // Kode Asli dari Gambar Anda
        const registerButton = document.getElementById("register");
        const loginButton = document.getElementById("login");
        const container = document.getElementById("container");

        registerButton.addEventListener("click", () => {
          container.classList.add("right-panel-active");
        });

        loginButton.addEventListener("click", () => {
          container.classList.remove("right-panel-active");
        });

        // Tambahan - Agar link di mobile juga berfungsi
        const registerLink = document.getElementById("register-link");
        const loginLink = document.getElementById("login-link");

        registerLink.addEventListener("click", (e) => {
          e.preventDefault();
          container.classList.add("right-panel-active");
        });

        loginLink.addEventListener("click", (e) => {
          e.preventDefault();
          container.classList.remove("right-panel-active");
        });
    </script>

    </body>
</html>