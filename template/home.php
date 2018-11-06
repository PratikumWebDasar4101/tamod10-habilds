<?php include_once "template/header.php"; ?>
<body>
  <?php include_once "template/menu.php"; ?>
  <div class="jumbotron">
    <?php if (!isset($_SESSION["is_login"])) { ?>
      <div class="container text-center">
        <h1 class="display-3" style="font-weight: 600">Selamat Datang!</h1>
        <p class="mt-4 mb-5 h5" style="line-height: 1.6">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p><a class="btn btn-success btn-lg mr-3" href="register.php">Registrasi</a><a class="btn btn-secondary btn-lg" href="index.php?login=true">Login</a></p>
      </div>
    <?php }else { ?>
      <div class="container text-center">
        <h1 class="display-3" style="font-weight: 600">Selamat Datang! <?php echo $_SESSION["username"] ? $_SESSION["username"] : 'Guest' ?></h1>
        <p class="mt-4 mb-5 h5" style="line-height: 1.6">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p><a class="btn btn-outline-primary btn-lg mr-3" href="dashboard.php">Dasbor</a><a class="btn btn-dark btn-lg" href="profile.php">Profil</a></p>
      </div>
    <?php } ?>
  </div>
  <?php include_once "template/footer.php"; ?>
  <script src="./assets/bootstrap.js" charset="utf-8"></script>
</body>
</html>
