<?php
require_once '../includes/auth_check.php';
require_once '../classes/User.php';
require_once '../classes/Article.php';

$user = new User();
$article = new Article();

$currentUser = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container mt-5">
        <h1 class="mb-4">Super User Dashboard</h1>
        
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="update_profile.php" class="btn btn-primary w-100">Update My Profile</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="manage_users.php" class="btn btn-success w-100">Manage Other Users</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="view_articles.php" class="btn btn-info w-100">View Articles</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="../logout.php" class="btn btn-danger w-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h3>Latest Articles</h3>
            </div>
            <div class="card-body">
                <?php $articles = $article->getLatestArticles(); ?>
                <?php if($articles): ?>
                    <div class="row">
                        <?php foreach($articles as $art): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $art['article_title']; ?></h5>
                                        <p class="card-text"><?php echo substr($art['article_full_text'], 0, 100) . '...'; ?></p>
                                        <p class="text-muted">By <?php echo $art['author_name']; ?></p>
                                        <p class="text-muted">Posted: <?php echo date('M j, Y', strtotime($art['article_created_date'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No articles found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>