<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Upload Gambar -->
            <h4>Upload Gambar</h4>
            <?php
            if (isset($_POST['submit'])) {
                // Pastikan kunci 'submit' sudah diatur sebelum mengaksesnya
                $submit = $_POST['submit'];
                $fotoid = isset($_GET['fotoid']) ? $_GET['fotoid'] : '';
                if ($submit == 'Simpan') {
                    $judul_foto = mysqli_real_escape_string($conn, $_POST['judul_foto']);
                    $deskripsi_foto = mysqli_real_escape_string($conn, $_POST['deskripsi_foto']);
                    $nama_file = $_FILES['namafile']['name'];
                    $tmp_foto = $_FILES['namafile']['tmp_name'];
                    $file_size = $_FILES['namafile']['size']; // Mendapatkan ukuran file
            
                    // Tentukan batas ukuran file (dalam byte, contoh: 2MB)
                    $max_file_size = 2 * 1024 * 1024; // 2MB
            
                    // Periksa apakah ukuran file melebihi batas yang ditentukan
                    if ($file_size > $max_file_size) {
                        echo 'Ukuran file terlalu besar. Maksimum 2MB.';
                        // Redirect atau tindakan lainnya
                        exit(); // Keluar dari script
                    }

                    // Melanjutkan jika ukuran file sesuai
                    $tanggal = date('Y-m-d');
                    $album_id = $_POST['album_id'];
                    $user_id = $_SESSION['user_id'];
                    if (move_uploaded_file($tmp_foto, 'uploads/' . $nama_file)) {
                        $insert = mysqli_query($conn, "INSERT INTO foto (Judul_Foto, Deskripsi, Tgl_Unggah, Lokasi_File, Id_Album, Id_User) VALUES ('$judul_foto','$deskripsi_foto','$tanggal','$nama_file','$album_id','$user_id')");
                        echo 'Gambar Berhasil di Simpan';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                    } else {
                        echo 'Gambar gagal di Simpan';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                    }
                } elseif (isset($_GET['edit'])) {
                    $submit = isset($_POST['submit']) ? $_POST['submit'] : '';
                    $fotoid = $_GET['fotoid'];
                    if ($submit == "Ubah") {
                        $judul_foto = $_POST['judul_foto'];
                        $deskripsi_foto = $_POST['deskripsi_foto'];
                        $album_id = $_POST['album_id'];
                        $file_size = $_FILES['namafile']['size']; // Mendapatkan ukuran file

                        // Check if a file is uploaded
                        if ($_FILES['namafile']['name'] != '') {
                            $nama_file = $_FILES['namafile']['name'];
                            $tmp_foto = $_FILES['namafile']['tmp_name'];
                            $lokasi = 'uploads/';
                            $namafoto = rand() . '-' . $nama_file;

                            // Tentukan batas ukuran file (dalam byte, contoh: 2MB)
                            $max_file_size = 2 * 1024 * 1024; // 2MB
            
                            // Periksa apakah ukuran file melebihi batas yang ditentukan
                            if ($file_size > $max_file_size) {
                                echo 'Ukuran file terlalu besar. Maksimum 2MB.';
                                // Redirect atau tindakan lainnya
                                exit(); // Keluar dari script
                            }
                            // Fetch existing data
                            $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM foto WHERE Id_Foto='$fotoid'"));
                            // Delete existing file
                            if (is_file('uploads/' . $data['Lokasi_File'])) {
                                unlink('uploads/' . $data['Lokasi_File']);
                            }
                            // Move new file
                            move_uploaded_file($tmp_foto, $lokasi . $namafoto);

                            // Update data including the new file name
                            $update = mysqli_query($conn, "UPDATE foto SET Judul_Foto='$judul_foto', Deskripsi='$deskripsi_foto', Lokasi_File='$namafoto', Id_Album='$album_id' WHERE Id_Foto='$fotoid'");
                        } else {
                            // If no file is uploaded, update data without changing the file name
                            $update = mysqli_query($conn, "UPDATE foto SET Judul_Foto='$judul_foto', Deskripsi='$deskripsi_foto', Id_Album='$album_id' WHERE Id_Foto='$fotoid'");
                        }
                        if ($update) {
                            echo 'Gambar Berhasil di Ubah';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                        } else {
                            echo 'Gambar gagal di Ubah';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                        }
                    }
                }

            } elseif (isset($_GET['hapus'])) {
                $fotoid = $_GET['fotoid'];
            
                // Menghapus semua like terkait dengan foto
                $delete_likes = mysqli_query($conn, "DELETE FROM `like` WHERE Id_Foto='$fotoid'");
            
                // Menghapus semua komentar terkait dengan foto
                $delete_comments = mysqli_query($conn, "DELETE FROM `komentar` WHERE Id_Foto='$fotoid'");
            
                // Memeriksa apakah kedua operasi di atas berhasil dilakukan
                if ($delete_likes && $delete_comments) {
                    // Jika berhasil, hapus foto itu sendiri
                    $delete_foto = mysqli_query($conn, "DELETE FROM foto WHERE Id_Foto='$fotoid'");
                    if ($delete_foto) {
                        echo 'Gambar Berhasil di Hapus bersama dengan semua like dan komentar terkait';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                    } else {
                        echo 'Gagal menghapus foto';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                    }
                } else {
                    echo 'Gagal menghapus like atau komentar';
                    echo '<meta http-equiv="refresh" content="0.8; url=?url=profile">';
                }
            }

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $fotoid = isset($_GET['fotoid']) ? $_GET['fotoid'] : '';
                $album = mysqli_query($conn, "SELECT * FROM album WHERE Id_User = $user_id");

                $val = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM foto WHERE Id_Foto='$fotoid'"));

                if (!isset($_GET['edit']) && !isset($_GET['hapus'])):
                    ?>
                    <form action="?url=upload" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="file" name="namafile" class="form-control" required>
                        </div>
                </div>
                <div class="col-md-6">
                    <!-- Form Data -->
                    <h4>Data Gambar</h4>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Masukan Judul Foto" required name="judul_foto">
                    </div>
                    <div class="mb-3">
                        <textarea name="deskripsi_foto" placeholder="Masukan Deskripsi Foto" class="form-control" required cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Pilih Album</label>
                        <select name="album_id" class="form-select">
                            <option selected hidden>-- Pilih Album -- </option>
                            <?php foreach ($album as $albums): ?>
                                <option value="<?= $albums['Id_Album'] ?>">
                                    <?= $albums['Nama_Album'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Simpan" name="submit" class="btn btn-light my-3 w-100 border">
                    </div>
                    </form>
                    <!-- Form Edit -->
                <?php elseif (isset($_GET['edit'])): ?>
                    <form action="?url=upload&&edit&&fotoid=<?= $val['Id_Foto'] ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="fotoid" value="<?php echo $val['Id_Foto'] ?>">
                        <div class="mb-3">
                            <img src="uploads/<?= $val['Lokasi_File'] ?>" width="100">

                            <input type="file" name="namafile" class="form-control">
                        </div>
                </div>
                <div class="col-md-6">
                    <!-- Form Data -->
                    <h4>Data Gambar</h4>
                    <div class="mb-3">
                        <input type="text" class="form-control" required name="judul_foto" value="<?= $val['Judul_Foto'] ?>" placeholder="Masukan Judul Foto">
                    </div>
                    <div class="mb-3">
                        <textarea name="deskripsi_foto" class="form-control" required cols="30"
                            rows="5"><?= $val['Deskripsi'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Pilih Album</label>
                        <select name="album_id" class="form-select">
                            <?php foreach ($album as $albums): ?>
                                <?php
                                $selected = ($albums['Id_Album'] == $val['Id_Album']) ? 'selected' : '';
                                ?>
                                <option value="<?= $albums['Id_Album'] ?>" <?= $selected ?>>
                                    <?= $albums['Nama_Album'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="submit" value="Ubah" name="submit" class="btn btn-warning my-3 w-100">
                    </div>
                    </form>
                <?php endif;
            } ?>
        </div>
    </div>
</div>
</div>