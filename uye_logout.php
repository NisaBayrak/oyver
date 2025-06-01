<?php
session_start();
session_destroy();
header("Location: uye_giris.php");
exit;
?>