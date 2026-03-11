<?php
    session_start();
    $_SESSION["role"] = null;
    header("location: index.php");
?>