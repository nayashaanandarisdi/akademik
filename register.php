<?php
include "koneksi.php";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, nama_lengkap) VALUES ('$username', '$password', '$nama')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Registrasi Berhasil! Silahkan Login.'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SI Akademik PNP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .reg-container { margin-top: 60px; max-width: 450px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container reg-container">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold">Buat Akun Baru</h4>
                <p class="text-muted">Lengkapi data di bawah ini</p>
            </div>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama sesuai KTM" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Gunakan NIM atau Nama" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>
                <button type="submit" name="register" class="btn btn-success w-100 mb-3" style="border-radius: 10px; padding: 10px;">Daftar Sekarang</button>
            </form>
            <div class="text-center">
                <small>Sudah punya akun? <a href="login.php" class="text-decoration-none">Login</a></small>
            </div>
        </div>
    </div>
</body>
</html>