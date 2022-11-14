<!DOCTYPE html>
<html lang="es">
<head>
    @include('includes.head')
</head>
<body>
<header>
	@include('includes.header',['title' => 'Maintenance Sheet'])
</header>
<div>
    <table class="table-info">
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
    <table class="table-data">
        <thead>
        <tr>
            {{--            <th scope="col">#</th>--}}
            <th scope="col">serie_number</th>
            <th scope="col">name</th>
            <th scope="col">brand</th>
            <th scope="col">model</th>
            @if($data["type"] == "resumen")
                <th scope="col">maintenance_count</th>
                <th scope="col">amount</th>
            @else
                <th scope="col">code</th>
                <th scope="col">date</th>
                <th scope="col">type</th>
                <th scope="col">supplier</th>
                <th scope="col">responsible</th>
                <th scope="col" class="text-right">amount</th>
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
                    <td class="text-right">{{number_format((float)$item["amount"], 2, '.', '')}}</td>
                </tr>
            @endforeach
        @else
            @foreach($data["data"] as $item)
                @foreach($item["maintenance_sheets"] as $key => $item2)
                    <tr>
                        @if($key == 0)
                            <td rowspan="{{count($item["maintenance_sheets"])}}" class="align-middle">{{$item["serie_number"]}}</td>
                            <td rowspan="{{count($item["maintenance_sheets"])}}" class="align-middle">{{$item["name"]}}</td>
                            <td rowspan="{{count($item["maintenance_sheets"])}}" class="align-middle">{{$item["brand"]}}
                            <td rowspan="{{count($item["maintenance_sheets"])}}" class="align-middle">{{$item["model"]}}</td>
                        @endif
                        <td>{{$item2["code"]}}</td>
                        <td>{{$item2["date"]}}</td>
                        <td>{{$item2["maintenance_type"]["name"]}}</td>
                        <td>{{$item2["supplier"]["name"]}}</td>
                        <td>{{$item2["responsible"]}}</td>
                        <td class="text-right">{{number_format((float)$item2["amount"], 2, '.', '')}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="9"><strong>Number Maintenance: {{count($item["maintenance_sheets"])}}</strong></td>
                    <td class="text-right"><strong>{{number_format((float)$item["amount"], 2, '.', '')}}</strong></td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="{{$data["type"] == "resumen"?5:9}}"><strong>Total</strong></td>
            <td class="text-right"><strong>{{number_format((float)$data["total_amount"], 2, '.', '')}}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
