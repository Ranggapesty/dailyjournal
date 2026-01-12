<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Gallery
    </button>

    <div class="row">
        <div class="table-responsive" id="gallery_data"></div>

        <!-- Awal Modal Tambah/Edit-->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="judulModal">Tambah gallery</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="post" action="" enctype="multipart/form-data">
                        <!-- penting untuk edit -->
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="gambar_lama" id="gambar_lama">

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar">
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
        <!-- Akhir Modal -->

<script>
$(document).ready(function(){
    load_data();

    function load_data(hlm){
        $.ajax({
            url : "gallery_data.php",
            method : "POST",
            data : { hlm: hlm },
            success : function(data){
                $('#gallery_data').html(data);
            }
        })
    }

    $(document).on('click', '.halaman', function(){
        var hlm = $(this).attr("id");
        load_data(hlm);
    });

    // saat klik edit
    $(document).on('click', '.btn-edit', function(){
        $('#judulModal').text('Edit Gallery');
        $('#id').val($(this).data('id'));
        $('#gambar_lama').val($(this).data('gambar'));
        $('#modalTambah').modal('show');
    });

    // saat klik tambah (reset)
    $(document).on('click', '[data-bs-target="#modalTambah"]', function(){
        $('#judulModal').text('Tambah Gallery');
        $('#id').val('');
        $('#gambar_lama').val('');
    });
});
</script>

<?php
include "upload_foto.php";

if (isset($_POST['simpan'])) {
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'] ?? '';

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>alert('".$cek_upload['message']."');document.location='admin.php?page=gallery';</script>";
            die;
        }
    }

    if (!empty($_POST['id'])) {
        // UPDATE
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            if ($_POST['gambar_lama'] != '') {
                unlink("img/" . $_POST['gambar_lama']);
            }
        }

        $stmt = $conn->prepare("UPDATE gallery SET gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("sssi", $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO gallery (gambar,tanggal,username) VALUES (?,?,?)");
        $stmt->bind_param("sss", $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>alert('Simpan data sukses');document.location='admin.php?page=gallery';</script>";
    } else {
        echo "<script>alert('Simpan data gagal');document.location='admin.php?page=gallery';</script>";
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    echo $hapus
        ? "<script>alert('Hapus data sukses');document.location='admin.php?page=gallery';</script>"
        : "<script>alert('Hapus data gagal');document.location='admin.php?page=gallery';</script>";

    $stmt->close();
    $conn->close();
}
?>
    </div>
</div>
