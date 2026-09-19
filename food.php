<!DOCTYPE html>
<html>
<head>
    <title>Order Healthy Food - NutriTrack</title>
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

        .page-layout {
            display: flex;
            max-width: 1300px;
            margin: 40px auto;
            padding: 0 20px;
            gap: 35px;
            align-items: flex-start;
        }

        .food-section {
            flex: 3; 
        }

        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        .cart-section {
            flex: 1.2;
            min-width: 360px;
            position: sticky;
            top: 170px; 
        }

        .food-card {
            background: rgba(255, 255, 255, 0.92); 
            backdrop-filter: blur(10px); 
            padding: 25px; 
            border-radius: 24px; 
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05); 
            border: 1px solid rgba(255, 255, 255, 1); 
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s;
        }

        .food-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px rgba(27, 94, 32, 0.15);
        }

        .cart-card {
            background: #ffffff; 
            padding: 32px; 
            border-radius: 28px; 
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.16), 0 8px 20px rgba(0, 0, 0, 0.08); 
            border: 2px solid rgba(27, 94, 32, 0.15); 
        }

        .food-image-container {
            width: 100%;
            height: 180px;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .food-img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            transition: transform 0.4s ease;
        }

        .food-card:hover .food-img {
            transform: scale(1.05);
        }

        .food-name { font-size: 19px; font-weight: 600; color: #1b5e20; margin-bottom: 6px; }
        .food-price { font-size: 17px; color: #c2185b; font-weight: 700; margin-bottom: 15px; }
        
        .add-btn { 
            width: 100%; 
            padding: 13px; 
            background: linear-gradient(135deg, #d81b60, #ad1457); 
            color: white; 
            border: none; 
            border-radius: 12px; 
            font-weight: bold; 
            font-size: 14px;
            cursor: pointer; 
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(173, 20, 87, 0.2);
        }
        .add-btn:hover { 
            transform: translateY(-1px); 
            box-shadow: 0 6px 18px rgba(216, 27, 96, 0.4);
        }

        .order-btn {
            width: 100%; 
            padding: 15px; 
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.25);
        }
        .order-btn:hover { 
            transform: translateY(-1px); 
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.45); 
        }

        .cart-title { font-size: 22px; font-weight: bold; color: #1b5e20; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid rgba(0,0,0,0.05); padding-bottom: 12px; }
        .cart-empty { text-align: center; color: #757575; padding: 20px 0; font-style: italic; font-size: 14px; }
        .input-group { margin-top: 18px; }
        .input-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #2e7d32; letter-spacing: 0.3px; }
        
        .input-group input, .input-group textarea { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid rgba(46, 125, 50, 0.25); 
            border-radius: 10px; 
            background: #ffffff; 
            box-sizing: border-box; 
            font-family: inherit; 
            color: #333333; 
            transition: all 0.3s;
        }
        .input-group input:focus, .input-group textarea:focus { 
            outline: none; 
            border-color: #d81b60; 
            box-shadow: 0 0 10px rgba(216, 27, 96, 0.15);
        }
        ::placeholder { color: #9e9e9e; }

        .total-section { display: flex; justify-content: space-between; font-weight: bold; font-size: 20px; color: #1b5e20; margin-top: 25px; border-top: 2px solid rgba(0,0,0,0.05); padding-top: 15px; }

        @media (max-width: 900px) {
            .page-layout { flex-direction: column; }
            .cart-section { width: 100%; position: static; min-width: auto; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="profile.php">Profile</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="food.php" style="border-bottom: 3px solid #ffffff;">Order Food <span id="cartCounter" style="background: #ff4d6d; color: white; border-radius: 50%; padding: 2px 8px; font-size: 13px; margin-left: 5px; display: none;">0</span></a>
        <a href="order_history.php">Order History</a>
    </nav>

    <div class="page-layout">
        
        <div class="food-section">
            <h2 style="color: #1b5e20; margin-bottom: 25px; font-weight: 600; letter-spacing: 0.3px;">Choose Your Healthy Meal</h2>
            
            <div class="food-grid">
                
                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/blueberry.jpg" alt="Blueberry" class="food-img">
                    </div>
                    <div class="food-name">Blueberry</div>
                    <div class="food-price">Rs. 950</div>
                    <button class="add-btn" onclick="addToCart('Blueberry', 950)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/geek.png" alt="Geek Yogurt" class="food-img">
                    </div>
                    <div class="food-name">Geek Yogurt</div>
                    <div class="food-price">Rs. 730</div>
                    <button class="add-btn" onclick="addToCart('Geek Yogurt', 730)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/cinnamon.jpg" alt="SEYLON Cinnamon" class="food-img">
                    </div>
                    <div class="food-name">SEYLON Cinnamon</div>
                    <div class="food-price">Rs. 250</div>
                    <button class="add-btn" onclick="addToCart('SEYLON Cinnamon', 250)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/almond.jpg" alt="Almond" class="food-img">
                    </div>
                    <div class="food-name">Almond</div>
                    <div class="food-price">Rs. 500</div>
                    <button class="add-btn" onclick="addToCart('Almond', 500)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/honey.jpg" alt="Honey" class="food-img">
                    </div>
                    <div class="food-name">honey</div>
                    <div class="food-price">Rs. 458</div>
                    <button class="add-btn" onclick="addToCart('Honey', 458)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/greentea.jpg" alt="Grean tea" class="food-img">
                    </div>
                    <div class="food-name">Green Tea</div>
                    <div class="food-price">Rs. 990</div>
                    <button class="add-btn" onclick="addToCart('Green tea', 990)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/Organic protein.jpg" alt="Organic Protein" class="food-img">
                    </div>
                    <div class="food-name">Organic protein</div>
                    <div class="food-price">Rs. 2300</div>
                    <button class="add-btn" onclick="addToCart('Organic protein', 2300)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/aots.png" alt="aots" class="food-img">
                    </div>
                    <div class="food-name">Aots</div>
                    <div class="food-price">Rs. 1550</div>
                    <button class="add-btn" onclick="addToCart('Aots', 1550)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/matcha.jpg" alt="Matcha Latte Powder" class="food-img">
                    </div>
                    <div class="food-name">Matcha Latte Powder</div>
                    <div class="food-price">Rs. 3100</div>
                    <button class="add-btn" onclick="addToCart('Matcha Latte Powder', 3100)">Add to Cart</button>
                </div>

                 <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/sesame seeds.jpg" alt="Sesame Seeds" class="food-img">
                    </div>
                    <div class="food-name">Sesame Seeds</div>
                    <div class="food-price">Rs. 350</div>
                    <button class="add-btn" onclick="addToCart('Sesame Seeds', 350)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/olive oil.jpg" alt="Olive Oil" class="food-img">
                    </div>
                    <div class="food-name">Olive Oil</div>
                    <div class="food-price">Rs. 2448</div>
                    <button class="add-btn" onclick="addToCart('Olive Oil', 2448)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/pink salt.jpg" alt="Pink Salt" class="food-img">
                    </div>
                    <div class="food-name">Pink Salt</div>
                    <div class="food-price">Rs. 470</div>
                    <button class="add-btn" onclick="addToCart('Pink Salt', 470)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/garlic powder.png" alt="garlic powder" class="food-img">
                    </div>
                    <div class="food-name">GARLIC Powder</div>
                    <div class="food-price">Rs. 500</div>
                    <button class="add-btn" onclick="addToCart('GARLIC Powder', 500)">Add to Cart</button>
                </div>

                <div class="food-card">
                    <div class="food-image-container">
                        <img src="img/margarine 3.png" alt="margarine 3" class="food-img">
                    </div>
                    <div class="food-name">Margarine Omega 3 Lactantia </div>
                    <div class="food-price">Rs. 870</div>
                    <button class="add-btn" onclick="addToCart('Margarine Omega 3 Lactantia', 870)">Add to Cart</button>
                </div>

            </div>
        </div>

        <div class="cart-section">
            <div class="cart-card">
                <div class="cart-title">
                    <span>Your Cart</span>
                    <span>🛒</span>
                </div>
                
                <div id="cart-content">
                    <div class="cart-empty">The cart is empty.</div>
                </div>

                <div class="total-section">
                    <span>Total:</span>
                    <span id="cart-total">Rs. 0</span>
                </div>

                <form action="success.php" method="POST" id="orderForm">
                    <input type="hidden" name="cart_items" id="hiddenCartItems" value="">
                    <input type="hidden" name="cart_total" id="hiddenCartTotal" value="0">

                    <div class="input-group">
                        <label>Contact Number:</label>
                        <input type="text" name="contact" placeholder="Eg: 0712345678" required>
                    </div>

                    <div class="input-group">
                        <label>Delivery Address:</label>
                        <textarea name="address" rows="3" placeholder="99/A, behind the temple, Ratnapura" required></textarea>
                    </div>

                    <button type="submit" class="order-btn">Order Now ➔</button>
                </form>
                
            </div>
        </div>

    </div>

    <script>
        let cart = [];
        
        function addToCart(name, price) {
            cart.push({name, price});
            updateCartUI();
            
            
            updateCartCount(cart.length);
        }

        
        function updateCartCount(totalItems) {
            const counter = document.getElementById('cartCounter');
            if (totalItems > 0) {
                counter.innerText = totalItems;
                counter.style.display = 'inline-block'; 
            } else {
                counter.style.display = 'none'; 
            }
        }

        function updateCartUI() {
            const content = document.getElementById('cart-content');
            const totalEl = document.getElementById('cart-total');
            const hiddenItemsInput = document.getElementById('hiddenCartItems');
            const hiddenTotalInput = document.getElementById('hiddenCartTotal');
            
            if(cart.length === 0) {
                content.innerHTML = '<div class="cart-empty">The cart is empty.</div>';
                totalEl.innerText = 'Rs. 0';
                hiddenItemsInput.value = "";
                hiddenTotalInput.value = "0";
                return;
            }

            let html = '';
            let total = 0;
            let itemNames = [];

            cart.forEach((item) => {
                html += `<div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:14px; color:#333333;">
                            <span>${item.name}</span>
                            <span style="font-weight:bold; color:#d81b60;">Rs. ${item.price}</span>
                         </div>`;
                total += item.price;
                itemNames.push(item.name);
            });
            
            content.innerHTML = html;
            totalEl.innerText = 'Rs. ' + total;

            hiddenItemsInput.value = itemNames.join(', ');
            hiddenTotalInput.value = total;
        }

        document.getElementById('orderForm').addEventListener('submit', function(e) {
            if(cart.length === 0) {
                e.preventDefault(); 
                alert('Please add the food items to the cart first!');
            }
        });
    </script>
</body>
</html>