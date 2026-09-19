// --- Profile / BMI Logic ---
function calculateAndSaveBMI() {
    const h = document.getElementById('height').value / 100;
    const w = document.getElementById('weight').value;
    if (h > 0 && w > 0) {
        const bmi = (w / (h * h)).toFixed(1);
        alert("ඔබේ BMI අගය: " + bmi);
        window.location.href = 'dashboard.html';
    } else { alert("කරුණාකර දත්ත ඇතුළත් කරන්න."); }
}

// --- Dashboard / Habit Graph Logic ---
const canvas = document.getElementById('habitChart');
if (canvas) {
    const ctx = canvas.getContext('2d');
    let dataValues = [0, 0, 0, 0, 0, 0, 0];
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
            datasets: [{ label: 'ප්‍රගතිය', data: dataValues, backgroundColor: '#ff4d6d' }]
        },
        options: { scales: { y: { max: 1, beginAtZero: true } } }
    });

    document.querySelectorAll('.day-check').forEach(cb => {
        cb.addEventListener('change', (e) => {
            dataValues[e.target.dataset.idx] = e.target.checked ? 1 : 0;
            chart.update();
        });
    });
}

// --- Food Order Logic ---
let totalBill = 0;
function addFood(price) {
    totalBill += price;
    const totalDisplay = document.getElementById('total');
    if (totalDisplay) totalDisplay.innerText = totalBill;
}

function placeOrder() {
    const addr = document.getElementById('addr').value;
    if (totalBill === 0) { alert("කරුණාකර ආහාරයක් තෝරන්න."); }
    else if (addr === "") { alert("ලිපිනය ඇතුළත් කරන්න!"); }
    else { window.location.href = 'success.html'; }
}