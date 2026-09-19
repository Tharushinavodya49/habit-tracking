<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$display_name = explode('@', $user_email)[0];


$saved_height = "";
$saved_weight = "";
$saved_age = "";
$saved_gender = "";
$saved_activity = "";

$fetch_sql = "SELECT height, weight, age, gender, activity FROM users WHERE email='$user_email'";
$result = $conn->query($fetch_sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $saved_height = $row['height'];
    $saved_weight = $row['weight'];
    $saved_age = $row['age'];
    $saved_gender = $row['gender'];
    $saved_activity = $row['activity'];
}


if (isset($_POST['save_profile'])) {
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $activity = mysqli_real_escape_string($conn, $_POST['activity']);

    $sql = "UPDATE users SET height='$height', weight='$weight', age='$age', gender='$gender', activity='$activity' WHERE email='$user_email'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Details saved successfully!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - NutriTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #fff0f3 0%, #f0d3ff 35%, #ffccd5 70%, #ffb3c1 100%); 
            background-attachment: fixed;
            margin: 0; 
            padding-bottom: 60px; 
            color: #4a0010; 
        }

        nav { 
            background: linear-gradient(135deg, rgba(164, 19, 60, 0.85), rgba(123, 19, 52, 0.85), rgba(106, 27, 154, 0.85)); 
            backdrop-filter: blur(30px); 
            -webkit-backdrop-filter: blur(30px);
            padding: 35px 20px; 
            text-align: center; 
            border-bottom: 3px solid rgba(255, 255, 255, 0.3); 
            position: sticky; 
            top: 0; 
            z-index: 100; 
            box-shadow: 0 10px 35px rgba(123, 19, 52, 0.3); 
        }
        
        nav a { 
            margin: 0 15px; 
            text-decoration: none; 
            color: #ffffff; 
            font-weight: 700; 
            font-size: 18px; 
            letter-spacing: 0.5px;
            transition: all 0.3s ease; 
            padding: 14px 28px; 
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-radius: 30px;
            box-shadow: inset 0 1px 4px rgba(255, 255, 255, 0.2), 0 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        
        nav a:hover { 
            color: #ffffff; 
            background: linear-gradient(135deg, #8e24aa, #d81b60); 
            border-color: #ff4081;
            box-shadow: 0 0 25px rgba(216, 27, 96, 0.7);
            transform: translateY(-2px);
        }

        .page-wrapper {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 40px;
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
            align-items: start;
        }

        .left-profile-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 40px 25px;
            border-radius: 28px;
            box-shadow: 0 25px 50px rgba(123, 19, 52, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.8);
            text-align: center;
        }

        .welcome-title {
            font-size: 26px;
            font-weight: 700;
            color: #7b1334;
            text-align: left;
            margin-bottom: 5px;
        }

        .welcome-subtitle {
            font-size: 14px;
            color: #8e24aa;
            text-align: left;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .avatar-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 25px auto;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #d81b60;
            box-shadow: 0 8px 20px rgba(216, 27, 96, 0.2);
        }

        .camera-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: linear-gradient(135deg, #d81b60, #8e24aa);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: 0.3s ease;
        }

        .camera-btn:hover {
            transform: scale(1.1);
        }

        .camera-btn i {
            color: white;
            font-size: 14px;
        }

        .container { 
            background: rgba(255, 255, 255, 0.75); 
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 40px; 
            border-radius: 28px; 
            box-shadow: 0 25px 50px rgba(123, 19, 52, 0.15); 
            border: 2px solid rgba(255, 255, 255, 0.8);
            text-align: left; 
            box-sizing: border-box;
            margin: 0; 
            width: 100%;
        }

        h2 { 
            color: #7b1334; 
            text-align: center; 
            margin-top: 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 20px;
        }

        .user-info { 
            text-align: center; 
            font-size: 14px; 
            color: #5c001e; 
            margin-bottom: 30px; 
            background: rgba(240, 211, 255, 0.6); 
            padding: 12px;
            border-radius: 12px;
            border: 1px solid rgba(142, 36, 170, 0.2);
            word-break: break-all;
        }

        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #7b1334;
            letter-spacing: 0.3px;
        }

        input, select { 
            width: 100%; 
            padding: 14px; 
            border: 1px solid rgba(123, 19, 52, 0.25); 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 15px;
            background: rgba(255, 255, 255, 0.9);
            color: #4a0010;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #8e24aa; 
            box-shadow: 0 0 10px rgba(142, 36, 170, 0.3);
        }

        button { 
            width: 100%; 
            padding: 16px; 
            background: linear-gradient(135deg, #ad1457, #6a1b9a); 
            color: white; 
            border: none; 
            border-radius: 12px; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 16px; 
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(106, 27, 154, 0.3);
            transition: all 0.3s ease;
        }

        button:hover { 
            background: linear-gradient(135deg, #d81b60, #8e24aa); 
            transform: translateY(-1px); 
            box-shadow: 0 8px 20px rgba(216, 27, 96, 0.4); 
        }
        
        button:active {
            transform: translateY(1px);
        }

        ::placeholder {
            color: #7b1334;
            opacity: 0.4;
        }
    </style>
</head>
<body>

    <nav>
        <a href="profile.php">Profile</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="food.php">Order Food</a>
        <a href="order history">Order History</a>
    </nav>
    
    <div class="page-wrapper">
        
        <div class="left-profile-card">
            <div class="welcome-title">Hello, <?php echo htmlspecialchars($display_name); ?>!</div>
            <div class="welcome-subtitle">Welcome back to your fitness space</div>
            
            <div class="avatar-container">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" id="profilePre" class="profile-img" alt="Profile Image">
                <input type="file" id="imageInput" accept="image/*" style="display: none;" onchange="previewImage(event)">
                <label for="imageInput" class="camera-btn">
                    <i class="fa-solid fa-camera"></i>
                </label>
            </div>
            
            <div class="user-info" style="margin-bottom: 0;">
                Logged in as: <br><b><?php echo htmlspecialchars($user_email); ?></b>
            </div>
        </div>

        <div class="container">
            <h2>Your Information</h2>
            
            <form action="profile.php" method="POST">
                <div class="form-group">
                    <label>Height (cm):</label>
                    <input type="number" step="0.1" name="height" placeholder="Enter height in cm" value="<?php echo htmlspecialchars($saved_height); ?>" required>
                </div>

                <div class="form-group">
                    <label>Weight (kg):</label>
                    <input type="number" step="0.1" name="weight" placeholder="Enter weight in kg" value="<?php echo htmlspecialchars($saved_weight); ?>" required>
                </div>

                <div class="form-group">
                    <label>Age (Years):</label>
                    <input type="number" name="age" placeholder="Enter your age" value="<?php echo htmlspecialchars($saved_age); ?>">
                </div>

                <div class="form-group">
                    <label>Gender:</label>
                    <select name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male" <?php if($saved_gender == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if($saved_gender == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Activity Level:</label>
                    <select name="activity">
                        <option value="">Select Activity Level</option>
                        <option value="Sedentary" <?php if($saved_activity == 'Sedentary') echo 'selected'; ?>>Not very active (Sedentary)</option>
                        <option value="Lightly Active" <?php if($saved_activity == 'Lightly Active') echo 'selected'; ?>>A Little active</option>
                        <option value="Moderately Active" <?php if($saved_activity == 'Moderately Active') echo 'selected'; ?>>Normally functional</option>
                        <option value="Very Active" <?php if($saved_activity == 'Very Active') echo 'selected'; ?>>Very high performance</option>
                    </select>
                </div>

                <button type="submit" name="save_profile">Save & View Dashboard ➔</button>
            </form>
        </div>

    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profilePre').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>