<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <style>
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #343a40;
      color: #fff;
      padding: 20px;
      transition: all 0.3s;
    }

    .sidebar ul.nav.flex-column {
      margin-top: 40px;
    }

    .sidebar ul.nav.flex-column li.nav-item {
      margin-bottom: 10px;
    }

    .sidebar ul.nav.flex-column li.nav-item a.nav-link {
      color: #fff;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
    }

    @media (max-width: 767px) {
      .sidebar {
        width: 100%;
        position: static;
        height: auto;
        margin-bottom: 20px;
      }

      .content {
        margin-left: 0;
      }
    }
  </style>
  <title>PNB WEB EXPO</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 col-sm-12 bg-dark text-light sidebar">
        <div class="sidebar-content">
          <h2>Admin Page</h2>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="kategori.php">Kategori</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user.php">User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="project.php">Project</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../index.php" rel="prev">Log Out</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Content -->
      <div class="col-md-10 col-sm-12">
        <div class="content">
          <h1>Dashboard</h1>
          <p>Welcome to the admin dashboard!</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
