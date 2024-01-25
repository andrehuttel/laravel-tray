<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Report</title>
</head>
<body>
    <h2>Daily Sales Report for {{ $seller->name }}</h2>
    <p>Total Sales: {{ $totalSales }}</p>
    <p>Total Value: {{ $totalValue }}</p>
    <p>Total Commission: {{ $totalCommission }}</p>
    <p>Thank you for your hard work!</p>
</body>
</html>