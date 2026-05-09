<!DOCTYPE html>
<html>
<head>
    <title>Sense HAT Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; }
        .container { width: 80%; margin-top: 50px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h2>Live Wetterdaten vom Raspberry Pi</h2>
    
    <div class="container">
        <canvas id="wetterChart"></canvas>
    </div>

    <div class="container">
        <table id="datenTabelle">
            <thead>
                <tr>
                    <th>Zeitpunkt</th>
                    <th>Temperatur (°C)</th>
                    <th>Luftfeuchtigkeit (%)</th>
                    <th>Luftdruck (hPa)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

<script>
    let myChart;

    async function updateDashboard() {
        const response = await fetch('data.php');
        const data = await response.json();

        // 1. Tabelle aktualisieren
        const tbody = document.querySelector('#datenTabelle tbody');
        tbody.innerHTML = ''; 
        data.slice().reverse().forEach(row => {
            tbody.innerHTML += `<tr>
                <td>${row.zeitpunkt}</td>
                <td>${parseFloat(row.temperatur).toFixed(1)}</td>
                <td>${parseFloat(row.luftdruck).toFixed(1)}</td>
                <td>${parseFloat(row.feuchtigkeit).toFixed(1)}</td>
            </tr>`;
        });

        // 2. Daten für den Graphen aufbereiten
        // Wir nehmen die Zeit und schneiden die Sekunden ab (z.B. "14:30:15" -> "14:30")
        const labels = data.map(d => {
            const zeit = d.zeitpunkt.split(' ')[1]; // Holt die Uhrzeit
            return zeit.substring(0, 5);            // Gibt nur HH:mm zurück
        });
        
        const temps = data.map(d => d.temperatur);
        const druck = data.map(d => d.luftdruck);
        const feucht = data.map(d => d.feuchtigkeit);

        if (myChart) {
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = temps;
            myChart.data.datasets[1].data = druck;
            myChart.data.datasets[2].data = feucht;
            myChart.update();
        } else {
            const ctx = document.getElementById('wetterChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Temperatur (°C)',
                            data: temps,
                            borderColor: '#ff6384',
                            backgroundColor: '#ff6384',
                            yAxisID: 'y', // Nutzt die linke Achse
                            tension: 0.3
                        },
                        {
                            label: 'Luftfeuchtigkeit (%)',
                            data: feucht,
                            borderColor: '#36a2eb',
                            backgroundColor: '#36a2eb',
                            yAxisID: 'y', // Nutzt auch die linke Achse (0-100)
                            tension: 0.3
                        },
                        {
                            label: 'Luftdruck (hPa)',
                            data: druck,
                            borderColor: '#4bc0c0',
                            backgroundColor: '#4bc0c0',
                            yAxisID: 'y1', // Nutzt eine eigene Achse rechts!
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Temp / Feuchte' }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false }, // Gitterlinien nur von einer Achse
                            title: { display: true, text: 'Druck (hPa)' }
                        }
                    }
                }
            });
        }
    }

    setInterval(updateDashboard, 30000);
    updateDashboard();
</script>
</body>
</html>
