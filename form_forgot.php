<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <title>Forgot Password</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .form-box {
      max-width: 500px;
      padding: 50px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #fff;
    }
    .form-box .form-control {
      border: none;
      border-bottom: 1px solid #ccc;
      border-radius: 0;
    }
    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      color: #007bff;
      font-size: 24px;
    }
  </style>
</head>
<body>
  <div class="logo">
    <h4 class="text-light"><a href="index.php" style="text-decoration: none;"><span>PNB WEB EXPO </span></a></h4>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 form-box">
        <h2 class="text-center mb-4">Forgot Password</h2>
        <form action="new_pw.php" method="POST">
          <div class="mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Password" name="password">
              <button class="btn btn-outline-primary" type="button" id="toggle-password">
                <i class="bi bi-eye-slash"></i>
              </button>
            </div>
          </div>
          <div class="d-grid mt-2">
            <button type="submit" class="btn btn-primary">Reset Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const passwordInput = document.querySelector('.form-box input[type="password"]');
    const togglePasswordButton = document.getElementById('toggle-password');

    togglePasswordButton.addEventListener('click', function () {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePasswordButton.innerHTML = '<i class="bi bi-eye"></i>';
      } else {
        passwordInput.type = 'password';
        togglePasswordButton.innerHTML = '<i class="bi bi-eye-slash"></i>';
      }
    });
  </script>
  
</body>
</html>
