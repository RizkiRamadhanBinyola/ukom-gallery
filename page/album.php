<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12 mb-5">
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
                            // Jika ada foto yang terkait, hapus semua foto tersebut bersama dengan like dan komentar
                            while($photo = mysqli_fetch_assoc($check_photos)) {
                                $photoId = $photo['Id_Foto'];
                                
                                // Hapus semua komentar yang terkait dengan foto
                                $delete_comments = mysqli_query($conn, "DELETE FROM komentar WHERE Id_Foto = '$photoId'");
                                if(!$delete_comments) {
                                    echo 'Gagal menghapus komentar yang terkait.';
                                    exit; // Stop execution if failed
                                }
                                
                                // Hapus semua like yang terkait dengan foto
                                $delete_likes = mysqli_query($conn, "DELETE FROM `like` WHERE Id_Foto = '$photoId'");
                                if(!$delete_likes) {
                                    echo 'Gagal menghapus like yang terkait.';
                                    exit; // Stop execution if failed
                                }
                                
                                // Hapus foto
                                $delete_photo = mysqli_query($conn, "DELETE FROM foto WHERE Id_Foto = '$photoId'");
                                if(!$delete_photo) {
                                    echo 'Gagal menghapus foto.';
                                    exit; // Stop execution if failed
                                }
                            }
                        }
                        
                        // Setelah menghapus semua foto yang terkait, hapus album
                        $hapus=mysqli_query($conn, "DELETE FROM album WHERE Id_Album = '$albumId'");
                        if($hapus) {
                            echo 'Berhasil Menghapus Album';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                        } else {
                            echo 'Gagal Menghapus Album';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                        }
                    }
                    
                        
                    

                    $val = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM album WHERE Id_Album='$albumId'"));
                    if (!isset ($_GET['edit'])):
                        ?>
                        <form action="?url=album" method="post">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Album" required name="nama_album">
                            </div>

                            <div class="form-group">
                                <textarea name="deskripsi_album" placeholder="Deskripsi Album" class="form-control" required cols="30"
                                    rows="5"></textarea>
                            </div>

                            <input type="submit" value="Simpan" name="submit" class="btn btn-light border my-3 w-100">
                        </form>
                        <?php elseif (isset ($_GET['edit'])): ?>
                        <form action="?url=album&&edit&&albumid=<?= $val['Id_Album'] ?>" method="post">
                            <div class="form-group mb-3">                                
                                <input type="text" placeholder="Nama Album" class="form-control" value="<?= $val['Nama_Album']?>" required name="nama_album">
                            </div>

                            <div class="form-group">                                
                                <textarea name="deskripsi_album" class="form-control" required cols="30" rows="5" placeholder="Deskripsi Album"><?= $val['Deskripsi']?></textarea>
                            </div>

                            <input type="submit" value="Ubah" name="submit" class="btn btn-warning my-3 w-100">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
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
                                        <?= substr($album['Deskripsi'], 0, 20); ?>...
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