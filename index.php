<?php
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
// Query untuk mengambil data project
$sql = "SELECT * FROM project";
$result = $conn->query($sql);

$projects = array();

if ($result->num_rows > 0) {
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
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <style>
    .slick-slide img {
      width: 100%;
      height: auto;
    }
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
        <h1 class="text-light"><a href="index.php"><span>PNB WEB EXPO </span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
      
       <!-- Tambahkan elemen audio dengan atribut autoplay -->

      <nav id="navbar" class="navbar">
        <ul>
        <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Daftar Project</a></li>
          <li><a class="nav-link scrollto" href="#Kategori">Kategori</a></li>
          <li><a class="nav-link scrollto" href="form-login.php">Login</a></li>
        </ul>
        
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container" data-aos="fade-up">
      <h1>PROJECT BASIS LEARNING</h1>
      <h2>Kelompok 7</h2>
      <a href="#about" class="btn-get-started scrollto"><i class="bx bx-chevrons-down"></i></a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

  <section id="about" class="">
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
                    <a href="detail_project.php?id=<?php echo $project['ID_PROJECT']; ?>" class="btn btn-primary">Lihat Detail</a>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        </div>

        </div>
      </div>
    </section>          
              </i></a>
            </div>
          </div>
          <div class="col-xl-7 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-book-reader"></i>
                  
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End About Section -->
    
    <!-- ======= Cta Section ======= -->
    <section  id="Kategori" class="" >
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
        <?php foreach ($projects as $project) { ?>
          <div class="col-md-4 project-item" data-kategori="<?php echo $project['ID_KATEGORI']; ?>">
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
                    <a href="detail_project.php?id=<?php echo $project['ID_PROJECT']; ?>" class="btn btn-primary">Lihat Detail</a>
                </div>
                </div>
            </div>
            <?php } ?>
      </div>
    </div>
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
