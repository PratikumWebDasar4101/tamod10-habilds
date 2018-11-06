<?php
require_once "init.php";
session_start();

$errors = "";
if (isset($_POST["register"])) {
    $nim = $_POST["nim"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rpassword = $_POST["rpassword"];

    if ($nim == "") {
        $errors = "NIM tidak boleh kosong";
        $_SESSION["errors"] = $errors;
        header("Location: register.php");
    } elseif ($username == "") {
        $errors = "Username tidak boleh kosong";
        $_SESSION["errors"] = $errors;
        header("Location: register.php");
    } elseif ($password == "") {
        $errors = "Password tidak boleh kosong";
        $_SESSION["errors"] = $errors;
        header("Location: register.php");
    } elseif ($rpassword == "") {
        $errors = "Password tidak sesuai.";
        $_SESSION["errors"] = $errors;
        header("Location: register.php");
    } else {
        if (is_numeric($nim) && strlen($nim) <= 10) {
            $db->select("user", "username");
            $db->where("username", "'$username'");
            $result = $db->execute();
            if ($db->rowCount($result) == 0) {
                if (!is_numeric($username) && strlen($nim) <= 20) {
                    $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/";
                    $email = strtolower($email);
                    if (preg_match($regex, $email)) {
                        if (strlen($password) > 6) {
                            if ($password == $rpassword) {
                                $data = ["nim" => $nim, "username" => $username, "password" => $password, "email" => $email];
                                $db->insert("user", $data);
                                if ($db->execute()) {
                                    $data = ["","","",$nim,"","","","",""];
                                    $db->insert("mahasiswa", $data, FALSE);
                                    if ($db->execute()) {
                                        header("Location: index.php?login=true");
                                    } else {
                                        echo "Terjadi kesalahan 2: " . $db->error();
                                    }
                                } else {
                                    echo "Terjadi kesalahan: " .$db->error();
                                }
                            } else {
                                $errors = "Password tidak sesuai.";
                                $_SESSION["errors"] = $errors;
                                header("Location: register.php");
                            }
                        } else {
                            $errors = "Password harus lebih dari 6 karakter";
                            $_SESSION["errors"] = $errors;
                            header("Location: register.php");
                        }
                    } else {
                        $errors = "Email tidak valid";
                        $_SESSION["errors"] = $errors;
                        header("Location: register.php");
                    }
                } else {
                    $errors = "Username tidak boleh angka dan lebih dari 20 karakter";
                    $_SESSION["errors"] = $errors;
                    header("Location: register.php");
                }
            }else {
                $errors = "Username telah terdaftar";
                $_SESSION["errors"] = $errors;
                header("Location: register.php");
            }
        } else {
            $errors = "NIM tidak valid";
            $_SESSION["errors"] = $errors;
            header("Location: register.php");
        }
    }
} elseif (isset($_POST["newdata"])) {
    $id = $_POST["id"];
    $nama_dpn = $_POST["namadpn"];
    $nama_blkg = $_POST["namablkng"];
    $hobi = implode(";", $_POST["hobi"]);
    $genre = implode(";", $_POST["genre"]);
    $wisata = implode(";", $_POST["wisata"]);
    $data = [
        "nama_dpn" => $nama_dpn,
        "nama_blkg" => $nama_blkg,
        "kelas" => $_POST["kelas"],
        "hobi" => $hobi,
        "genre" => $genre,
        "wisata" => $wisata,
        "tanggal" => $_POST["tanggal"]
    ];
    $db->update("mahasiswa", $data);
    $db->where("mahasiswa.id", $id);
    if ($db->execute()) {
        $_SESSION["last_activity"] = time();
        header("Location: profile.php");
    } else {
        echo "Error: " . $db->error();
    }
} elseif (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $nim = $_POST["nim"];
    $nama_dpn = $_POST["namadpn"];
    $nama_blkg = $_POST["namablkng"];
    $hobi = implode(";", $_POST["hobi"]);
    $genre = implode(";", $_POST["genre"]);
    $wisata = implode(";", $_POST["wisata"]);
    $data = [
        "nama_dpn" => $nama_dpn,
        "nama_blkg" => $nama_blkg,
        "kelas" => $_POST["kelas"],
        "hobi" => $hobi,
        "genre" => $genre,
        "wisata" => $wisata,
        "tanggal" => $_POST["tanggal"]
    ];
    $db->update("mahasiswa", $data);
    $db->where("mahasiswa.id", $id);
    if ($db->execute()) {
        $db->update("user", array("email" => $_POST["email"]));
        $db->where("nim", $nim);
        if ($db->execute()) {
            $_SESSION["last_activity"] = time();
            header("Location: profile.php");
        } else {
            echo "Error: " . $db->error();
        }
    } else {
        echo "Error: " . $db->error();
    }
} elseif (isset($_POST["login"])) {
    $username = "'" . $_POST["username"] . "'";
    $password = $_POST["password"];

    if ($username == "") {
        $errors = "Username harus diisi";
        $_SESSION["errors"] = $errors;
        header("Location: index.php?login=true");
    } elseif ($password == "") {
        $errors = "Password harus diisi";
        $_SESSION["errors"] = $errors;
        header("Location: index.php?login=true");
    } else {
        $db->select("user","nim, username, password");
        $db->where("username", $username);
        $result = $db->execute();
        $row = $db->fetchAll($result);
        $username = explode("'",$username);

        if ($username[1] == $row["username"]) {
            if ($password == $row["password"]) {
                $_SESSION["is_login"] = true;
                $_SESSION["nim"] = $row["nim"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["last_activity"] = time();
                header("Location: index.php");
            } else {
                $errors = "Password yang anda masukkan salah";
                $_SESSION["errors"] = $errors;
                header("Location: index.php?login=true");
            }
        } else {
            $errors = "Username tidak ditemukan";
            $_SESSION["errors"] = $errors;
            header("Location: index.php?login=true");
        }
    }
} elseif (isset($_GET["delete"]) && $_GET["delete"] == true) {
    $nim = $_GET["nim"];
    $db->delete("user",array("nim" => $nim));
    if ($db->execute()) {
        header("Location: logout.php");
    }
} elseif (isset($_POST["edit_pass"])) {
    $nim = $_POST["nim"];
    $pass = $_POST["pass"];
    $npass = $_POST["npass"];
    $npassr = $_POST["npassr"];

    if ($pass != "") {
        if ($npass != "") {
            if ($npassr != "") {
                if ($npass == $npassr) {
                    $db->select("user", "password");
                    $db->where("password", "'$pass'");
                    $result = $db->execute();
                    $row = $db->fetchAll($result);
                    if ($row["password"] == $pass) {
                        $db->update("user", array("password" => $npassr));
                        $db->where("nim", $nim);
                        if ($db->execute()) {
                            // $success = "Berhasil mengubah password";
                            // $_SESSION["success"] = $success;
                            header("Location: profile.php");
                        }else {
                            echo $db->error() . "<br>" . $db->getQuery();
                        }
                    } else {
                        $errors = "Password salah";
                        $_SESSION["errors"] = $errors;
                        header("Location: form.php?edit_pass=true");
                    }
                }else {
                    $errors = "Password tidak sesuai";
                    $_SESSION["errors"] = $errors;
                    header("Location: form.php?edit_pass=true");
                }
            } else {
                $errors = "Password tidak sesuai";
                $_SESSION["errors"] = $errors;
                header("Location: form.php?edit_pass=true");
            }
        } else {
            $errors = "Password baru tidak boleh kosong";
            $_SESSION["errors"] = $errors;
            header("Location: form.php?edit_pass=true");
        }
    } else {
        $errors = "Password tidak boleh kosong";
        $_SESSION["errors"] = $errors;
        header("Location: form.php?edit_pass=true");
    }
} else {
    header("Location: index.php");
}
