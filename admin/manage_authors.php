<?php
require_once '../includes/auth_check.php';
require_once '../classes/User.php';

$user = new User();
$currentUser = $_SESSION['user'];
$page_title = 'Manage Authors';
include '../includes/header.php';

if(isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    if($user->deleteUser($userId)) {
        header('Location: manage_authors.php?success=Author+deleted');
        exit();
    } else {
        header('Location: manage_authors.php?error=Failed+to+delete+author');
        exit();
    }
}

$authors = $user->getAllUsers($currentUser['userId'], 'Author');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Authors</h1>
    <a href="add_author.php" class="btn btn-primary">Add New Author</a>
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
                    <th>Last Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($authors as $author): ?>
                    <tr>
                        <td><?php echo $author['userId']; ?></td>
                        <td><?php echo $author['User_Name']; ?></td>
                        <td><?php echo $author['Full_Name']; ?></td>
                        <td><?php echo $author['email']; ?></td>
                        <td><?php echo $author['AccessTime'] ? date('M j, Y H:i', strtotime($author['AccessTime'])) : 'Never'; ?></td>
                        <td>
                            <a href="edit_author.php?id=<?php echo $author['userId']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="manage_authors.php?delete=<?php echo $author['userId']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>