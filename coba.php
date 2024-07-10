<?php
session_start();
$servername = "localhost"; // ganti dengan nama server database Anda
$username = "root"; // ganti dengan username database Anda
$password =""; // ganti dengan password database Anda
$dbname = "db_showcase"; // ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM project";
$result = $conn->query($sql);

$daftar = array();

if (isset($_POST['delete'])) {
  $id_project = $_POST['id_project'];

  // Delete project from database
  $deleteQuery = "DELETE FROM project WHERE ID_PROJECT='$id_project'";
  if (mysqli_query($conn, $deleteQuery)) {
      // Redirect to project page
      header("Location: coba.php");
      exit();
  } else {
      echo "Terjadi kesalahan: " . mysqli_error($conn);
  }
}


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $daftar[] = $row;
    }
}

// Query untuk mengambil data project milik user
$sql = "SELECT * FROM project WHERE ID_USER = $_SESSION[ID_USER]";
$result = $conn->query($sql);

$projects = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}
// Query untuk mengambil data kategori
$sql_kategori = "SELECT * FROM kategori";
$result_kategori = $conn->query($sql_kategori);

$kategoris = array();

if ($result_kategori->num_rows > 0) {
    while ($row_kategori = $result_kategori->fetch_assoc()) {
        $kategoris[] = $row_kategori;
    }
}

