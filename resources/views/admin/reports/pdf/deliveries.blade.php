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
<h1>List of Deliveries: </h1>
<table id="design">
    <thead>
    <tr>
        <th>Delivery ID</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Status</th>
        <th>Dispatched at</th>
        <th>Estimated Day of Arrival</th>
        <th>Re-scheduled or Postponed at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deliveries as $delivery)
        <tr>
            <td>{{$delivery->id}}</td>
            <td>{{$delivery->customer_name}}</td>
            <td>{{$delivery->order->address}}</td>
            <td>{{$delivery->status}}</td>
            <td>{{$delivery->created_at->format('m/d/Y')}} at {{$delivery->created_at->format('g:i A')}}</td>
            @if(!empty($delivery->ETA))
                <td>{{$delivery->ETA}}</td>
            @else
                <td>N/A</td>
            @endif

            @if($delivery->created_at == $delivery->updated_at)
                <td>N/A</td>
            @elseif($delivery->status != 'Completed')
                <td>{{$delivery->updated_at->format('m/d/Y')}} at {{$delivery->updated_at->format('g:i A')}}</td>
            @else
                <td>Completed</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<div class="footer">
    Requested by {{Auth::user()->name}}
    <br>
    Requested on {{now()->format('Y M d h:i A')}}
</div>
</body>
</html>
