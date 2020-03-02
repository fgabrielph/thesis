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
<h1>List of Staff: </h1>
<table id="design">
    <thead>
    <tr>
        <th >ID</th>
        <th >Name</th>
        <th >Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($staffs as $staff)
        <tr>
            <td>{{$staff->id}}</td>
            <td>{{$staff->name}}</td>
            <td>{{$staff->email}}</td>
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
