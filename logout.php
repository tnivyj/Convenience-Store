<?php
    session_start();
    header('Content-type:text/html;charset=utf-8');
    if(isset($_SESSION['userName'])){
        $_SESSION = array();
        header('location:index.php');
    }
?>