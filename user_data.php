<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th class="w-25">Profile</th>
            <th class="w-25">Username</th>
            <th class="w-25">Aksi</th>
        </tr>
    </thead>
    <tbody>
<?php
include "koneksi.php";

$hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
$limit = 3;
$limit_start = ($hlm - 1) * $limit;
$no = $limit_start + 1;

$sql = "SELECT * FROM user ORDER BY id DESC LIMIT $limit_start, $limit";
$hasil = $conn->query($sql);

while ($row = $hasil->fetch_assoc()) {
?>
<tr>
    <td><?= $no++ ?></td>
    <td>
        <?php if ($row['foto'] && file_exists('img/'.$row['foto'])) { ?>
            <img src="img/<?= $row['foto'] ?>" width="60">
        <?php } ?>
    </td>
    <td><?= $row['username'] ?></td>
    <td>
    <a href="#" class="badge rounded-pill text-bg-success btn-edit"
       data-id="<?= $row['id'] ?>"
       data-username="<?= $row['username'] ?>"
       data-foto="<?= $row['foto'] ?>">
       <i class="bi bi-pencil"></i>
    </a>

    <a href="#" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>">
       <i class="bi bi-x-circle"></i>
    </a>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus<?= $row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Konfirmasi Hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="">
                    <div class="modal-body">
                        Yakin hapus user <strong><?= $row['username'] ?></strong> ?
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="foto" value="<?= $row['foto'] ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" name="hapus" value="Hapus" class="btn btn-danger">
                    </div>
                </form>
            </div>
        </div>
    </div>
</td>

</tr>
<?php } ?>
    </tbody>
</table>
