<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $sql = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
    mysqli_query($koneksi, $sql);
}

if (isset($_GET['hapus'])) {
    $id_kelas = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas = $id_kelas");
}

$result = mysqli_query($koneksi, "SELECT * FROM kelas");

if (isset($_POST['update'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    mysqli_query($koneksi, "UPDATE kelas SET nama_kelas = '$nama_kelas' WHERE id_kelas = $id_kelas");
    header("Location: kelola_kelas.php");
    exit;
}

$kelas_edit = null;
if (isset($_GET['edit'])) {
    $id_kelas = $_GET['edit'];
    $result_edit = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas = $id_kelas");
    $kelas_edit = mysqli_fetch_assoc($result_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Kelola Kelas</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Beranda</a>

    <div class="card p-4 mb-4 shadow-sm">
        <form method="post" class="row g-3">
            <input type="hidden" name="id_kelas" value="<?= $kelas_edit['id_kelas'] ?? '' ?>">
            <div class="col-md-8">
                <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas" required value="<?= $kelas_edit['nama_kelas'] ?? '' ?>">
            </div>
            <div class="col-md-4">
                <?php if ($kelas_edit) : ?>
                    <button type="submit" name="update" class="btn btn-warning w-100">Perbarui</button>
                <?php else : ?>
                    <button type="submit" name="tambah" class="btn btn-success w-100">Tambah</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1; 
            while ($data = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($data['nama_kelas']) ?></td>
                <td>
                    <a class="btn btn-sm btn-primary" href="?edit=<?= $data['id_kelas'] ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="?hapus=<?= $data['id_kelas'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
