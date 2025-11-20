<?php include 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 1100px; margin: 40px auto; padding: 0 20px;">
    
    <div style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%); color: white; padding: 40px; border-radius: 15px; margin-bottom: 40px; box-shadow: 0 10px 20px rgba(192, 57, 43, 0.3); position: relative; overflow: hidden;">
        <div style="position: relative; z-index: 2;">
            <h1 style="margin: 0; font-size: 2.2rem;">Selamat Datang, Admin!</h1>
            <p style="margin: 10px 0 0; font-size: 1.1rem; opacity: 0.9;">Panel kontrol utama untuk mengelola konten dan pengguna SiSehat.</p>
        </div>
        <div style="position: absolute; top: -20px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; right: 40px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
        
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #27ae60;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; color: #7f8c8d; font-size: 0.9rem;">Database Makanan</h3>
                    <p style="margin: 5px 0 0; font-size: 2rem; font-weight: bold; color: #2c3e50;">
                        120+
                    </p>
                </div>
                <div style="font-size: 2.5rem; color: #27ae60; opacity: 0.2;">🍎</div>
            </div>
            <a href="index.php?action=admin_food" style="display: block; margin-top: 15px; color: #27ae60; text-decoration: none; font-weight: bold; font-size: 0.9rem;">Kelola Makanan &rarr;</a>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #2980b9;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; color: #7f8c8d; font-size: 0.9rem;">Pengguna Terdaftar</h3>
                    
                    <p style="margin: 5px 0 0; font-size: 2rem; font-weight: bold; color: #2c3e50;">
                        <?= $totalUsers ?>
                    </p>
                </div>
                <div style="font-size: 2.5rem; color: #2980b9; opacity: 0.2;">👥</div>
            </div>
            
            <a href="index.php?action=admin_users" style="display: block; margin-top: 15px; color: #2980b9; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                Lihat Pengguna &rarr;
            </a>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #f39c12;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; color: #7f8c8d; font-size: 0.9rem;">Konsultasi Aktif</h3>
                    <p style="margin: 5px 0 0; font-size: 2rem; font-weight: bold; color: #2c3e50;">
                        3
                    </p>
                </div>
                <div style="font-size: 2.5rem; color: #f39c12; opacity: 0.2;">💬</div>
            </div>
            <a href="#" style="display: block; margin-top: 15px; color: #f39c12; text-decoration: none; font-weight: bold; font-size: 0.9rem;">Cek Pesan &rarr;</a>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #8e44ad;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; color: #7f8c8d; font-size: 0.9rem;">Database Workout</h3>
                    <p style="margin: 5px 0 0; font-size: 2rem; font-weight: bold; color: #2c3e50;">
                        <?= '10+' ?>
                    </p>
                </div>
                <div style="font-size: 2.5rem; color: #8e44ad; opacity: 0.2;">💪</div>
            </div>
            <a href="index.php?action=admin_workouts" style="display: block; margin-top: 15px; color: #8e44ad; text-decoration: none; font-weight: bold; font-size: 0.9rem;">Kelola Workout &rarr;</a>
        </div>

    </div>

    <h3 style="color: #2c3e50; margin-bottom: 20px;">Menu Pengelolaan</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        
        <a href="index.php?action=admin_food" style="text-decoration: none; color: inherit;">
            <div style="background: white; padding: 30px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="background: #e8f5e9; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #27ae60; font-size: 1.5rem;">🥗</div>
                <h4 style="margin: 0; color: #2c3e50;">Kelola Makanan</h4>
                <p style="margin: 10px 0 0; font-size: 0.9rem; color: #7f8c8d;">Tambah, edit, atau hapus data nutrisi makanan.</p>
            </div>
        </a>

        <a href="index.php?action=admin_workouts" style="text-decoration: none; color: inherit;">
            <div style="background: white; padding: 30px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="background: #f1e6f9; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #8e44ad; font-size: 1.5rem;">🏋️</div>
                <h4 style="margin: 0; color: #2c3e50;">Kelola Workout</h4>
                <p style="margin: 10px 0 0; font-size: 0.9rem; color: #7f8c8d;">Tambah, edit, atau hapus jenis workout dan nilai METs.</p>
            </div>
        </a>

        <a href="#" style="text-decoration: none; color: inherit;">
            <div style="background: white; padding: 30px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="background: #fff3e0; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #f39c12; font-size: 1.5rem;">⚙️</div>
                <h4 style="margin: 0; color: #2c3e50;">Pengaturan</h4>
                <p style="margin: 10px 0 0; font-size: 0.9rem; color: #7f8c8d;">Kelola akun admin dan konfigurasi web.</p>
            </div>
        </a>

    </div>

</div>

<?php include 'views/layouts/footer.php'; ?>