if (isset($_POST['delete'])) {
  $id_project = sanitize($conn, $_POST['id_project']);

  // Delete project from database
  $deleteQuery = "DELETE FROM project WHERE id_project='$id_project'";
  mysqli_query($conn, $deleteQuery);

  // Redirect to project page
  header("Location: coba.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <style>
    .project-item{
      display: none;
    }
    .category-list{
      display: inline-flex;

      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
    }
    .category-item{
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
      font-size: 18px;
      font-weight: 400;
    }
    .category-item a{
      text-decoration: none;
      color: #000;
    }
    .slick-slide img {
      width: 100%;
      height: auto;
    }
    .gallery {
      display: flex;
      flex-wrap: wrap;
    }

    .gallery-item {
      flex-basis: 25%;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .gallery-item img {
      width: 100%;
      height: auto;
      cursor: pointer;
    }

    .project-list {
      display: none;
    }

    .project-list.active {
      display: block;
    }
  </style>
  
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PNB WEB EXPO </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-transparent">
    <div class="container d-flex align-items-center justify-content-between position-relative">

      <div class="logo">
        <h1 class="text-light"><a href="index.html"><span>PNB WEB EXPO </span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
      
       <!-- Tambahkan elemen audio dengan atribut autoplay -->


      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Project saya</a></li>
          <li><a class="nav-link scrollto" href="#daftar">Daftar Project</a></li>
          <li><a class="nav-link scrollto" href="#kategori">Kategori</a></li>
          <li><a class="nav-link scrollto" href="add_project.php">Upload</a></li>
          <li><a class="nav-link scrollto" href="index.php">Keluar</a></li>
        </ul>
        
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  
  <section id="hero">
    <div class="hero-container" data-aos="fade-up">
    <h1>Selamat Datang <i class="fa fa-database" aria-hidden="true"></i></h1>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/_tOzIis_xNY" frameborder="0" allowfullscreen></iframe>

      <a href="#about" class="btn-get-started scrollto"><i class="bx bx-chevrons-down"></i></a>
    </div>
  </section>

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

      <section id="team" class="team">
      <div class="container">
        
        <div class="section-title" data-aos="fade-in" data-aos-delay="100">
          <h2>Project saya</h2>
        </div> 
        <?php if (count($projects) > 0) { ?>
    <div class="row">
      <?php foreach ($projects as $project) { ?>
      <div class="col-md-4">
        <div class="card">
        <?php
                // Mengambil data blob dari database
                $imageData = $project['GAMBAR'];
                
                // Mengonversi data blob menjadi URL gambar
                $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
                ?>
                <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="<?php echo $project['NAMA_PROJECT']; ?>">
            <div class="card-body">
            <h5 class="card-title"><?php echo $project['NAMA_PROJECT']; ?></h5>
            <p class="card-text"><?php echo $project['DESKRIPSI']; ?></p>
            <a href="edit_project.php?id=<?php echo $project['ID_PROJECT']; ?>" class="btn btn-primary">Edit</a>
            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" style="display: inline;">
                <input type="hidden" name="id_project" value="<?php echo $project['ID_PROJECT']; ?>">
                <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
            </form>
            <a href="detail_project.php?id=<?php echo $project['ID_PROJECT']; ?>" class="btn btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php } else { ?>
    <p>Anda belum memiliki project apapun.</p>
    <?php } ?>
    </section>
    </section>
    
    <section id="daftar" class="abaout">
      <div class="container">

      <section id="team" class="team">
      <div class="container">

        <div class="section-title" data-aos="fade-in" data-aos-delay="100">
          <h2>Daftar Project</h2>
        </div>
      <div class="container">
        <div class="row">
        <div class="container">
        <div class="row">
            <?php foreach ($daftar as $daftars) { ?>
            <div class="col-md-4">
            <div class="card">
            <?php
                // Mengambil data blob dari database
                $imageData = $daftars['GAMBAR'];
                
                // Mengonversi data blob menjadi URL gambar
                $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
                ?>
                <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="<?php echo $daftars['NAMA_PROJECT']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $daftars['NAMA_PROJECT']; ?></h5>
                    <p class="card-text"><?php echo $daftars['DESKRIPSI']; ?></p>
                    <a href="detail_project.php?id=<?php echo $daftars['ID_PROJECT']; ?>" class="btn btn-primary">Lihat Detail</a>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        </div>

        </div>
      </div>
      </section>
      </section>

      <section  id="kategori" class="" >
        <div class="text-center">
      <div class="section-title" data-aos="fade-in" data-aos-delay="100" >
        <h2>Kategori</h2>
      </div>
      <div class="category-list">
        <?php foreach ($kategoris as $kategori) { ?>
          <div class="category-item">
            <a href="javascript:void(0);" onclick="filterProject('<?php echo $kategori['ID_KATEGORI']; ?>');" class="text-start category-link">
              <?php echo $kategori['NAMA']; ?>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
    <section id="project" class="project">
    <div class="container">
      <div class="row" id="projectList">
        <?php foreach ($daftar as $daftars) { ?>
          <div class="col-md-4 project-item" data-kategori="<?php echo $daftars['ID_KATEGORI']; ?>">
            <div class="card">
              <?php
                // Mengambil data blob dari database
                $imageData = $daftars['GAMBAR'];
                
                // Mengonversi data blob menjadi URL gambar
                $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
                ?>
                <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="<?php echo $daftars['NAMA_PROJECT']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $daftars['NAMA_PROJECT']; ?></h5>
                    <p class="card-text"><?php echo $daftars['DESKRIPSI']; ?></p>
                    <a href="detail_project.php?id=<?php echo $daftars['ID_PROJECT']; ?>" class="btn btn-primary">Lihat Detail</a>
                </div>
                </div>
            </div>
            <?php } ?>
      </div>
    </div>
    </section>
    </section>
  </main><!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
  function filterProject(kategoriId) {
    // Ambil semua elemen project-item
    var projectItems = document.getElementsByClassName('project-item');

    // Periksa setiap elemen project-item
    for (var i = 0; i < projectItems.length; i++) {
      var projectItem = projectItems[i];
      var kategori = projectItem.getAttribute('data-kategori');

      // Periksa apakah kategori project-item cocok dengan kategori yang dipilih
      if (kategoriId === 'all' || kategori === kategoriId) {
        // Tampilkan project-item yang cocok
        projectItem.style.display = 'block';
      } else {
        // Sembunyikan project-item yang tidak cocok
        projectItem.style.display = 'none';
      }
    }
  }
</script>
</body>
</html>