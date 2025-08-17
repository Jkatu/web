<?php
require_once '../includes/auth_check.php';
require_once '../classes/User.php';

$user = new User();
$currentUser = $_SESSION['user'];
$users = $user->getAllUsers($currentUser['userId']);

// Handle delete user
if(isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    if($user->deleteUser($userId)) {
        header('Location: manage_users.php?success=User+deleted');
        exit();
    } else {
        header('Location: manage_users.php?error=Failed+to+delete+user');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Users</h1>
            <a href="add_user.php" class="btn btn-primary">Add New User</a>
        </div>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo urldecode($_GET['success']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo urldecode($_GET['error']); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Last Access</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                            <tr>
                                <td><?php echo $u['userId']; ?></td>
                                <td><?php echo $u['User_Name']; ?></td>
                                <td><?php echo $u['Full_Name']; ?></td>
                                <td><?php echo $u['email']; ?></td>
                                <td><?php echo $u['UserType']; ?></td>
                                <td><?php echo $u['AccessTime'] ? date('M j, Y H:i', strtotime($u['AccessTime'])) : 'Never'; ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $u['userId']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="manage_users.php?delete=<?php echo $u['userId']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>