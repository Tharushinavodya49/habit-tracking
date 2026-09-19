<?php
include 'db.php'; 

$order_success = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['cust_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['cust_phone']);
    $address = mysqli_real_escape_string($conn, $_POST['cust_address']);
    $total = mysqli_real_escape_string($conn, $_POST['form_total']);
    
    
    $sql = "INSERT INTO orders (customer_name, contact_number, delivery_address, total_price) 
            VALUES ('$name', '$phone', '$address', '$total')";
            
    if ($conn->query($sql) === TRUE) {
        $order_success = true;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriTrack - Confirm Order</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #fff0f3; margin: 0; padding-bottom: 50px; }
        nav { background: white; padding: 15px; text-align: center; border-bottom: 2px solid #ffccd5; }
        nav a { margin: 0 15px; text-decoration: none; color: #ff4d6d; font-weight: bold; font-size: 16px; }
        .main-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        h2 { color: #ff4d6d; text-align: center; }
        .confirm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .card { background: white; padding: 25px; border-radius: 20px; border: 1px solid #ffccd5; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        h3 { color: #ff4d6d; margin-top: 0; border-bottom: 1px solid #ffccd5; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #555; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ffccd5; border-radius: 8px; box-sizing: border-box; }
        .total-line { font-size: 20px; font-weight: bold; color: #ff4d6d; margin-top: 20px; border-top: 2px dashed #ffccd5; padding-top: 15px; }
        .confirm-btn { padding: 15px; background-color: #ff4d6d; color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 18px; cursor: pointer; width: 100%; }
        .success-msg { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 10px; text-align: center; margin-bottom: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <nav>
        <a href="#">Profile</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="food.php">Order Food</a>
    </nav>

    <div class="main-container">
        <h2>Confirm Your Dietary Order</h2>
        
        <?php if ($order_success): ?>
            <div class="success-msg">
                🎉 Order Placed Successfully! Your details have been saved to the Database.
                <script> localStorage.clear(); setTimeout(function(){ window.location.href='food.php'; }, 3000); </script>
            </div>
        <?php endif; ?>

        <form action="confirm_order.php" method="POST" id="orderForm">
            <div class="confirm-grid">
                <div class="card">
                    <h3>1. Delivery & Contact Details</h3>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="cust_name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="cust_phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label>Delivery Address</label>
                        <textarea name="cust_address" rows="4" placeholder="Enter delivery address" required></textarea>
                    </div>
                </div>
                
                <div class="card">
                    <h3>2. Order Review</h3>
                    <div id="review-items" style="color: #555; line-height: 1.8;"></div>
                    <div class="total-line">Total: Rs. <span id="review-total">0</span></div>
                    
                    <input type="hidden" name="form_total" id="form_total">
                    
                    <button type="submit" class="confirm-btn" style="margin-top:20px;">Confirm & Place Order</button>
                </div>
            </div>
        </form>
    </div>

    <script>
      
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const cartTotal = localStorage.getItem('cartTotal') || 0;

        document.getElementById('review-items').innerHTML = cartItems.length > 0 ? cartItems.join('<br>') : "No items selected.";
        document.getElementById('review-total').innerText = cartTotal;
        document.getElementById('form_total').value = cartTotal; 
    </script>
</body>
</html>