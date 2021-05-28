<?php
    session_start();
    setcookie("session_cookie", "", time() - 3600);
    session_destroy();
    header('Location: ../login.php');
?>