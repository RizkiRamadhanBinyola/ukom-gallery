<div class="container mt-5">
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <h4>Halaman Upload</h4>
                    <?php
                    if (isset ($_POST['submit'])) {
                        $submit = $_POST['submit'];
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
                    } elseif (isset ($_GET['edit'])) {
                        # code...
                        if ($submit == "Ubah") {
                            # code...
                            $judul_foto = $_POST['judul_foto'];
                            $deskripsi_foto = $_POST['deskripsi_foto'];
                            $nama_file = $_FILES['namafile']['name'];
                            $tmp_foto = $_FILES['namafile']['tmp_name'];
                            $tanggal = date('Y-m-d');
                            $album_id = $_POST['album_id'];
                            $user_id = $_SESSION['user_id'];
                            if (strlen($nama_file) == 0) {
                                $update = mysqli_query($conn, "UPDATE foto SET Judul_Foto='', Deskripsi='', Tanggal_Unggah='', Id_Album='' WHERE Id_Foto=''");
                                if ($update) {
                                    echo 'Gambar Berhasil di Ubah';
                                    echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                                } else {
                                    echo 'Gambar gagal di Ubah';
                                    echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';

                                }
                            }
                        }

                    }
                    $album = mysqli_query($conn, "SELECT * FROM album WHERE Id_User='" . $_SESSION['user_id'] . "'");

                    if (!isset ($_GET['edit']) && !isset ($_GET['hapus'])):
                        ?>
                        <form action="?url=upload" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul Foto</label>
                                <input type="text" class="form-control" required name="judul_foto">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Foto</label>
                                <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" name="namafile" class="form-control" required>
                                <small class="text-danger">File harus berupa : *.jpg, *.png, *.gif</small>
                            </div>

                            <div class="form-group">
                                <label>Pilih Album</label>
                                <select name="album_id" class="form-select">
                                    <?php foreach ($album as $albums): ?>
                                        <option value="<?= $albums['Id_Album'] ?>">
                                            <?= $albums['Nama_Album'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <input type="submit" value="Simpan" name="submit" class="btn btn-danger my-3">
                        </form>
                    <?php elseif (isset ($_GET['edit'])): ?>
                        <form action="?url=upload" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul Foto</label>
                                <input type="text" class="form-control" required name="judul_foto">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Foto</label>
                                <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" name="namafile" class="form-control" required>
                                <small class="text-danger">File harus berupa : *.jpg, *.png, *.gif</small>
                            </div>

                            <div class="form-group">
                                <label>Pilih Album</label>
                                <select name="album_id" class="form-select">
                                    <?php foreach ($album as $albums): ?>
                                        <option value="<?= $albums['Id_Album'] ?>">
                                            <?= $albums['Nama_Album'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <input type="submit" value="Simpan" name="submit" class="btn btn-danger my-3">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-7">
            <div class="masonry">
                <?php
                $Fotos = mysqli_query($conn, "SELECT * FROM Foto WHERE Id_User='" . @$_SESSION['user_id'] . "'");
                foreach ($Fotos as $Foto):
                    ?>
                    <div class="box">
                        <img src="uploads/<?= $Foto['Lokasi_File'] ?>" class="rounded-top lazyload">
                        <!-- <div class="overlay">
                            <div class="overlay-content">
                                <div class="row">

                                    <div class="col-8">
                                        <p class="text-start">
                                            <?= $Foto['Deskripsi']; ?>
                                        </p>
                                    </div>

                                    <div class="col-4">
                                        <a href="?url=upload&&edit&&fotoid=<?= $Foto['Id_Foto']; ?>">Edit</a>
                                        <a href="?url=upload&&hapus&&fotoid=<?= $Foto['Id_Foto']; ?>">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>