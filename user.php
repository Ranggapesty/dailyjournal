<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>

    <div class="row">
        <div class="table-responsive" id="user_data"></div>

        <!-- Modal Tambah/Edit -->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="judulModal">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="foto_lama" id="foto_lama">

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                                <small class="text-muted">Kosongkan saat edit jika tidak ingin mengubah</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
$(document).ready(function(){
    load_data();

    function load_data(hlm){
        $.ajax({
            url : "user_data.php",
            method : "POST",
            data : { hlm: hlm },
            success : function(data){
                $('#user_data').html(data);
            }
        })
    }

    $(document).on('click', '.halaman', function(){
        var hlm = $(this).attr("id");
        load_data(hlm);
    });

    $(document).on('click', '.btn-edit', function(){
        $('#judulModal').text('Edit User');
        $('#id').val($(this).data('id'));
        $('#username').val($(this).data('username'));
        $('#foto_lama').val($(this).data('foto'));
        $('#modalTambah').modal('show');
    });

    $(document).on('click', '[data-bs-target="#modalTambah"]', function(){
        $('#judulModal').text('Tambah User');
        $('#id').val('');
        $('#username').val('');
        $('#foto_lama').val('');
    });
});
</script>

<?php
include "koneksi.php";
include "upload_foto.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $foto = '';
    $nama_foto = $_FILES['foto']['name'] ?? '';

    if ($nama_foto != '') {
        $cek = upload_foto($_FILES["foto"]);
        if ($cek['status']) {
            $foto = $cek['message'];
        } else {
            echo "<script>alert('".$cek['message']."');document.location='admin.php?page=user';</script>";
            die;
        }
    }

    if ($id != '') {
        // EDIT
        if ($nama_foto == '') {
            $foto = $_POST['foto_lama'];
        } else if ($_POST['foto_lama'] != '') {
            unlink("img/" . $_POST['foto_lama']);
        }

        if ($password != '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE user SET username=?, password=?, foto=? WHERE id=?");
            $stmt->bind_param("sssi", $username, $hash, $foto, $id);
        } else {
            $stmt = $conn->prepare("UPDATE user SET username=?, foto=? WHERE id=?");
            $stmt->bind_param("ssi", $username, $foto, $id);
        }
    } else {
        // TAMBAH (password wajib hash)
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO user (username,password,foto) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $hash, $foto);
    }

    $simpan = $stmt->execute();
    echo $simpan
        ? "<script>alert('Simpan sukses');document.location='admin.php?page=user';</script>"
        : "<script>alert('Simpan gagal');document.location='admin.php?page=user';</script>";

    $stmt->close();
    $conn->close();
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $foto = $_POST['foto'];

    if ($foto != '' && file_exists("img/".$foto)) {
        unlink("img/".$foto);
    }

    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    echo $hapus
        ? "<script>alert('Hapus sukses');document.location='admin.php?page=user';</script>"
        : "<script>alert('Hapus gagal');document.location='admin.php?page=user';</script>";

    $stmt->close();
    $conn->close();
}

?>
</div>
