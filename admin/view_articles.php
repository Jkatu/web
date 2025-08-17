<?php
require_once '../includes/auth_check.php';
require_once '../classes/Article.php';

$article = new Article();
$currentUser = $_SESSION['user'];
$page_title = 'View Articles';
include '../includes/header.php';

$articles = $article->getAllArticles();
?>

<div class="card">
    <div class="card-header">
        <h3>All Articles</h3>
    </div>
    <div class="card-body">
        <?php if($articles): ?>
            <div class="row">
                <?php foreach($articles as $art): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $art['article_title']; ?></h5>
                                <p class="card-text"><?php echo substr($art['article_full_text'], 0, 200) . '...'; ?></p>
                                <p class="text-muted">By <?php echo $art['author_name']; ?></p>
                                <p class="text-muted">Posted: <?php echo date('M j, Y', strtotime($art['article_created_date'])); ?></p>
                                <p class="text-muted">Status: <?php echo $art['article_display'] === 'yes' ? 'Published' : 'Hidden'; ?></p>
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

<?php include '../includes/footer.php'; ?>