<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Items</title>

    <style>

        body {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        #design {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #design td, #design th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #design th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #8E1300;
            color: white;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>

<center>
    <h1><span style="color: red;">NEW MJC</span> Trading and Manufacturing Report</h1>
    <h4>1101 D. Gomez St. Bo. Obrero Tondo Manila</h4>
</center>
<h1>List of Orders: </h1>
<table id="design">
    <thead>
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Number of Products Ordered</th>
        <th>Total Price Ordered</th>
        <th>Mobile Number</th>
        <th>Date Ordered</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->user->first_name . ' ' . $order->user->last_name}}</td>
            <td>{{$order->item_count}}</td>
            <td>{{$order->grand_total}}</td>
            <td>{{$order->phone_number}}</td>
            <td>{{$order->created_at->toFormattedDateString()}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<div class="footer">
    Requested by {{Auth::user()->name}}
    <br>
    Requested on {{now()->format('Y M d h:i')}}
</div>
</body>
</html>
