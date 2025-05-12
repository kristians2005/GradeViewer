<?php

// require_once "models/Dashboard.php";

require_once "models/User.php";
require_once "middleware.php";

class ProfileController
{
    public function index()
    {
        Middleware::isLoggedIn();
        require_once "views/profile.view.php";
    }

    public function updateInfo()
    {
        Middleware::isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $nick_name = $_POST['nick_name'] ?? '';
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validate required fields
            if (empty($first_name) || empty($last_name)) {
                $_SESSION['error'] = "First name and last name are required.";
                header("Location: /profile");
                exit;
            }

            // If changing password, validate
            if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
                if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                    $_SESSION['error'] = "All password fields are required when changing password.";
                    header("Location: /profile");
                    exit;
                }

                if ($new_password !== $confirm_password) {
                    $_SESSION['error'] = "New passwords do not match.";
                    header("Location: /profile");
                    exit;
                }

                // Verify current password
                $user = User::getUserById($_SESSION['user_id']);
                if (!password_verify($current_password, $user['password'])) {
                    $_SESSION['error'] = "Current password is incorrect.";
                    header("Location: /profile");
                    exit;
                }

                // Update password
                $result = User::updatePassword($_SESSION['user_id'], password_hash($new_password, PASSWORD_DEFAULT));
                if (!$result) {
                    $_SESSION['error'] = "Failed to update password.";
                    header("Location: /profile");
                    exit;
                }
            }

            // Update user info
            $result = User::updateUserInfo($_SESSION['user_id'], [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'nick_name' => $nick_name
            ]);

            if ($result) {
                // Update session variables
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['nick_name'] = $nick_name;
                $_SESSION['success'] = "Profile updated successfully.";
            } else {
                $_SESSION['error'] = "Failed to update profile.";
            }
        }

        header("Location: /profile");
        exit;
    }

    public function updatePicture()
    {
        Middleware::isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $file = $_FILES['profile_picture'];
            
            // Validate file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($file['type'], $allowed_types)) {
                $_SESSION['error'] = "Invalid file type. Please upload a JPG, PNG, or GIF image.";
                header("Location: /profile");
                exit;
            }

            if ($file['size'] > $max_size) {
                $_SESSION['error'] = "File is too large. Maximum size is 5MB.";
                header("Location: /profile");
                exit;
            }

            // Create uploads directory if it doesn't exist
            $upload_dir = 'uploads/profile_pictures/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('profile_') . '.' . $extension;
            $filepath = $upload_dir . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Update user's profile picture in database
                $result = User::updateProfilePicture($_SESSION['user_id'], $filepath);
                
                if ($result) {
                    $_SESSION['profile_picture'] = $filepath;
                    $_SESSION['success'] = "Profile picture updated successfully.";
                } else {
                    $_SESSION['error'] = "Failed to update profile picture.";
                    unlink($filepath); // Delete the uploaded file if database update fails
                }
            } else {
                $_SESSION['error'] = "Failed to upload profile picture.";
            }
        }

        header("Location: /profile");
        exit;
    }
}