<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail #Invoice2026{{ $order->id }}</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Fonts */
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Container */
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Headings */
        h1, h2 {
            margin-bottom: 10px;
        }

        h1 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            color: #444;
        }

        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            color: #666;
        }

        /* Paragraph */
        p {
            line-height: 1.6;
            margin-bottom: 10px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-row {
            background-color: #f2f2f2;
        }

        /* Total */
        .total {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        /* Payment Method */
        .payment-method {
            font-weight: bold;
            color: #444;
        }

        /* Media Query */
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
        <h1>Order Detail #Invoice2026{{ $order->id }}</h1>
        <h2>Order Status:</h2>
        <p>
        {{ $order->status == 4 ? 'Received' : '' }}
        </p>
        <h2>Billing Address:</h2>
        <p>{{ $order->address }}</p>
        <h2>Date:</h2>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
        <h2>Product Detail:</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->pivot->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ $product->pivot->size }}</td>
                    <td>{{ number_format($product->pivot->price) }} VND</td>
                    <td>{{ number_format($product->pivot->quantity * $product->pivot->price) }} VND</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="total">Total:</td>
                    <td class="total">{{ number_format($order->total_price) }} VND</td>
                </tr>
            </tfoot>
        </table>

        <h2>Payment Method:</h2>
        <p class="payment-method">
            @if ($order->payment == 2)
                Cash on Delivery (COD)
            @else ($order->payment == 1)
                VNPay
            @endif
        </p>
    </div>
</body>
</html>
