<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Upload Gambar -->
            <h4>Upload Gambar</h4>
            <?php
            if (isset($_POST['submit'])) {
                // Make sure 'submit' key is set before accessing it
                $submit = $_POST['submit'];
                $fotoid = isset($_GET['fotoid']) ? $_GET['fotoid'] : '';
                if ($submit == 'Simpan') {
                    # code...
                    $judul_foto = $_POST['judul_foto'];
                    $deskripsi_foto = $_POST['deskripsi_foto'];
                    $nama_file = $_FILES['namafile']['name'];
                    $tmp_foto = $_FILES['namafile']['tmp_name'];
                    $tanggal = date('Y-m-d');
                    $album_id = $_POST['album_id'];
                    $user_id = $_SESSION['user_id'];
                    if (move_uploaded_file($tmp_foto, 'uploads/' . $nama_file)) {
                        # code...
                        $insert = mysqli_query($conn, "INSERT INTO foto VALUES('','$judul_foto','$deskripsi_foto','$tanggal','$nama_file','$album_id','$user_id')");
                        echo 'Gambar Berhasil di Simpan';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                    } else {
                        echo 'Gambar gagal di Simpan';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                    }
                }
            } elseif (isset($_GET['edit'])) {
                # code...
                // Make sure 'submit' key is set before accessing it
                $submit = isset($_POST['submit']) ? $_POST['submit'] : '';
                $fotoid = $_GET['fotoid'];
                if ($submit == "Ubah") {
                    # code...
                    $judul_foto = $_POST['judul_foto'];
                    $deskripsi_foto = $_POST['deskripsi_foto'];
                    $nama_file = $_FILES['namafile']['name'];
                    $tmp_foto = $_FILES['namafile']['tmp_name'];
                    $tanggal = date('Y-m-d');
                    $album_id = $_POST['album_id'];
                    $user_id = $_SESSION['user_id'];
                    if (strlen($nama_file)==0) {
                        # code...
                        $update=mysqli_query($conn, "UPDATE foto SET Judul_Foto='$judul_foto', Deskripsi='$deskripsi_foto', Tgl_Unggah='$tanggal', Id_Album='$album_id' WHERE Id_Foto='$fotoid'");
                        if ($update) {
                            # code...
                            echo 'Gambar Berhasil di Ubah';
                            echo '<meta http-equiv="refresh" content="0.8"; url=?url=upload';
                        }else {
                            echo 'Gambar Gagal di Ubah';
                            echo '<meta http-equiv="refresh" content="0.8"; url=?url=upload';
                        }
                    }else {
                        if(move_uploaded_file($tmp_foto,"uploads/".$nama_file)) {
                            $update = mysqli_query($conn, "UPDATE foto SET Judul_Foto='$judul_foto', Deskripsi='$deskripsi_foto', Lokasi_File='$tanggal', Tgl_Unggah='$tanggal', Id_Album='$album_id' WHERE Id_Foto='$fotoid'");
                            if ($update) {
                                # code...
                                echo 'Gambar Berhasil di Ubah';
                                echo '<meta http-equiv="refresh" content="0.8"; url=?url=upload';
                            }else {
                                echo 'Gambar Gagal di Ubah';
                                echo '<meta http-equiv="refresh" content="0.8"; url=?url=upload';
                            }
                        }
                    }
                }

            } elseif (isset($_GET['hapus'])) {
                $fotoid = $_GET['fotoid'];
            
                // Delete related records from the 'like' table first
                $delete_likes = mysqli_query($conn, "DELETE FROM `like` WHERE Id_Foto='$fotoid'");
                if ($delete_likes) {
                    // If deletion from 'like' table is successful, proceed to delete from 'foto' table
                    $delete_foto = mysqli_query($conn, "DELETE FROM foto WHERE Id_Foto='$fotoid'");
                    if ($delete_foto) {
                        echo 'Gambar Berhasil di Hapus';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                    } else {
                        echo 'Gambar gagal di Hapus';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                    }
                } else {
                    echo 'Gagal menghapus like';
                    echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                }
            }
            

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $fotoid = $_GET['fotoid'];
                // Perbarui kueri SQL untuk mengambil album berdasarkan ID pengguna yang sedang masuk
                $album = mysqli_query($conn, "SELECT * FROM album WHERE Id_User = $user_id");

                $val=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM foto WHERE Id_Foto='$fotoid'"));

                // Form Tambah
                if (!isset($_GET['edit']) && !isset($_GET['hapus'])):
                    ?>
                    <form action="?url=upload" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Pilih Gambar</label>
                            <input type="file" name="namafile" class="form-control" required>
                        </div>
                </div>
                <div class="col-md-6">
                    <!-- Form Data -->
                    <h4>Data Gambar</h4>
                    <div class="mb-3">
                        <label>Judul Foto</label>
                        <input type="text" class="form-control" required name="judul_foto">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi Foto</label>
                        <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5"></textarea>
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
                        <input type="submit" value="Simpan" name="submit" class="btn btn-danger my-3">
                    </div>
                    </form>
                    <!-- Form Edit -->
                <?php elseif (isset($_GET['edit'])): ?>
                <form action="?url=upload&&edit&&fotoid=<?= $val['Id_Foto'] ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Pilih Gambar</label>
                            <input type="file" name="namafile" class="form-control" required>
                        </div>
                </div>
                <div class="col-md-6">
                    <!-- Form Data -->
                    <h4>Data Gambar</h4>
                    <div class="mb-3">
                        <label>Judul Foto</label>
                        <input type="text" class="form-control" required name="judul_foto" value="<?= $val['Judul_Foto'] ?>">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi Foto</label>
                        <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5"><?= $val['Deskripsi'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Pilih Album</label>
                        <select name="album_id" class="form-select">
                            <?php 
                                foreach ($album as $albums) : 
                                if($albums['Id_Album'] == $val['Id_Album']) :
                            ?>
                            <option value="<?= $albums['Id_Album'] ?>"><?= $albums['Nama_Album'] ?></option>
                            <?php 
                                endif; 
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Ubah" name="submit" class="btn btn-danger my-3">
                    </div>
                    </form>
                <?php endif;
            } ?>
        </div>
    </div>
</div>
</div>
