<!DOCTYPE html>
<html>
<head>
    <title>Monthly Report {{ $month }}/{{ $year }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td {
            color: #666;
        }
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Monthly Report {{ $month }}/{{ $year }}</h1>
        <table>
            <tr>
                <th>Earning</th>
                <td>{{ number_format($total_income) }} VND</td>
            </tr>
            <tr>
                <th>Total Number of Orders</th>
                <td>{{ $total_orders }}</td>
            </tr>
            <tr>
                <th>Canceled Order Number</th>
                <td>{{ $cancelled_orders }}</td>
            </tr>
            <tr>
                <th>Return Order Number</th>
                <td>{{ $returned_orders }}</td>
            </tr>
            <tr>
                <th>Number of Orders Received</th>
                <td>{{ $delivered_orders }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
