<?php
include 'koneksi.php';

if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];
    $query = "SELECT * FROM siswa WHERE nis = '$nis'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }
}

if (isset($_POST['update'])) {
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $id_kelas = $_POST['id_kelas'];
    $id_wali = $_POST['id_wali'];

    $sql = "UPDATE siswa SET 
                nama_siswa='$nama_siswa', 
                jenis_kelamin='$jenis_kelamin',
                tempat_lahir='$tempat_lahir',
                tanggal_lahir='$tanggal_lahir',
                id_kelas='$id_kelas',
                id_wali='$id_wali'
            WHERE nis='$nis'";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}

$kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
$wali = mysqli_query($koneksi, "SELECT * FROM wali_murid");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <h2 class="mb-4">Edit Data Siswa</h2>
    <a href="index.php" class="btn btn-secondary mb-3">← Kembali ke Beranda</a>

    <form method="post" class="card p-4 shadow-sm bg-white">
        <input type="hidden" name="nis" value="<?= $data['nis'] ?>">

        <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" name="nama_siswa" value="<?= htmlspecialchars($data['nama_siswa']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-select" name="jenis_kelamin" required>
                <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" name="tempat_lahir" value="<?= htmlspecialchars($data['tempat_lahir']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select class="form-select" name="id_kelas" required>
                <?php while ($row = mysqli_fetch_assoc($kelas)) : ?>
                    <option value="<?= $row['id_kelas'] ?>" <?= ($row['id_kelas'] == $data['id_kelas']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['nama_kelas']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Wali Murid</label>
            <select class="form-select" name="id_wali" required>
                <?php while ($row = mysqli_fetch_assoc($wali)) : ?>
                    <option value="<?= $row['id_wali'] ?>" <?= ($row['id_wali'] == $data['id_wali']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['nama_wali']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-primary w-100">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
