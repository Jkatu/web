<?php
require_once '../config/connection.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (Full_Name, email, phone_Number, User_Name, Password, UserType, Address) 
                         VALUES (:full_name, :email, :phone, :username, :password, :user_type, :address)');
        
        // Bind values
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':user_type', $data['user_type']);
        $this->db->bind(':address', $data['address']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Login user
    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE User_Name = :username');
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        if($row) {
            $hashed_password = $row['Password'];
            if(password_verify($password, $hashed_password)) {
                // Update access time
                $this->updateAccessTime($row['userId']);
                return $row;
            }
        }
        return false;
    }
    
    // Update access time
    private function updateAccessTime($userId) {
        $this->db->query('UPDATE users SET AccessTime = NOW() WHERE userId = :user_id');
        $this->db->bind(':user_id', $userId);
        $this->db->execute();
    }
    
    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE User_Name = :username');
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        // Check row
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
        
        // Check row
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get user by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE userId = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Update user profile
    public function updateProfile($data) {
        $this->db->query('UPDATE users SET Full_Name = :full_name, email = :email, phone_Number = :phone, 
                          Address = :address WHERE userId = :user_id');
        
        // Bind values
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':user_id', $data['user_id']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update password
    public function updatePassword($data) {
        $this->db->query('UPDATE users SET Password = :password WHERE userId = :user_id');
        
        // Bind values
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':user_id', $data['user_id']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get all users (except current user)
    public function getAllUsers($currentUserId, $userType = null) {
        if($userType) {
            $this->db->query('SELECT * FROM users WHERE userId != :current_user AND UserType = :user_type ORDER BY created_at DESC');
            $this->db->bind(':current_user', $currentUserId);
            $this->db->bind(':user_type', $userType);
        } else {
            $this->db->query('SELECT * FROM users WHERE userId != :current_user ORDER BY created_at DESC');
            $this->db->bind(':current_user', $currentUserId);
        }
        
        return $this->db->resultset();
    }
    
    // Delete user
    public function deleteUser($userId) {
        $this->db->query('DELETE FROM users WHERE userId = :user_id');
        $this->db->bind(':user_id', $userId);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>