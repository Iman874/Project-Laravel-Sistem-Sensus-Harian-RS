<!-- Grafik Model RS 1 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Model RS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Grafik Indikator Rumah Sakit</h2>
    <canvas id="rsChart"></canvas>

    <script>
        fetch("{{ url('/modelrs/chart-data') }}")
            .then(response => response.json())
            .then(data => {
                let labels = data.map(item => item.tanggal);
                let BOR = data.map(item => item.BOR);
                let LOS = data.map(item => item.LOS);
                let TOI = data.map(item => item.TOI);
                let BTO = data.map(item => item.BTO);

                let ctx = document.getElementById("rsChart").getContext("2d");
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: "BOR (%)",
                                data: BOR,
                                borderColor: "red",
                                fill: false
                            },
                            {
                                label: "LOS (hari)",
                                data: LOS,
                                borderColor: "blue",
                                fill: false
                            },
                            {
                                label: "TOI (hari)",
                                data: TOI,
                                borderColor: "green",
                                fill: false
                            },
                            {
                                label: "BTO (kali)",
                                data: BTO,
                                borderColor: "orange",
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: { title: { display: true, text: "Tanggal" } },
                            y: { title: { display: true, text: "Nilai" } }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching chart data:", error));
    </script>
</body>
</html>

-->
<!-- Grafik Model RS 2
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Baber-Johnson RS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Grafik Baber-Johnson - Analisis Efisiensi RS</h2>
    <canvas id="rsChart"></canvas>

    <script>
        fetch("{{ url('/modelrs/chart-data') }}")
            .then(response => response.json())
            .then(data => {
                let ctx = document.getElementById("rsChart").getContext("2d");

                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: "BOR (%)",
                                data: data.BOR,
                                borderColor: "red",
                                fill: false
                            },
                            {
                                label: "LOS (hari)",
                                data: data.LOS,
                                borderColor: "blue",
                                fill: false
                            },
                            {
                                label: "TOI (hari)",
                                data: data.TOI,
                                borderColor: "green",
                                fill: false
                            },
                            {
                                label: "BTO (kali)",
                                data: data.BTO,
                                borderColor: "orange",
                                fill: false
                            },
                            // Garis batas BOR min 60%
                            {
                                label: "BOR Minimum (60%)",
                                data: data.BOR_min,
                                borderColor: "black",
                                borderDash: [5, 5],
                                fill: false
                            },
                            // Garis batas BOR max 85%
                            {
                                label: "BOR Maksimum (85%)",
                                data: data.BOR_max,
                                borderColor: "black",
                                borderDash: [5, 5],
                                fill: false
                            },
                            // Garis batas TOI maksimal 3 hari
                            {
                                label: "TOI Maksimum (3 hari)",
                                data: data.TOI_max,
                                borderColor: "purple",
                                borderDash: [5, 5],
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: { display: true, text: "Tanggal" }
                            },
                            y: {
                                title: { display: true, text: "Nilai" },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching chart data:", error));
    </script>
</body>
</html>

-->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Baber-Johnson RS</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <h2>Grafik Baber-Johnson - Efisiensi Rumah Sakit</h2>
    <div id="rsChart"></div>

    <script>
        fetch("{{ url('/modelrs/chart-data') }}")
            .then(response => response.json())
            .then(data => {
                let options = {
                    chart: {
                        type: 'line',
                        height: 400,
                        zoom: { enabled: true }
                    },
                    series: [
                        { name: "BOR (%)", data: data.BOR },
                        { name: "LOS (hari)", data: data.LOS },
                        { name: "TOI (hari)", data: data.TOI },
                        { name: "BTO (kali)", data: data.BTO },
                        { name: "BOR Min (60%)", data: data.BOR_min, dashArray: 5 },
                        { name: "BOR Max (85%)", data: data.BOR_max, dashArray: 5 },
                        { name: "LOS Min (6 hari)", data: data.LOS_min, dashArray: 5 },
                        { name: "LOS Max (9 hari)", data: data.LOS_max, dashArray: 5 },
                        { name: "TOI Max (3 hari)", data: data.TOI_max, dashArray: 5 },
                        { name: "BTO Min (40x)", data: data.BTO_min, dashArray: 5 },
                        { name: "BTO Max (50x)", data: data.BTO_max, dashArray: 5 }
                    ],
                    xaxis: {
                        categories: data.labels,
                        title: { text: "Tanggal" }
                    },
                    yaxis: {
                        title: { text: "Nilai" }
                    },
                    stroke: {
                        width: 2
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                
                let chart = new ApexCharts(document.querySelector("#rsChart"), options);
                chart.render();
            })
            .catch(error => console.error("Error fetching chart data:", error));
    </script>
</body>
</html>
