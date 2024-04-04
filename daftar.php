<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-primary-subtle">

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Register</h4>   
                        <?php
                            if(isset($_POST['submit'])) {
                                $submit=$_POST['submit'];
                                if ($submit=='Daftar') {
                                    # code...
                                    $username=$_POST['username'];
                                    $password=md5($_POST['password']);
                                    $email=$_POST['email'];
                                    $nama_lengkap=$_POST['nama_lengkap'];
                                    $alamat=$_POST['alamat'];

                                    $cek=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE Username='$username' OR Email='$email' "));
                                    if ($cek==0) {
                                        # code...
                                        mysqli_query($conn, "INSERT INTO user VALUES('','$username','$password','$email','$nama_lengkap','$alamat')");
                                        echo "Daftar Berhasil,";
                                        echo '<meta http-equiv="refresh" content="0.8; url=login.php">';
                                    } else {
                                        echo "Maaf Akun Sudah Ada";
                                        echo '<meta http-equiv="refresh" content="0.8; url=daftar.php">';
                                    }
                                }
                            }
                        ?>                     
                        <form action="daftar.php" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
        
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
        
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
        
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" required>
                            </div>
        
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" required>
                            </div>

                            <input type="submit" value="Daftar" class="btn btn-primary mb-3 mt-3" name="submit">
                            <p>Sudah punya akun? <a href="login.php">Login Sekarang</a> </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
