<?php 
session_start();
require_once "init.php";

if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > 1800)) {
    session_unset();
    session_destroy();
}
if (!isset($_SESSION["is_login"])) {
    header("Location: index.php");
} else {
    $nim = $_SESSION["nim"];
    if (isset($_GET["cari"])) {
        $value = $_GET["cari"];
        $query = "SELECT * FROM user e LEFT OUTER JOIN mahasiswa m USING (nim) WHERE nim like '%$value%' or username like '%$value%'";
    } else {
        $query = "SELECT * FROM user e LEFT OUTER JOIN mahasiswa m USING (nim)";
    }
    $query2 = "SELECT * FROM mahasiswa WHERE nim=$nim";
    $result = $db->query($query);
    $result2 = $db->query($query2);
    $row2 = $db->fetchAll($result2); 
?>
<?php include_once "template/header.php"; ?>

<body>
  <?php include_once "template/menu.php" ?>
  <div class="container">
    <?php if (empty($row2["nama_dpn"])): ?>
    <div class="alert alert-warning mt-5 py-3" role="alert">
      Sepertinya anda belum melengkapi data pribadi anda, segera lengkapi data diri anda <a href="form.php" class="alert-link">disini</a>
    </div>
    <?php endif; ?>
    <div class="d-flex mt-5 mb-3">
      <div class="flex-row mr-auto">
        <h2>List User</h2>
      </div>
      <div class="flex-row-reverse">
        <form action="dashboard.php" method="get">
          <div class="form-inline">
            <input type="text" class="form-control mr-2" name="cari" placeholder="Cari username atau nim">
            <button type="submit" class="btn btn-outline-success">Cari</button>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-sm">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>NIM</th>
          <th>Username</th>
          <th>Email</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th>Hobi</th>
          <th>Genre Film</th>
          <th>Tujuan Wisata</th>
          <th>Tanggal Lahir</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($result) && $db->rowCount($result) > 0) {
        ?>
        <?php
          $i = 1;
        while ($row = $db->fetchAll($result)) {
            ?>
        <tr <?php echo (isset($_SESSION['nim']) && $_SESSION['nim']==$row['nim']) ? 'class="table-active"' : '' ?>>
          <th scope="row">
            <?php echo $i ?>
          </th>
          <td>
            <?php echo $row["nim"] ?>
          </td>
          <td>
            <?php echo $row["username"] ?>
          </td>
          <td>
            <?php echo $row["email"] ?>
          </td>
          <td>
            <?php echo ($row["nama_dpn"] != "") ? $row["nama_dpn"] . " " . $row["nama_blkg"] : "-" ?>
          </td>
          <td>
            <?php echo ($row["kelas"] != "") ? $row["kelas"] : "-" ?>
          </td>
          <td>
            <?php echo ($row["hobi"] != "") ? $row["hobi"] : "-" ?>
          </td>
          <td>
            <?php echo ($row["genre"] != "") ? $row["genre"] : "-" ?>
          </td>
          <td>
            <?php echo ($row["wisata"] != "") ? $row["wisata"] : "-" ?>
          </td>
          <td>
            <?php echo ($row["tanggal"] != "") ? $row["tanggal"] : "-" ?>
          </td>
        </tr>
        <?php
          $i++;
        } ?>
        <?php
    } else {
        ?>
        <tr>
          <td colspan="10" class="text-center">0 Results.</td>
        </tr>
        <?php
    } ?>
      </tbody>
    </table>
  </div>
  <?php include_once "template/footer.php"; ?>
  <script src="./assets/bootstrap.js" charset="utf-8"></script>
</body>

</html>
<?php
}