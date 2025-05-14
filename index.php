<?php
include 'koneksi.php';

// Ambil data siswa, kelas, dan wali
$query = "SELECT s.*, k.nama_kelas, w.nama_wali 
          FROM siswa s
          JOIN kelas k ON s.id_kelas = k.id_kelas
          JOIN wali_murid w ON s.id_wali = w.id_wali";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #searchInput {
            max-width: 300px;
        }
    </style>
</head>
<body class="p-4">

    <div class="container">
        <h2 class="mb-4">Data Siswa</h2>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="kelola_kelas.php" class="btn btn-primary me-2">Kelola Kelas</a>
                <a href="kelola_wali.php" class="btn btn-primary">Kelola Wali Murid</a>
            </div>
            <input type="text" id="searchInput" onkeyup="cariSiswa()" class="form-control" placeholder="Cari nama atau NIS...">
            <a href="tambah_siswa.php" class="btn btn-success">Tambah Siswa</a>
        </div>

        <table class="table table-bordered table-striped" id="tabelSiswa">
            <thead class="table-dark">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Kelas</th>
                    <th>Wali Murid</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['nis'] ?></td>
                        <td><?= $row['nama_siswa'] ?></td>
                        <td><?= $row['jenis_kelamin'] ?></td>
                        <td><?= $row['tempat_lahir'] ?></td>
                        <td><?= $row['tanggal_lahir'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['nama_wali'] ?></td>
                        <td>
                            <a href="edit_siswa.php?nis=<?= $row['nis'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button onclick="konfirmasiHapus('<?= $row['nis'] ?>', '<?= $row['nama_siswa'] ?>')" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    Apakah Anda yakin ingin menghapus data siswa ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="btnHapus" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Hapus dan Pencarian -->
    <script>
        function konfirmasiHapus(nis, nama) {
            const modalBody = document.getElementById('modal-body');
            const btnHapus = document.getElementById('btnHapus');

            modalBody.innerText = `Apakah Anda yakin ingin menghapus data siswa ${nama}?`;
            btnHapus.href = `hapus_siswa.php?nis=${nis}`;
            new bootstrap.Modal(document.getElementById('modalHapus')).show();
        }

        function cariSiswa() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("tabelSiswa");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const tdNIS = tr[i].getElementsByTagName("td")[0];
                const tdNama = tr[i].getElementsByTagName("td")[1];
                if (tdNIS && tdNama) {
                    const teksNIS = tdNIS.textContent.toLowerCase();
                    const teksNama = tdNama.textContent.toLowerCase();
                    if (teksNIS.includes(filter) || teksNama.includes(filter)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
