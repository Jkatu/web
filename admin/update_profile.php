<?php
require_once '../includes/auth_check.php';
require_once '../classes/User.php';

$user = new User();
$currentUser = $_SESSION['user'];
$page_title = 'Update Profile';
include '../includes/header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'user_id' => $currentUser['userId'],
        'full_name' => trim($_POST['full_name']),
        'email' => trim($_POST['email']),
        'phone' => trim($_POST['phone']),
        'address' => trim($_POST['address'])
    ];
    
    if($user->updateProfile($data)) {
        // Update session data
        $_SESSION['user']['Full_Name'] = $data['full_name'];
        $_SESSION['user']['email'] = $data['email'];
        $_SESSION['user']['phone_Number'] = $data['phone'];
        $_SESSION['user']['Address'] = $data['address'];
        
        $success = "Profile updated successfully";
    } else {
        $error = "Failed to update profile";
    }
}

$userData = $user->getUserById($currentUser['userId']);
?>

<div class="card">
    <div class="card-header">
        <h3>Update Profile</h3>
    </div>
    <div class="card-body">
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" 
                       value="<?php echo $userData['Full_Name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo $userData['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                       value="<?php echo $userData['phone_Number']; ?>">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?php echo $userData['User_Name']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?php 
                    echo $userData['Address']; 
                ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>