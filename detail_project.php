<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PNB WEB EXPO</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
  <script>
  $(document).ready(function() {
    $('.slider').slick({
      infinite: true, // Loop slider secara terus-menerus
      autoplay: true, // Otomatis putar slider
      prevArrow: $('.slider-controls .slider-prev'),
      nextArrow: $('.slider-controls .slider-next')
    });
  });
  </script>
  <style>
    .slider-controls {
    text-align: center;
    margin-top: 20px;
    }

  .slider-controls button {
    display: inline-block;
    margin: 5px;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }

  .slider-controls button:hover {
    background-color: #0069d9;
    }
    body {
      background-color: #f8f9fa;
    }

    .container {
      max-width: 600px;
      margin-top: 40px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 28px;
      margin-bottom: 10px;
    }

    p {
      margin-bottom: 10px;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-primary:focus,
    .btn-primary.focus {
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    }
  </style>
</head>

<body>
  <div class="container">
    <?php
    // Mengambil nilai ID project dari URL
    $id = $_GET['id'];

    // Lakukan koneksi ke database dan query untuk mendapatkan detail project
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_showcase";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mendapatkan detail project berdasarkan ID
    $sql = "SELECT * FROM project WHERE ID_PROJECT = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Loop melalui hasil query untuk mendapatkan data project
      while ($row = $result->fetch_assoc()) {
        $idProject = $row['ID_PROJECT'];
        $idKategori = $row['ID_KATEGORI'];
        $idUser = $row['ID_USER'];
        $namaProject = $row['NAMA_PROJECT'];
        $tahunProject = $row['TAHUN_PROJECT'];
        $timProject = $row['TIM_PROJECT'];
        $email = $row['EMAIL'];
        $deskripsi = $row['DESKRIPSI'];
        $gambar = $row['GAMBAR'];
        $gambar2 = $row['GAMBAR2']; 
        $gambar3 = $row['GAMBAR3']; 
        $gambar4 = $row['GAMBAR4']; 
        $gambar5 = $row['GAMBAR5'];         
        $link = $row['LINK'];
    ?>

        <div class="card">
         <div class="slider">
          <?php
            // Mendapatkan daftar gambar dari database
            $images = array($gambar, $gambar2, $gambar3, $gambar4, $gambar5);

             // Loop melalui setiap gambar dan tambahkan ke slider
            foreach ($images as $image) {
              if ($image) {
              $imageSrc = 'data:image/jpeg;base64,' . base64_encode($image);
              echo '<div><img src="' . $imageSrc . '" class="card-img-top" alt="' . $namaProject . '"></div>';
               }
            }
          ?>
         </div>
         <div class="slider-controls">
            <button class="slider-prev">Previous</button>
            <button class="slider-next">Next</button>
         </div>
          <div class="card-body">
            <h1 class="card-title"><?php echo $namaProject; ?></h1>
            <p class="card-text">Tahun Project: <?php echo $tahunProject; ?></p>
            <p class="card-text">Tim Project: <?php echo $timProject; ?></p>
            <p class="card-text">Email: <?php echo $email; ?></p>
            <p class="card-text">Deskripsi: <?php echo $deskripsi; ?></p>
          </div>
          <div>
            <a href="javascript:history.go(-1)" class="btn btn-danger" style="float: left;">Back</a>
            <a href="<?php echo $link; ?>" class="btn btn-primary">Kunjungi Link</a>
          </div>
        </div>
    <?php
      }
    } else {
      echo "Tidak ada data project yang ditemukan.";
    }
    $conn->close();
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
