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
    <table class="w-100 mb-2">
        <tr>
            <td class="text-left">DATE: {{$data["date"]}}</td>
            <td class="text-center">TYPE: {{$data["maintenance_type"]["name"]}}</td>
            <td class="text-right">RESPONSIBLE: {{$data["responsible"]}}</td>
        </tr>
    </table>
    <table class="w-100 mb-2">
        <tr>
            <td class="text-left">SUPPLIER: {{$data["supplier"]["name"]}}</td>
            <td class="text-left">TECHNICAL: {{$data["technical"]}}</td>
            <td class="text-right">MACHINE: {{$data["machine"]["name"]}}</td>
        </tr>
    </table>
</div>
<hr>
<div class="">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">serie</th>
            <th scope="col">description</th>
            <th scope="col" class="text-right">price</th>
            <th scope="col" class="text-right">quantity</th>
            <th scope="col" class="text-right">import</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data["detail"]->jsonSerialize() as $key=>$item)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$item["article"]?$item["article"]["serie_number"]:"XXXXXXXXXXXXX"}}</td>
                <td>{{$item["article"]?$item["article"]["name"]:$item["description"]}}</td>
                <td class="text-right">{{number_format((float)$item["price"], 2, '.', '')}}
                <td class="text-right">{{$item["quantity"]}}</td>
                <td class="text-right">{{number_format((float)$item["price"]*$item["quantity"], 2, '.', '')}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5"><strong>Total</strong></td>
            <td class="text-right"><strong>{{number_format((float)$data["amount"], 2, '.', '')}}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
