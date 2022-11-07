<!DOCTYPE html>
<html lang="es">
<head>
{{--    @include('includes.head')--}}
</head>
<body>
<header>
	@include('includes.header',['title' => 'Work Sheet'])
</header>
<div>
    <table class="w-100 mb-2">
        <tr>
            <td class="text-left">DATE: {{$data["date"]}}</td>
        </tr>
    </table>
    <table class="w-100 mb-2">
        <tr>
            <td class="text-left">MACHINE: {{$data["machine"]["name"]}}</td>
            <td class="text-left">BRAND: {{$data["machine"]["brand"]}}</td>
            <td class="text-left">MODEL: {{$data["machine"]["model"]}}</td>
        </tr>
    </table>
</div>
<hr>
<div class="">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col" class="text-right">Diff</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data["working_hours"]->jsonSerialize() as $key=>$item)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$item["date_time_start"]}}</td>
                <td>{{$item["date_time_end"]}}</td>
                <td class="text-right">{{$item["date_time_diff"]["hours"].":".$item["date_time_diff"]["minutes"].":".$item["date_time_diff"]["secons"]}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td class="text-right"><strong>{{$data["working_hours_total"]}}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
