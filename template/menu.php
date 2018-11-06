<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/jurnalpwd/">TA Pwd</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    </ul>
    <?php if (isset($_SESSION["is_login"])): ?>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Akun
          </a>
          <div class="dropdown-menu dropdown-menu-right text-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="dashboard.php">Dasbor Akun</a>
            <a class="dropdown-item" href="profile.php">Profil Saya</a>
            <a class="dropdown-item" href="form.php?edit=true">Edit Profil</a>
            <a class="dropdown-item" href="submit.php?delete=true&nim=<?php echo $nim ?>">Hapus Akun</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    <?php endif; ?>
  </div>
</nav>
