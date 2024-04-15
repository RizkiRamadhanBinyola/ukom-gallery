<?php
// Masukkan koneksi database Anda di sini
include 'koneksi.php';

// Periksa apakah tombol kirim komentar diklik
if (isset($_POST['submit'])) {
    // Tangkap data dari form
    $komentar = $_POST['komentar'];
    $id_foto = $_GET['id']; // ID foto yang sedang dilihat

    // Simpan komentar ke dalam database
    $user_id = $_SESSION['user_id']; // Mengambil ID pengguna dari sesi
    $query_simpan = "INSERT INTO komentar (Id_Foto, Id_User, Isi_Komen, Tgl_Komen) VALUES ('$id_foto', '$user_id', '$komentar', NOW())";
    mysqli_query($conn, $query_simpan);

    // Redirect kembali ke halaman detail
    header("Location: ?url=detail&id=$id_foto");
    exit();
}

// Ambil data foto berdasarkan ID yang dikirimkan melalui parameter URL
$id_foto = $_GET['id'];
$query_detail = mysqli_query($conn, "SELECT *, (SELECT COUNT(*) FROM `like` WHERE Id_Foto = foto.Id_Foto) AS total_like FROM foto INNER JOIN user ON foto.Id_User=user.Id_User WHERE foto.Id_Foto = $id_foto");
$data = mysqli_fetch_assoc($query_detail);

// Periksa apakah tombol Like/Unlike diklik
if (isset($_GET['like']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query_check_like = mysqli_query($conn, "SELECT * FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
    if (mysqli_num_rows($query_check_like) == 0) {
        // Jika pengguna belum melakukan Like sebelumnya, tambahkan Like ke database
        $query_add_like = "INSERT INTO `like` (Id_Foto, Id_User, Tgl_Like) VALUES ('$id_foto', '$user_id', NOW())";
        mysqli_query($conn, $query_add_like);
        
        // Redirect kembali ke halaman detail
        header("Location: ?url=detail&id=$id_foto");
        exit();
    } else {
        // Pengguna telah memberikan like sebelumnya, Anda bisa memberikan pesan atau mengarahkan mereka kembali ke halaman detail
        echo "Anda telah memberikan like pada foto ini sebelumnya.";
        exit();
    }
} elseif (isset($_GET['unlike']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Hapus like dari database
    $query_delete_like = mysqli_query($conn, "DELETE FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
    
    // Redirect kembali ke halaman detail
    header("Location: ?url=detail&id=$id_foto");
    exit();
}

// Periksa apakah pengguna sudah memberikan like pada foto ini
$button_action = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query_check_like = mysqli_query($conn, "SELECT * FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
    if (mysqli_num_rows($query_check_like) > 0) {
        // Jika pengguna sudah melike foto, tampilkan tombol untuk unlike
        $button_action = '<a href="?url=detail&id=' . $data['Id_Foto'] . '&unlike=1" class="btn btn-sm btn-danger"><i class="fas fa-heart"></i> '. $data['total_like'] . '</a>';
    } else {
        // Jika pengguna belum melike foto, tampilkan tombol untuk like
        $button_action = '<a href="?url=detail&id=' . $data['Id_Foto'] . '&like=1" class="btn btn-sm btn-light border"><i class="far fa-heart"></i> ' . $data['total_like'] . '</a>';
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="uploads/<?= $data['Lokasi_File'] ?>" alt="" class="img-fluid rounded-3">
                </div>

                <div class="col-md-6">
                    <div class="d-flex flex-row">
                        <div class="me-1">
                            <h4><?= $data['Judul_Foto'] ?> · </h4>
                        </div>

                        <div>
                            <!-- Menampilkan tombol Like/Unlike -->
                            <?= $button_action ?>
                        </div>

                    </div>
                    <small>by <?= $data['Nama_User'] ?> · <?= $data['Tgl_Unggah'] ?></small>
                    <hr>
                    <h5><?= $data['Deskripsi'] ?></h5>
                    <!-- Form Komentar -->
                    <form action="?url=detail&id=<?= $data['Id_Foto'] ?>" method="post" class="mt-5">
                        <div class="form-group d-flex flex-row">
                            <input type="text" name="komentar" class="form-control me-2"
                                placeholder="Masukkan komentar...">
                            <input type="submit" value="Kirim" name="submit" class="btn btn-secondary">
                        </div>
                    </form>
                    <!-- Menampilkan Komentar -->
                    <div class="card mt-3">
                        <div class="card-body" id="comment">
                            <?php
                            $query_komentar = mysqli_query($conn, "SELECT komentar.*, user.Nama_User FROM komentar INNER JOIN user ON komentar.Id_User = user.Id_User WHERE komentar.Id_Foto = '" . $data['Id_Foto'] . "' ORDER BY komentar.Tgl_Komen DESC");

                            // Loop untuk menampilkan setiap komentar
                            while ($komentar = mysqli_fetch_assoc($query_komentar)) {
                                echo '<div class="card border-secondary mb-3 mt-3">';
                                echo '<div class="card-body text-secondary">';
                                echo '<small>' . $komentar['Tgl_Komen'] . ' by ' . $komentar['Nama_User'] . '</small>';
                                echo '<p>' . $komentar['Isi_Komen'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-center">Jelajahi lainnya.</h4>
    <div class="container masonry">
        <?php
        // Mengambil data foto-foto lainnya secara acak dengan batasan 20 foto
        $tampil_lainnya = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User WHERE foto.Id_Foto != $id_foto ORDER BY RAND() LIMIT 20");
        foreach ($tampil_lainnya as $foto_lainnya):
            ?>
            <div class="box content">
                <a href="?url=detail&id=<?= $foto_lainnya['Id_Foto']; ?>" style="cursor: zoom-in;">
                    <div class="content-overlay"></div>
                    <img src="uploads/<?= $foto_lainnya['Lokasi_File']; ?>" alt="">
                    <div class="content-details fadeIn-bottom">
                        <h5 class="content-title"><?= $foto_lainnya['Judul_Foto']; ?></h5>
                        <p class="content-text"><?= $foto_lainnya['Deskripsi'] ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>
