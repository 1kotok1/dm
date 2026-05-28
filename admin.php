<?php
session_start();
require 'db.php';

if ($_SESSION['admin'] == 'false' || !isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

?>