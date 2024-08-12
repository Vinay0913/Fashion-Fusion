<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin_style.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
 <body>

  <?php include('sidebar1.php'); ?>

    <div class="container-fluid mt-5 w-50">
        <h2>Total sales per year </h2>
        <!-- Year selection -->
        <div class="mb-3">
            <label for="yearSelect" class="form-label">Select Year:</label>
            <select id="yearSelect" class="form-select">
                <?php
                // Fetch distinct years from the orders table
                include('connection.php');
                $sql_years = "SELECT DISTINCT YEAR(order_date) AS order_year FROM order_items ORDER BY order_year DESC";
                $result_years = $conn->query($sql_years);
                if ($result_years->num_rows > 0) {
                    while($row_year = $result_years->fetch_assoc()) {
                        echo "<option value='".$row_year["order_year"]."'>".$row_year["order_year"]."</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
        </div>
        <!-- Display button -->
        <button class="btn btn-primary" onclick="displayChart()">Display</button>

        <!-- Chart canvas -->
        <canvas id="orderChart" style="width:100%; height:400px;"></canvas> <!-- Set height to 400px -->
    </div>

    <script>
        let orderChart = null; // Global variable to hold the chart instance
        
        // Function to create and display the chart
        function displayChart() {
            // Get selected year from the select box
            const selectedYear = document.getElementById('yearSelect').value;

            // Fetch data for the selected year from the database
            fetch('fetch_data.php?year=' + selectedYear)
                .then(response => response.json())
                .then(data => {
                    // Extract categories and quantities from the fetched data
                    const categories = data.categories;
                    const quantities = data.quantities;

                    // Create data for the chart
                    const orderData = {
                        labels: categories,
                        datasets: [{
                            label: 'Total Products Ordered',
                            data: quantities,
                            backgroundColor: [
                                'rgba(139, 0, 0, 0.7)',   // Dark red
                                'rgba(0, 0, 139, 0.7)',   // Dark blue
                                'rgba(184, 134, 11, 0.7)',// Dark goldenrod
                                'rgba(139, 0, 139, 0.7)', // Dark purple
                            ],
                            borderColor: [
                                'rgba(139, 0, 0, 1)',     // Dark red
                                'rgba(0, 0, 139, 1)',     // Dark blue
                                'rgba(184, 134, 11, 1)',  // Dark goldenrod
                                'rgba(139, 0, 139, 1)',   // Dark purple
                            ],
                            borderWidth: 1,
                            barThickness: '40' // Set the width of the bars
                        }]
                    };

                    // Clear the existing chart if it exists
                    if (orderChart) {
                        orderChart.destroy();
                    }

                    // Get canvas context and create the chart
                    const ctx = document.getElementById('orderChart').getContext('2d');
                    orderChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: orderData,
                        options: {
                            // Display the year in the center of the doughnut
                            plugins: {
                                legend: false,
                                title: {
                                    display: true,
                                    text: selectedYear,
                                    position: 'bottom',
                                    font: {
                                        size: 20
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Automatically display the chart for the current year on page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentYear = (new Date()).getFullYear();
            document.getElementById('yearSelect').value = currentYear;
            displayChart();
        });
    </script>
</body>
</html>
