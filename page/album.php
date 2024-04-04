<div class="container mt-5">
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <h4>Halaman Album</h4>
                    <?php
                    $submit = @$_POST['submit'];
                    $albumId =@$_GET['albumid'];
                    if ($submit == 'Simpan') {
                        # code...
                        $nama_album = @$_POST['nama_album'];
                        $deskripsi_album = @$_POST['deskripsi_album'];
                        $tanggal = date('Y-m-d');
                        $user_id = @$_SESSION['user_id'];
                        $insert = mysqli_query($conn, "INSERT INTO album VALUES('','$nama_album','$deskripsi_album','$tanggal','$user_id')");
                        if ($insert) {
                            # code...
                            echo 'Berhasil Membuat Album';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                        } else {
                            echo 'Gagal Membuat Album';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                        }
                    }elseif(isset($_GET['edit'])){
                        if($submit=="Ubah") {
                            $nama_album = @$_POST['nama_album'];
                            $deskripsi_album = @$_POST['deskripsi_album'];
                            $tanggal = date('Y-m-d');
                            $user_id = @$_SESSION['user_id'];
                            $update=mysqli_query($conn, "UPDATE album SET Nama_Album='$nama_album', Deskripsi='$deskripsi_album' WHERE Id_Album='$albumId'");
                            if($update) {
                                echo 'Berhasil Mengubah Album';
                                echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                            }else {
                                echo 'Gagal Membuat Album';
                                echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                            }
                        }                    
                    }elseif(isset($_GET['hapus'])) {
                        // Periksa apakah ada foto yang terkait dengan album yang akan dihapus
                        $check_photos = mysqli_query($conn, "SELECT * FROM foto WHERE Id_Album = '$albumId'");
                        if(mysqli_num_rows($check_photos) > 0) {
                            // Jika ada foto yang terkait, tampilkan pesan peringatan atau lakukan tindakan yang sesuai
                            echo 'Album tidak dapat dihapus karena terdapat foto yang terkait. Silakan hapus foto terlebih dahulu atau pindahkan foto ke album lain.';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                        } else {
                            // Jika tidak ada foto yang terkait, hapus album
                            $hapus=mysqli_query($conn, "DELETE FROM album WHERE Id_Album = '$albumId'");
                            if($hapus) {
                                echo 'Berhasil Menghapus Album';
                                echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                            } else {
                                echo 'Gagal Menghapus Album';
                                echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                            }
                        }
                    }
                    

                    $val = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM album WHERE Id_Album='$albumId'"));
                    if (!isset ($_GET['edit'])):
                        ?>
                        <form action="?url=album" method="post">
                            <div class="form-group">
                                <label>Nama Album</label>
                                <input type="text" class="form-control" required name="nama_album">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Album</label>
                                <textarea name="deskripsi_album" class="form-control" required cols="30"
                                    rows="5"></textarea>
                            </div>

                            <input type="submit" value="Simpan" name="submit" class="btn btn-danger my-3">
                        </form>
                        <?php elseif (isset ($_GET['edit'])): ?>
                        <form action="?url=album&&edit&&albumid=<?= $val['Id_Album'] ?>" method="post">
                            <div class="form-group">
                                <label>Nama Album</label>
                                <input type="text" class="form-control" value="<?= $val['Nama_Album']?>" required name="nama_album">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Album</label>
                                <textarea name="deskripsi_album" class="form-control"required cols="30" rows="5"><?= $val['Deskripsi']?></textarea>
                            </div>

                            <input type="submit" value="Ubah" name="submit" class="btn btn-warning my-3">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hovered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Album</th>
                                <th>Deskripsi Album</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $userid = @$_SESSION['user_id'];
                            $albums = mysqli_query($conn, "SELECT * FROM album WHERE Id_User='$userid'");
                            foreach ($albums as $album):
                                ?>
                                <tr>
                                    <td>
                                        
                                    <?= $i++ ?>
                                    </td>
                                    <td>
                                        <?= $album['Nama_Album'] ?>
                                    </td>
                                    <td>
                                        <?= $album['Deskripsi'] ?>
                                    </td>
                                    <td>
                                        <?= $album['Tgl_Dibuat'] ?>
                                    </td>
                                    <td>
                                        <a href="?url=album&&edit&&albumid=<?= $album['Id_Album'] ?>"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="?url=album&&hapus&&albumid=<?= $album['Id_Album'] ?>"
                                            class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>