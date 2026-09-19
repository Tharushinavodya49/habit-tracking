const dayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

const primaryColor = '#ff4d6d';


function loginUser() {
    const email = document.getElementById('email').value;
    if (email !== "") { window.location.href = 'profile.html'; }
    else { alert("කරුණාකර Email ඇතුළත් කරන්න."); }
}


function calculateAndSaveBMI() {
    const h = document.getElementById('height')?.value / 100;
    const w = document.getElementById('weight')?.value;
    if (h > 0 && w > 0) {
        const bmi = (w / (h * h)).toFixed(1);
        alert("ඔබේ BMI අගය: " + bmi);
        window.location.href = 'dashboard.html';
    } else { alert("දත්ත ඇතුළත් කරන්න."); }
}


window.addEventListener('DOMContentLoaded', () => {
    
    const runCtx = document.getElementById('runningChart')?.getContext('2d');
    if (runCtx) {
        window.runChartObj = new Chart(runCtx, {
            type: 'line',
            data: { labels: dayLabels, datasets: [{ label: 'Running (km)', data: [0,0,0,0,0,0,0], borderColor: primaryColor, backgroundColor: 'rgba(255, 77, 109, 0.1)', fill: true, tension: 0.3 }] },
            options: { scales: { y: { beginAtZero: true, title: { display: true, text: 'Distance (km)' } } } }
        });
    }

    
    const sleepCtx = document.getElementById('sleepChart')?.getContext('2d');
    if (sleepCtx) {
        window.sleepChartObj = new Chart(sleepCtx, {
            type: 'bar',
            data: { labels: dayLabels, datasets: [{ label: 'Sleep (Hours)', data: [0,0,0,0,0,0,0], backgroundColor: primaryColor, borderRadius: 5 }] },
            options: { scales: { y: { beginAtZero: true, max: 12, title: { display: true, text: 'Hours' } } } }
        });
    }

    
    const waterCtx = document.getElementById('waterChart')?.getContext('2d');
    if (waterCtx) {
        window.waterChartObj = new Chart(waterCtx, {
            type: 'doughnut',
            data: { labels: ['Drank', 'Remaining'], datasets: [{ data: [0, 3], backgroundColor: [primaryColor, '#eee'], borderWidth: 0 }] },
            options: { plugins: { legend: { position: 'bottom' } }, cutout: '70%' }
        });
    }

    
    const proteinCtx = document.getElementById('proteinChart')?.getContext('2d');
    if (proteinCtx) {
        window.proteinChartObj = new Chart(proteinCtx, {
            type: 'bar',
            data: { labels: dayLabels, datasets: [
                { label: 'Achieved (g)', data: [0,0,0,0,0,0,0], backgroundColor: primaryColor, stack: 'Stack 0' },
                { label: 'Target (g)', data: [100,100,100,100,100,100,100], backgroundColor: '#eee', stack: 'Stack 1' }
            ]},
            options: { scales: { y: { beginAtZero: true, title: { display: true, text: 'Grams (g)' } } } }
        });
    }

    
    const habitCtx = document.getElementById('habitChart')?.getContext('2d');
    if (habitCtx) {
        let habitValues = [0, 0, 0, 0, 0, 0, 0];
        window.habitChartObj = new Chart(habitCtx, {
            type: 'bar',
            data: { labels: dayLabels, datasets: [{ label: 'Habit Done', data: habitValues, backgroundColor: primaryColor }] },
            options: { scales: { y: { max: 1, beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

        
        document.querySelectorAll('.day-check').forEach(cb => {
            cb.addEventListener('change', (e) => {
                habitValues[e.target.dataset.idx] = e.target.checked ? 1 : 0;
                window.habitChartObj.update();
            });
        });
    }
});


function updateRunningChart() {
    const val = parseFloat(document.getElementById('runInput').value);
    if (val > 0) {
        
        window.runChartObj.data.datasets[0].data[0] = val; 
        window.runChartObj.update();
        document.getElementById('runInput').value = ''; 
    } else { alert("කරුණාකර නිවැරදි දුරක් ඇතුළත් කරන්න."); }
}


function updateSleepChart() {
    const val = parseFloat(document.getElementById('sleepInput').value);
    if (val > 0 && val <= 24) {
        window.sleepChartObj.data.datasets[0].data[0] = val; 
        window.sleepChartObj.update();
        document.getElementById('sleepInput').value = '';
    } else { alert("කරුණාකර නිවැරදි පැය ගණනක් ඇතුළත් කරන්න (0-24)."); }
}


function updateWaterChart() {
    const val = parseFloat(document.getElementById('waterInput').value);
    const target = 3.0; 
    if (val > 0) {
        const currentDrank = window.waterChartObj.data.datasets[0].data[0] + val;
        const remaining = Math.max(0, target - currentDrank);
        
        window.waterChartObj.data.datasets[0].data[0] = currentDrank;
        window.waterChartObj.data.datasets[0].data[1] = remaining;
        window.waterChartObj.update();
        document.getElementById('waterInput').value = '';
    } else { alert("කරුණාකර නිවැරදි ලීටර ගණනක් ඇතුළත් කරන්න."); }
}


function updateProteinChart() {
    const achieved = parseFloat(document.getElementById('proteinInput').value);
    const target = parseFloat(document.getElementById('proteinTarget').value);
    
    if (achieved >= 0 && target > 0) {
        window.proteinChartObj.data.datasets[0].data[0] = achieved; 
        window.proteinChartObj.data.datasets[1].data[0] = target; 
        window.proteinChartObj.update();
        document.getElementById('proteinInput').value = '';
    } else { alert("කරුණාකර දත්ත නිවැරදිව ඇතුළත් කරන්න."); }
}


function placeOrder() {
    if(total > 0) {
       
        localStorage.setItem('cartTotal', total);
        localStorage.setItem('cartItems', JSON.stringify(["Dietary Selected Food (Rs. " + total + ")"]));
        window.location.href = 'confirm_order.php'; 
    } else { 
        alert("Please choose a dish."); 
    }
}