<?php

session_start();

/* Hapus semua session */
session_unset();
session_destroy();

/* Arahkan kembali ke login */
header("Location: login.php");
exit;

?>