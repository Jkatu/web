<?php
session_start();

if(!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

// Check user type for specific directories
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$user_type = $_SESSION['user']['UserType'];

$allowed = false;

switch($user_type) {
    case 'Super_User':
        if($current_dir == 'super_user') $allowed = true;
        break;
    case 'Administrator':
        if($current_dir == 'admin') $allowed = true;
        break;
    case 'Author':
        if($current_dir == 'author') $allowed = true;
        break;
}

if(!$allowed) {
    header('Location: ../index.php');
    exit();
}
?>