<!DOCTYPE html>
<html>
<head>
    <title>Health Dashboard - NutriTrack</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: linear-gradient(135deg, #a5c7f7 0%, #ffe3ec 50%, #d6bbfb 100%);
            background-attachment: fixed;
            margin: 0; 
            padding-bottom: 60px; 
            color: #3b2861;
        }

        
        nav { 
            background: linear-gradient(135deg, rgba(74, 20, 140, 0.95), rgba(136, 14, 79, 0.95)); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            padding: 30px 20px; 
            text-align: center; 
            border-bottom: 3px solid rgba(255, 255, 255, 0.25); 
            position: sticky; 
            top: 0; 
            z-index: 100; 
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.3);
        }
        
        nav a { 
            margin: 0 15px; 
            text-decoration: none; 
            color: #ffffff; 
            font-weight: 700; 
            font-size: 17px; 
            letter-spacing: 0.5px;
            transition: all 0.3s ease; 
            padding: 12px 24px; 
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 30px;
            display: inline-block;
        }
        
        nav a:hover { 
            color: #ffffff; 
            background: rgba(255, 255, 255, 0.3);
            border-color: #ffffff;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        
        .ai-chat-container {
            background: rgba(15, 23, 42, 0.95); 
            color: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            margin: 25px auto 10px;
            max-width: 1160px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ai-header {
            font-size: 16px;
            font-weight: bold;
            color: #6ee7b7;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ai-response-area {
            min-height: 50px;
            max-height: 200px;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .ai-input-group {
            display: flex;
            gap: 10px;
        }

        .ai-input-group input {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 14px;
            outline: none;
        }

        .ai-input-group input::placeholder {
            color: #94a3b8;
        }

        .ai-input-group button {
            background: linear-gradient(135deg, #9c27b0, #ff4d6d);
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .ai-input-group button:hover {
            opacity: 0.9;
        }
        
        .main-container { 
            max-width: 1200px; 
            margin: 20px auto; 
            padding: 0 20px; 
        }
        
        h2 { 
            color: #4a148c; 
            text-align: center; 
            margin-bottom: 30px; 
            font-size: 26px; 
            font-weight: 700;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
        }

        .chart-card { 
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            padding: 25px; 
            border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(106, 27, 154, 0.04); 
            border: 1px solid rgba(255, 255, 255, 0.5); 
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(106, 27, 154, 0.1);
        }
        
        .chart-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 15px; 
            border-bottom: 1px solid rgba(255,255,255,0.3); 
            padding-bottom: 8px; 
        }
        .chart-title { font-size: 17px; font-weight: bold; color: #3b2861; }
        .chart-icon { font-size: 22px; }

        .input-group { 
            display: flex; 
            gap: 8px; 
            justify-content: center; 
            margin-bottom: 15px; 
            background: rgba(255, 255, 255, 0.4); 
            padding: 10px; 
            border-radius: 12px; 
            align-items: center; 
        }
        .input-group label { font-weight: 600; color: #554376; font-size: 13px; }
        .input-group input { 
            padding: 6px; 
            border: 1px solid rgba(106, 27, 154, 0.2); 
            border-radius: 6px; 
            width: 65px; 
            text-align: center; 
            background: white; 
            font-weight: bold; 
            color: #3b2861;
            outline: none;
        }
        
        .input-group button { 
            background: linear-gradient(135deg, #9c27b0, #ff4d6d); 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 6px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: opacity 0.2s;
        }
        .input-group button:hover { opacity: 0.9; }

        .progress-container {
            margin: 15px 0;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.6);
        }
        .progress-bar {
            height: 14px;
            width: 0%;
            background: linear-gradient(90deg, #9c27b0, #ff4d6d);
            border-radius: 10px;
            transition: width 0.5s ease-in-out;
        }
        .goal-text {
            font-size: 12px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            color: #554376;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .days-check-group { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin-bottom: 15px; }
        .days-check-group label { 
            background: rgba(255,255,255,0.5); 
            padding: 6px; 
            border-radius: 8px; 
            font-size: 11px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 4px; 
            cursor: pointer; 
            font-weight: 600; 
            color: #3b2861;
        }
        
        .canvas-container { position: relative; height: 200px; width: 100%; }
        
        button.order-btn { 
            width: 100%; 
            max-width: 320px; 
            padding: 15px; 
            background: linear-gradient(135deg, #9c27b0, #ff4d6d); 
            color: white; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold; 
            display: block; 
            margin: 40px auto 0; 
            box-shadow: 0 10px 20px rgba(255, 77, 109, 0.2); 
            transition: transform 0.2s;
        }
        button.order-btn:hover { transform: translateY(-2px); }
    </style>
</head>
<body>

    <nav>
        <a href="profile.php">Profile</a>
        <a href="dashboard.php" style="border-bottom: 3px solid #ffffff;">Dashboard</a>
        <a href="food.php">Order Food <span id="cartCounter" style="background: #ff4d6d; color: white; border-radius: 50%; padding: 2px 8px; font-size: 13px; margin-left: 5px; display: none;">0</span></a>
        <a href="food.php">Order History <span id="cartCounter" style="background: #ff4d6d; color: white; border-radius: 50%; padding: 2px 8px; font-size: 13px; margin-left: 5px; display: none;">0</span></a>
    </nav>

    
    <div class="main-container">
        <div class="ai-chat-container">
            <div class="ai-header">🤖 NutriTrack AI Health Agent</div>
            <div id="aiResponse" class="ai-response-area">
                Loading AI feedback based on your dashboard...
            </div>
            <div class="ai-input-group">
                <div class="ai-input-container">
                <input type="text" id="aiQuestion" placeholder="Ask anything or leave empty for data advice...">
                <button onclick="askAIAgent()" class="btn">Ask / Get Health Advice</button>
</div>
            </div>
        </div>
    </div>

    <div class="main-container">
        <h2>Your Weekly Health Progress</h2>

        <div class="dashboard-grid">

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Running Distance (km)</span>
                    <span class="chart-icon">🏃‍♂️</span>
                </div>
                <div class="input-group">
                    <label>Today:</label>
                    <input type="number" id="runInput" placeholder="5.2" step="0.1">
                    <button onclick="updateChart(runningChart, 'runInput', 4)">Update</button>
                </div>
                <div class="canvas-container"><canvas id="runningChart"></canvas></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Sleep Duration (Hours)</span>
                    <span class="chart-icon">😴</span>
                </div>
                <div class="input-group">
                    <label>Today:</label>
                    <input type="number" id="sleepInput" placeholder="7.5" step="0.5">
                    <button onclick="updateChart(sleepChart, 'sleepInput', 4)">Update</button>
                </div>
                <div class="canvas-container"><canvas id="sleepChart"></canvas></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Water Intake (Liters)</span>
                    <span class="chart-icon">💧</span>
                </div>
                <div class="input-group">
                    <label>Today:</label>
                    <input type="number" id="waterInput" placeholder="2.0" step="0.1">
                    <button onclick="updateWaterChart()">Update</button>
                </div>
                <div class="canvas-container" style="height: 180px;"><canvas id="waterChart"></canvas></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Protein Intake (Grams)</span>
                    <span class="chart-icon">🍗</span>
                </div>
                <div class="input-group">
                    <label>Achieved:</label> 
                    <input type="number" id="proteinInput" placeholder="85" value="70">
                    <button onclick="updateProteinData()">Update</button>
                </div>
                <div class="canvas-container"><canvas id="proteinChart"></canvas></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Calorie Counter (kcal)</span>
                    <span class="chart-icon">🔥</span>
                </div>
                <div class="input-group">
                    <label>Goal:</label>
                    <input type="number" id="calorieGoalInput" value="2000" style="width: 55px;">
                    <label>Today:</label>
                    <input type="number" id="calorieInput" placeholder="1750" step="50" value="1750" style="width: 55px;">
                    <button onclick="updateCalorieWithGoal()">Update</button>
                </div>
                
                <div class="progress-container">
                    <div id="calorieProgressBar" class="progress-bar"></div>
                </div>
                <div class="goal-text">
                    <span>Intake: <span id="currentCalorieText">1750</span> kcal</span>
                    <span>Goal: <span id="goalCalorieText">2000</span> kcal</span>
                </div>

                <div class="canvas-container"><canvas id="calorieChart"></canvas></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Steps Walked</span>
                    <span class="chart-icon">👣</span>
                </div>
                <div class="input-group">
                    <label>Today:</label>
                    <input type="number" id="stepsInput" placeholder="6000" step="100">
                    <button onclick="updateChart(stepsChart, 'stepsInput', 4)">Update</button>
                </div>
                <div class="canvas-container"><canvas id="stepsChart"></canvas></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Weekly Habit Check</span>
                    <span class="chart-icon">✅</span>
                </div>
                <div class="days-check-group">
                    <label><input type="checkbox" class="day-check"> M</label>
                    <label><input type="checkbox" class="day-check"> T</label>
                    <label><input type="checkbox" class="day-check"> W</label>
                    <label><input type="checkbox" class="day-check"> T</label>
                    <label><input type="checkbox" class="day-check"> F</label>
                    <label><input type="checkbox" class="day-check"> S</label>
                    <label><input type="checkbox" class="day-check"> S</label>
                </div>
                <div class="canvas-container" style="height: 180px;"><canvas id="habitChart"></canvas></div>
            </div>

        </div>

        <button class="order-btn" onclick="window.location.href='food.php'">Order Healthy Food ➔</button>
    </div>

 <script>
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

       
        async function fetchAIResponse(customQuestion = "") {
            const responseArea = document.getElementById('aiResponse');
            if (!responseArea) return;
            
            
            responseArea.innerHTML = `
                <div class="ai-loading-container">
                    <div class="ai-spinner"></div>
                    <span>Thinking... Analyzing your data 🧠🔍</span>
                </div>
            `;

            
            const protein = document.getElementById('proteinInput')?.value || "70";
            const calories = document.getElementById('calorieInput')?.value || "1750";
            const calorieGoal = document.getElementById('calorieGoalInput')?.value || "2000";
            const water = document.getElementById('waterInput')?.value || "1.8";
            const steps = document.getElementById('stepsInput')?.value || "5000";

            let systemPrompt = `You are a helpful nutrition and health expert AI assistant for 'NutriTrack'. 
             The user's current health metrics for today are:
             - Protein Intake: ${protein} grams
             - Calorie Intake: ${calories} kcal (Goal is ${calorieGoal} kcal)
             - Water Intake: ${water} Liters
             - Steps Walked: ${steps} steps.

             Provide responses in friendly, clean, and professional English. Keep answers brief, actionable, and encouraging.`;

let finalPrompt = customQuestion 
    ? `${systemPrompt}\n\nUser Question: ${customQuestion}`
    : `${systemPrompt}\n\nBased on these current metrics, give a 1-2 sentence quick advice or health feedback for the user in English.`;

            try {
                const response = await fetch('get_ai_advice.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt: finalPrompt })
                });
                
                const data = await response.json();
                
                if (data.candidates && data.candidates[0].content.parts[0].text) {
                    const text = data.candidates[0].content.parts[0].text;
                    responseArea.innerHTML = text.replace(/\n/g, "<br>");
                } else if (data.error) {
                    responseArea.innerHTML = "⚠️ API Error: " + (data.error.message || "වැරැද්දක් සිදුවිය.");
                } else {
                    responseArea.innerHTML = "AI එකෙන් පිළිතුරක් ලැබුනේ නැත.";
                }
            } catch (error) {
                responseArea.innerHTML = "⚠️ සම්බන්ධතා දෝෂයක්: කරුණාකර get_ai_advice.php පරීක්ෂා කරන්න.";
                console.error(error);
            }
        }

       
        function askAIAgent() {
            const questionInput = document.getElementById('aiQuestion');
            const question = questionInput ? questionInput.value.trim() : "";
            
            
            fetchAIResponse(question);
            if(questionInput) questionInput.value = ""; 
        }

        
        function getGradient(ctx, color1 = 'rgba(219, 39, 119, 0.5)', color2 = 'rgba(106, 27, 154, 0.05)') {
            const gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, color1);
            gradient.addColorStop(1, color2);
            return gradient;
        }

        
        const runCtx = document.getElementById('runningChart').getContext('2d');
        const runningChart = new Chart(runCtx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    data: [3.2, 4.0, 2.5, 4.8, 3.0, 0, 0],
                    borderColor: '#db2777',
                    backgroundColor: getGradient(runCtx),
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

       
        const sleepCtx = document.getElementById('sleepChart').getContext('2d');
        const sleepChart = new Chart(sleepCtx, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    data: [7, 6.5, 8, 7.5, 6, 0, 0],
                    backgroundColor: getGradient(sleepCtx, 'rgba(106, 27, 154, 0.6)', 'rgba(106, 27, 154, 0.1)'),
                    borderRadius: 6
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

       
        const waterChart = new Chart(document.getElementById('waterChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Drank (L)', 'Remaining (L)'],
                datasets: [{
                    data: [1.8, 1.2],
                    backgroundColor: ['#9c27b0', 'rgba(255,255,255,0.4)'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        
        function updateWaterChart() {
            let val = parseFloat(document.getElementById('waterInput').value) || 0;
            if(val > 3) val = 3;
            waterChart.data.datasets[0].data[0] = val;
            waterChart.data.datasets[0].data[1] = Math.max(0, 3 - val);
            waterChart.update();
           
        }

        
        const proteinCtx = document.getElementById('proteinChart').getContext('2d');
        const proteinChart = new Chart(proteinCtx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    data: [65, 80, 75, 85, 70, 0, 0],
                    borderColor: '#9c27b0',
                    backgroundColor: getGradient(proteinCtx, 'rgba(156, 39, 176, 0.4)'),
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        function updateProteinData() {
            updateChart(proteinChart, 'proteinInput', 4);
        }

        
        const calCtx = document.getElementById('calorieChart').getContext('2d');
        const calorieChart = new Chart(calCtx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    data: [1850, 2000, 1900, 2100, 1750, 0, 0],
                    borderColor: '#db2777',
                    backgroundColor: getGradient(calCtx),
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        function updateCalorieWithGoal() {
            const goalInput = document.getElementById('calorieGoalInput');
            const calorieInput = document.getElementById('calorieInput');
            if (!goalInput || !calorieInput) return;

            const goal = parseFloat(goalInput.value) || 2000;
            const todayIntake = parseFloat(calorieInput.value) || 0;
            
            calorieChart.data.datasets[0].data[4] = todayIntake;
            calorieChart.update();
            
            if(document.getElementById('currentCalorieText')) document.getElementById('currentCalorieText').innerText = todayIntake;
            if(document.getElementById('goalCalorieText')) document.getElementById('goalCalorieText').innerText = goal;
            
            let percentage = (todayIntake / goal) * 100;
            if (percentage > 100) percentage = 100; 
            
            if(document.getElementById('calorieProgressBar')) document.getElementById('calorieProgressBar').style.width = percentage + '%';
            
        }

        
        const stepsCtx = document.getElementById('stepsChart').getContext('2d');
        const stepsChart = new Chart(stepsCtx, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    data: [5200, 7000, 4800, 6100, 5000, 0, 0],
                    backgroundColor: getGradient(stepsCtx, 'rgba(219, 39, 119, 0.6)'),
                    borderRadius: 6
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        
        const habitChart = new Chart(document.getElementById('habitChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Done', 'Missed'],
                datasets: [{
                    data: [2, 5],
                    backgroundColor: ['#db2777', 'rgba(255,255,255,0.4)'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        const checkboxes = document.querySelectorAll('.day-check');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                let completed = 0;
                checkboxes.forEach(c => { if(c.checked) completed++; });
                habitChart.data.datasets[0].data[0] = completed;
                habitChart.data.datasets[0].data[1] = 7 - completed;
                habitChart.update();
                
            });
        });

        function updateChart(chartInstance, inputId, index) {
            const inputEl = document.getElementById(inputId);
            if(!inputEl) return;
            const val = parseFloat(inputEl.value) || 0;
            chartInstance.data.datasets[0].data[index] = val;
            chartInstance.update();
            
        }

        
        document.addEventListener("DOMContentLoaded", function() {
            try { updateCalorieWithGoal(); } catch(e) { console.log(e); }
           
        });
</script>
</body>
</html>