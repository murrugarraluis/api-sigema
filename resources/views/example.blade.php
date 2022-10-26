<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<header>
    <table class="table table-borderless">
        <thead>
        <tr>
            <th scope="col">
                <img src="{{ public_path('images/JEX24.png') }}" style="width: 150px; height: 70px">
            </th>
            <th scope="col" class="w-75 text-center">
                <h2>Maintenance Sheets</h2>
            </th>
            <th scope="col">
                <img src="{{ public_path('images/logo_reportes.jpg') }}" style="width: 150px; height: 70px">
            </th>
        </tr>
        </thead>
    </table>
</header>
<div>
    <table class="table table-sm">
        <thead>
        <tr>
            <td scope="col">start date: {{$data["start_date"]}}</td>
            <td scope="col">end date: {{$data["end_date"]}}</td>
            <td scope="col">type: {{$data["type"]}}</td>
            <td scope="col">date: {{date('Y-m-d H:i:s')}}</td>
        </tr>
        </thead>
    </table>
</div>
<hr>
<div class="">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            {{--            <th scope="col">#</th>--}}
            @if($data["type"] == "resumen")
                <th scope="col">serie_number</th>
                <th scope="col">name</th>
                <th scope="col">brand</th>
                <th scope="col">model</th>
                <th scope="col">maintenance_count</th>
                <th scope="col">amount</th>
            @else
                <th scope="col">serie_number</th>
                <th scope="col">name</th>
                <th scope="col">brand</th>
                <th scope="col">model</th>
                <th scope="col">code</th>
                <th scope="col">date</th>
                <th scope="col">type</th>
                <th scope="col">supplier</th>
                <th scope="col">responsible</th>
                <th scope="col">amount</th>
            @endif


        </tr>
        </thead>
        <tbody>
        @if($data["type"] == "resumen")
            @foreach($data["data"] as $item)
                <tr>
                    {{--                <th scope="row">{{$key}}</th>--}}
                    <td>{{$item["serie_number"]}}</td>
                    <td>{{$item["name"]}}</td>
                    <td>{{$item["brand"]}}
                    <td>{{$item["model"]}}</td>
                    <td>{{$item["maintenance_count"]}}</td>
                    <td>{{$item["amount"]}}</td>
                </tr>
            @endforeach
        @else
            @foreach($data["data"] as $item)
                @foreach($item["maintenance_sheets"] as $key => $item2)
                    <tr>
                        @if($key == 0)
                            <td rowspan="{{count($item["maintenance_sheets"])}}">{{$item["serie_number"]}}</td>
                            <td rowspan="{{count($item["maintenance_sheets"])}}">{{$item["name"]}}</td>
                            <td rowspan="{{count($item["maintenance_sheets"])}}">{{$item["brand"]}}
                            <td rowspan="{{count($item["maintenance_sheets"])}}">{{$item["model"]}}</td>
                        @endif
                        <td>{{$item2["code"]}}</td>
                        <td>{{$item2["date"]}}</td>
                        <td>{{$item2["maintenance_type"]["name"]}}</td>
                        <td>{{$item2["supplier"]["name"]}}</td>
                        <td>{{$item2["responsible"]}}</td>
                        <td>{{$item2["amount"]}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="9"><strong>Number Maintenance: {{count($item["maintenance_sheets"])}}</strong></td>
                    <td><strong>{{$item["amount"]}}</strong></td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="{{$data["type"] == "resumen"?5:9}}"><strong>Total</strong></td>
            <td><strong>{{$data["total_amount"]}}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
