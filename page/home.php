<!-- <div class="container mt-4">
  <div class="masonry">
    <?php
    $tampil = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User");
    foreach ($tampil as $tampils) :
      # code...
    ?>
      <div class="mItem">
        <img src="uploads/<?= $tampils['Lokasi_File'] ?>" class="rounded-top lazyload">
        <div class="overlay">
          <div class="overlay-content">
            <div class="row">

              <div class="col-8">
                <p class="text-start">
                  <?= $tampils['Deskripsi']; ?>
                </p>
              </div>

              <div class="col-4">
                <a href="?url=detail&&id=<?= $tampils['Id_Foto']; ?>">More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div> -->

<div class="container masonry">
<?php
    $tampil = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User");
    foreach ($tampil as $tampils) :
      # code...
    ?>
  <div class="box">
    <img src="uploads/<?= $tampils['Lokasi_File'] ?>" alt="">
  </div>
  <?php endforeach; ?>
</div>