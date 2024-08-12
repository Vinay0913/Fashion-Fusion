<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Sales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <?php include('sidebar1.php'); ?>

        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
            <h2 mt-5>Total Orders per Year</h2>
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <?php
    // Database connection
    include('connection.php');

    // Fetching data from database
    $sql_years = "SELECT DISTINCT YEAR(order_date) AS order_year FROM order_items ORDER BY order_year DESC";
    $result = $conn->query($sql_years);

    $years = [];
    $total_orders = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $year = $row['order_year'];
            $sql_orders = "SELECT COUNT(*) AS total_orders FROM order_items WHERE YEAR(order_date) = $year";
            $orders_result = $conn->query($sql_orders);
            $orders_row = $orders_result->fetch_assoc();
            $years[] = $year;
            $total_orders[] = $orders_row['total_orders'];
        }
    }
    ?>

    <script>
       
        // JavaScript to render the chart
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($years); ?>,
                datasets: [{
                    label: 'Total Orders',
                    data: <?php echo json_encode($total_orders); ?>,
                    backgroundColor: 'rgba(255, 0, 0, 0.1)',
                    borderColor: 'red',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
