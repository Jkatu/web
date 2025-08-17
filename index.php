<?php
session_start();
require_once 'config/constants.php';
require_once 'classes/User.php';

$user = new User();

// Redirect if already logged in
if(isset($_SESSION['user'])) {
    switch($_SESSION['user']['UserType']) {
        case 'Super_User':
            header('Location: super_user/dashboard.php');
            break;
        case 'Administrator':
            header('Location: admin/dashboard.php');
            break;
        case 'Author':
            header('Location: author/dashboard.php');
            break;
    }
    exit();
}

// Handle login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if($userData = $user->login($username, $password)) {
        // Create session
        $_SESSION['user'] = $userData;
        
        // Redirect based on user type
        switch($userData['UserType']) {
            case 'Super_User':
                header('Location: super_user/dashboard.php');
                break;
            case 'Administrator':
                header('Location: admin/dashboard.php');
                break;
            case 'Author':
                header('Location: author/dashboard.php');
                break;
        }
        exit();
    } else {
        $login_error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Content Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Content Management System</h2>
            <?php if(isset($login_error)): ?>
                <div class="alert alert-danger"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>