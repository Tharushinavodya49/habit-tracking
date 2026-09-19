<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['user_email'];


$sql = "SELECT id, contact_number, delivery_address, items, total_price, status, order_date FROM orders WHERE customer_name = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History - NutriTrack</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            
            background: linear-gradient(135deg, #c3e6cb 0%, #f4f7f6 50%, #fbcfe8 100%);
            background-attachment: fixed;
            margin: 0; 
            padding-bottom: 60px; 
            color: #1b5e20; 
        }

        
        nav { 
            background: rgba(27, 94, 32, 0.9); 
            backdrop-filter: blur(25px); 
            -webkit-backdrop-filter: blur(25px);
            padding: 35px 20px; 
            text-align: center; 
            border-bottom: 3px solid rgba(255, 255, 255, 0.2); 
            position: sticky; 
            top: 0; 
            z-index: 100; 
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); 
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
            background: rgba(255, 255, 255, 0.12);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 30px;
            box-shadow: inset 0 1px 4px rgba(255, 255, 255, 0.1), 0 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        
       
        nav a:hover { 
            color: #ffffff; 
            background: #d81b60; 
            border-color: #d81b60;
            box-shadow: 0 6px 20px rgba(216, 27, 96, 0.5);
            transform: translateY(-2px);
        }

        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        h2 { text-align: center; color: #1b5e20; font-weight: 600; letter-spacing: 0.3px; }

        
        .order-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s;
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(27, 94, 32, 0.1);
        }

        .order-details p { margin: 6px 0; color: #333333; font-size: 14px; }
        .order-id { font-size: 18px; font-weight: bold; color: #1b5e20; margin-bottom: 8px; }
        .price { font-weight: bold; color: #c2185b; font-size: 17px; }

        
        .status-badge {
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            color: white;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .pending { background: linear-gradient(135deg, #ffb703, #fb8500); }      
        .preparing { background: linear-gradient(135deg, #4a90e2, #1d6fa5); }    
        .delivered { background: linear-gradient(135deg, #2e7d32, #1b5e20); }    
        
        .no-orders { text-align: center; font-weight: bold; color: #757575; margin-top: 50px; font-style: italic; }
    </style>
</head>
<body>

    <nav>
        <a href="profile.php">Profile</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="food.php">Order Food</a> 
       
        <a href="order_history.php" style="border-bottom: 3px solid #ffffff;">Order History</a> 
    </nav>

    <div class="container">
        <h2>Your Order History & Tracking</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): 
                $status_class = "pending";
                $current_status = isset($row['status']) ? strtolower($row['status']) : 'pending';
                
                if($current_status == 'preparing') $status_class = "preparing";
                if($current_status == 'delivered') $status_class = "delivered";
            ?>
                <div class="order-card">
                    <div class="order-details">
                        <div class="order-id">Order #<?php echo $row['id']; ?></div>
                        <p style="font-weight: 600; color: #1b5e20;">Items: <?php echo htmlspecialchars($row['items']); ?></p>
                        <p>Address: <?php echo htmlspecialchars($row['delivery_address']); ?></p>
                        <p style="color: #757575;">Date: <?php echo $row['order_date'] ?? 'Just Now'; ?></p>
                        <p class="price">Total: Rs. <?php echo htmlspecialchars($row['total_price']); ?></p>
                    </div>
                    
                    <div>
                        <span class="status-badge <?php echo $status_class; ?>">
                            <?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Pending'; ?>
                        </span>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-orders">You haven't placed any orders yet!</p>
        <?php endif; ?>

    </div>

</body>
</html>
<?php 
$stmt->close();
$conn->close();
?>