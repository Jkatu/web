<?php
require_once '../config/connection.php';

class Article {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Add new article
    public function addArticle($data) {
        $this->db->query('INSERT INTO articles (authorId, article_title, article_full_text, article_display, article_order) 
                         VALUES (:author_id, :title, :full_text, :display, :order)');
        
        // Bind values
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':full_text', $data['full_text']);
        $this->db->bind(':display', $data['display']);
        $this->db->bind(':order', $data['order']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update article
    public function updateArticle($data) {
        $this->db->query('UPDATE articles SET article_title = :title, article_full_text = :full_text, 
                          article_display = :display, article_order = :order 
                          WHERE articleId = :article_id AND authorId = :author_id');
        
        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':full_text', $data['full_text']);
        $this->db->bind(':display', $data['display']);
        $this->db->bind(':order', $data['order']);
        $this->db->bind(':article_id', $data['article_id']);
        $this->db->bind(':author_id', $data['author_id']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get article by ID
    public function getArticleById($articleId) {
        $this->db->query('SELECT a.*, u.Full_Name as author_name 
                         FROM articles a 
                         JOIN users u ON a.authorId = u.userId 
                         WHERE a.articleId = :article_id');
        $this->db->bind(':article_id', $articleId);
        
        return $this->db->single();
    }
    
    // Get articles by author
    public function getArticlesByAuthor($authorId) {
        $this->db->query('SELECT * FROM articles WHERE authorId = :author_id ORDER BY article_created_date DESC');
        $this->db->bind(':author_id', $authorId);
        
        return $this->db->resultset();
    }
    
    // Get all articles
    public function getAllArticles($limit = null) {
        $query = 'SELECT a.*, u.Full_Name as author_name 
                 FROM articles a 
                 JOIN users u ON a.authorId = u.userId 
                 ORDER BY a.article_created_date DESC';
        
        if($limit) {
            $query .= ' LIMIT ' . $limit;
        }
        
        $this->db->query($query);
        return $this->db->resultset();
    }
    
    // Delete article
    public function deleteArticle($articleId, $authorId) {
        $this->db->query('DELETE FROM articles WHERE articleId = :article_id AND authorId = :author_id');
        $this->db->bind(':article_id', $articleId);
        $this->db->bind(':author_id', $authorId);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get latest articles
    public function getLatestArticles($limit = 6) {
        $this->db->query('SELECT a.*, u.Full_Name as author_name 
                         FROM articles a 
                         JOIN users u ON a.authorId = u.userId 
                         WHERE a.article_display = "yes" 
                         ORDER BY a.article_created_date DESC 
                         LIMIT ' . $limit);
        
        return $this->db->resultset();
    }
}
?>