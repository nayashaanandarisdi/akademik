<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$username_session = $_SESSION['username'];
$success = false;
$error = false;

$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username_session'");
$data = mysqli_fetch_assoc($query_user);

if (isset($_POST['update'])) {
    $nama_baru = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $password_baru = $_POST['password'];

    if (!empty($password_baru)) {

        $password_hashed = password_hash($password_baru, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET nama_lengkap = '$nama_baru', password = '$password_hashed' WHERE username = '$username_session'";
    } else {
        $sql = "UPDATE users SET nama_lengkap = '$nama_baru' WHERE username = '$username_session'";
    }

    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['nama'] = $nama_baru;
        $success = "Profil berhasil diperbarui!";
        
        $query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username_session'");
        $data = mysqli_fetch_assoc($query_user);
    } else {
        $error = "Gagal memperbarui profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SI Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .profile-container { margin-top: 50px; max-width: 500px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Akademik</a>
    <div class="navbar-nav ms-auto">
        <a class="nav-link" href="index.php">Home</a>
        <a class="nav-link active" href="profile.php">Profil</a>
        <a class="nav-link text-danger" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container profile-container">
    <div class="card p-4">
        <h4 class="fw-bold text-center mb-4">Edit Profil</h4>

        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">USERNAME (Tidak dapat diubah)</label>
                <input type="text" class="form-control bg-light" value="<?php echo $data['username']; ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $data['nama_lengkap']; ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Kata Sandi Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                <small class="text-muted italic text-sm">*Isi hanya jika ingin mengganti password</small>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-outline-secondary">Kembali ke Home</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>