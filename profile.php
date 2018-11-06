<?php
session_start();
require_once "init.php";

if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > 1800)) {
    session_unset();
    session_destroy();
}
if (isset($_SESSION["nim"])) {
    $nim = $_SESSION["nim"];
    $query = "SELECT * FROM mahasiswa JOIN user using (nim) WHERE nim=$nim";
    $result = $db->query($query);
    $row = $db->fetchAll($result);
?>
<?php include_once "template/header.php"; ?>

<body>
    <?php include_once "template/menu.php" ?>
    <div class="container mt-5">
<?php
    if ($row["nama_dpn"] != "") {
?>
        <div class="row">
            <div class="col-4">
                <h1>
                    <?php echo $row["nama_dpn"] . " " . $row["nama_blkg"] ?>
                </h1>
                <p class="text-muted h4 mb-5">
                    <?php echo $row["username"] ?>
                </p>
                <a class="btn btn-primary btn-block btn" data-toggle="tooltip" data-placement="top" title="Edit data anda" href="form.php?edit=true">Edit Profil</a>
                <a class="btn btn-primary btn-block btn" data-toggle="tooltip" data-placement="top" title="Hapus data anda" href="submit.php?delete=true&nim=<?php echo $nim ?>">Hapus Akun</a>
                <a class="btn btn-primary btn-block btn" data-toggle="tooltip" data-placement="top" title="Ganti password anda" href="form.php?edit_pass=true&nim=<?php echo $nim ?>">Edit Password</a>
            </div>
            <div class="col-8">
                <div class="card">
                    <p class="card-header h5">Profil Info</p>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-4 text-right">Nomor Induk Mahasiswa:</dt>
                            <dd class="col-8">
                                <?php echo $row["nim"] ?>
                            </dd>
                            <dt class="col-4 text-right">Email:</dt>
                            <dd class="col-8">
                                <?php echo $row["email"] ?>
                            </dd>
                            <dt class="col-4 text-right">Kelas:</dt>
                            <dd class="col-8">
                                <?php echo $row["kelas"] ?>
                            </dd>
                            <dt class="col-4 text-right">Hobi:</dt>
                            <dd class="col-8">
                                <?php echo $row["hobi"] ?>
                            </dd>
                            <dt class="col-4 text-right">Genre Film:</dt>
                            <dd class="col-8">
                                <?php echo $row["genre"] ?>
                            </dd>
                            <dt class="col-4 text-right">Tempat Wisata:</dt>
                            <dd class="col-8">
                                <?php echo $row["wisata"] ?>
                            </dd>
                            <dt class="col-4 text-right">Tanggal Lahir:</dt>
                            <dd class="col-8">
                                <?php echo $row["tanggal"] ?>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    <?php
        }else {
            ?>
            <div class="alert alert-warning mt-5 py-3" role="alert">
            Sepertinya anda belum melengkapi data pribadi anda, segera lengkapi data diri anda <a href="form.php" class="alert-link">disini</a>
            </div>
            <?php
        }
        $success = (!empty($_SESSION["success"])) ? $_SESSION["success"] : "";
        $succes = (!empty($success)) ? $success : "";
    ?>
    </div>
    <?php include_once "template/footer.php"; ?>
    <script src="./assets/bootstrap.js" charset="utf-8"></script>
    <script type="text/javascript">
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
</body>

</html>
<?php
} else {
        header("Location: index.php");
    } ?>
