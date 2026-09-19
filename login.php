<?php
include 'db.php';
session_start();

$json_data = file_get_contents("php://input");
$request = json_decode($json_data, true);

if ($request) {
    // 1. JSON (Postman / API) Login Check
    if (isset($request['email']) && isset($request['password']) && !isset($request['signup_submit'])) {
        $email = mysqli_real_escape_string($conn, $request['email']);
        $password = mysqli_real_escape_string($conn, $request['password']);

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role'] = $user['role'] ?? 'user';

                echo json_encode([
                    "status" => "success",
                    "message" => "Login successful via Postman API Demo",
                    "email" => $user['email'],
                    "user_role" => $user['role'] ?? 'user'
                ]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Incorrect password!"]);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found!"]);
            exit();
        }
    }

    // JSON Signup
    if (isset($request['signup_submit']) && isset($request['email']) && isset($request['password'])) {
        $email = mysqli_real_escape_string($conn, $request['email']);
        $password = mysqli_real_escape_string($conn, $request['password']);
        
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $res = $conn->query($check_email);

        if ($res->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "This email already exists!"]);
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email, password, role) VALUES ('$email', '$hashed_password', 'user')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Account created successfully via Postman API!",
                    "email" => $email
                ]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
                exit();
            }
        }
    }
}

// Google Login Handler
if (isset($_POST['credential'])) {
    $jwt = $_POST['credential'];
    
    $parts = explode('.', $jwt);
    if (count($parts) === 3) {
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
        
        if ($payload && isset($payload['email'])) {
            $email = mysqli_real_escape_string($conn, $payload['email']);
            
            $check_user = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($check_user);
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['user_email'] = $email;
                $_SESSION['role'] = $user['role'] ?? 'user';

                // Admin Redirect Check (dashboard.php වෙත යොමු කෙරේ)
                if (($user['role'] ?? 'user') === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: profile.php");
                }
                exit();
            } else {
                $sql = "INSERT INTO users (email, password, role) VALUES ('$email', 'GOOGLE_ACCOUNT', 'user')";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['user_email'] = $email;
                    $_SESSION['role'] = 'user';
                    header("Location: profile.php");
                    exit();
                }
            }
        }
    }
    echo "<script>alert('Google login failed!'); window.location.href='index.php';</script>";
    exit();
}

// Signup Form Submit
if (isset($_POST['signup_submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "<script>alert('The two Passwords are not the same !'); window.location.href='index.php';</script>";
        exit();
    }

    $check_email = "SELECT * FROM users WHERE email='$email'";
    $res = $conn->query($check_email);

    if ($res->num_rows > 0) {
        echo "<script>alert('This email already exists in the system!'); window.location.href='index.php';</script>";
        exit();
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (email, password, role) VALUES ('$email', '$hashed_password', 'user')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_email'] = $email;
            $_SESSION['role'] = 'user';
            echo "<script>alert('Account created successfully!'); window.location.href='profile.php';</script>";
            exit();
        }
    }
}

// Main Web Form Login Handler
if (isset($_POST['login_submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'] ?? 'user'; 

            // Role එක අනුව Redirect වන ස්ථානය (admin/dashboard.php)
            if (($user['role'] ?? 'user') === 'admin') {
                header("Location: admin/dashboard.php"); 
            } else {
                header("Location: profile.php"); 
            }
            exit();
        } else {
            echo "<script>alert('Incorrect email or password.'); window.location.href='index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Incorrect email or password.'); window.location.href='index.php';</script>";
        exit();
    }
}
?>