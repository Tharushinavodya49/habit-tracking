<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['user_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $cart_items = mysqli_real_escape_string($conn, $_POST['cart_items']);
    $cart_total = mysqli_real_escape_string($conn, $_POST['cart_total']);

    $sql = "INSERT INTO orders (customer_name, contact_number, delivery_address, items, total_price) 
            VALUES ('$user_email', '$contact', '$address', '$cart_items', '$cart_total')";
    
    if ($conn->query($sql) === TRUE) {
       
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }
} else {
    header("Location: food.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Successful - NutriTrack</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
           
            background: linear-gradient(135deg, #a5c7f7 0%, #ffe3ec 50%, #d6bbfb 100%);
            background-attachment: fixed;
            margin: 0; 
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #3b2861;
        }

        
        .success-container {
            background: rgba(255, 255, 255, 0.45); 
            backdrop-filter: blur(25px); 
            -webkit-backdrop-filter: blur(25px);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 15px 35px rgba(106, 27, 154, 0.08); 
            border: 1px solid rgba(255, 255, 255, 0.6); 
            text-align: center;
            max-width: 480px;
            width: 90%;
            box-sizing: border-box;
            transition: transform 0.3s;
        }

        .success-container:hover {
            transform: translateY(-5px);
        }

        
        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(46, 196, 182, 0.15);
            color: #2ec4b6;
            font-size: 40px;
            line-height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            font-weight: bold;
            box-shadow: 0 0 20px rgba(46, 196, 182, 0.2);
        }

        h2 {
            color: #4a148c;
            margin-top: 0;
            font-size: 26px;
            font-weight: 700;
        }

        p {
            font-size: 15px;
            line-height: 1.6;
            color: #554376;
            margin-bottom: 25px;
        }

        
        .details-box {
            background: rgba(255, 255, 255, 0.5); 
            padding: 20px; 
            border-radius: 16px; 
            text-align: left; 
            font-size: 14.5px; 
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            line-height: 1.8;
        }
        
        .details-box b {
            color: #4a148c;
        }

       
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 14px 35px;
            background: linear-gradient(135deg, #9c27b0, #ff4d6d); 
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(255, 77, 109, 0.25);
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(255, 77, 109, 0.35);
            opacity: 0.95;
        }
    </style>
</head>
<body>

    <div class="success-container">
        <div class="icon-circle">✔</div>
        <h2>Order Placed Successfully!</h2>
        <p>Your order has been successfully entered into the system. You will receive your healthy meal shortly!</p>
        
        <div class="details-box">
            <b>Ordered Items:</b> <?php echo htmlspecialchars($cart_items); ?><br>
            <b>Total Price:</b> Rs. <?php echo htmlspecialchars($cart_total); ?><br>
            <b>Delivery Address:</b> <?php echo htmlspecialchars($address); ?>
        </div>

        <a href="dashboard.php" class="btn-back">Go to Dashboard ➔</a>
    </div>

</body>
</html>