<?php

class Flasher
{
    public static function setFlash($msg, $action, $type)
    {
        $_SESSION["flash"] = array(
            "pesan" => $pesan,
            "aksi" => $aksi,
            "tipe" => $tipe
        );
    }

    public static function flash()
    {
        if (isset($_SESSION["flash"])) {
            return $_SESSION["flash"];
        }
    }
}
