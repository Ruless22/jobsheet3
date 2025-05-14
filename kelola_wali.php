<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $nama_wali = $_POST['nama_wali'];
    $kontak = $_POST['kontak'];
    $sql = "INSERT INTO wali_murid (nama_wali, kontak) VALUES ('$nama_wali','$kontak')";
    mysqli_query($koneksi, $sql);
}

if (isset($_GET['hapus'])) {
    $id_wali = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM wali_murid WHERE id_wali = $id_wali");
}

if (isset($_POST['update'])) {
    $id_wali = $_POST['id_wali'];
    $nama_wali = $_POST['nama_wali'];
    $kontak = $_POST['kontak'];
    mysqli_query($koneksi, "UPDATE wali_murid SET nama_wali = '$nama_wali', kontak = '$kontak' WHERE id_wali = $id_wali");
    header("Location: kelola_wali.php");
    exit;
}

$result = mysqli_query($koneksi, "SELECT * FROM wali_murid");

$wali_edit = null;
if (isset($_GET['edit'])) {
    $id_wali = $_GET['edit'];
    $result_edit = mysqli_query($koneksi, "SELECT * FROM wali_murid WHERE id_wali = $id_wali");
    $wali_edit = mysqli_fetch_assoc($result_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Wali Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Kelola Wali Murid</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="card p-4 mb-4 shadow-sm">
        <form method="post">
            <input type="hidden" name="id_wali" value="<?= $wali_edit['id_wali'] ?? '' ?>">

            <div class="mb-3">
                <label class="form-label">Nama Wali Murid:</label>
                <input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali Murid" required value="<?= $wali_edit['nama_wali'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Kontak:</label>
                <input type="text" name="kontak" class="form-control" placeholder="Kontak" required value="<?= $wali_edit['kontak'] ?? '' ?>">
            </div>

            <?php if ($wali_edit) : ?>
                <button type="submit" name="update" class="btn btn-warning">Perbarui</button>
            <?php else : ?>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
            <?php endif; ?>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Wali Murid</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $i = 1; 
        while ($data = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['nama_wali'] ?></td>
                <td><?= $data['kontak'] ?></td>
                <td>
                    <a class="btn btn-sm btn-primary" href="?edit=<?= $data['id_wali'] ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="?hapus=<?= $data['id_wali'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
