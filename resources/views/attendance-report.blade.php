<!DOCTYPE html>
<html lang="es">
<head>
	@include('includes.head')
</head>
<body>
<header>
	@include('includes.header')
</header>
<div>
	<table class="w-100 mb-2">
		<tr>
			<td class="text-left">Sort By: {{$data["sort_by"]}}</td>
		</tr>
	</table>
	<table class="w-100 mb-2">
		<tr>
			<td class="text-left">Start Date: {{$data["start_date"]}}</td>
			<td class="text-center">End Date: {{$data["end_date"]}}</td>
			<td class="text-right">Report Date: {{$data["date_report"]}}</td>
		</tr>
	</table>
</div>
<hr>
<div class="">
	<table class="table table-bordered table-sm">
		<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Last Name</th>
			<th scope="col">Name</th>
			<th scope="col" class="text-center">Attendances</th>
			<th scope="col" class="text-center">Absences</th>
			<th scope="col" class="text-center">Justified Absences</th>
			<th scope="col" class="text-center">Working Hours</th>

{{--			<th scope="col" class="text-right">Diff</th>--}}
		</tr>
		</thead>
		<tbody>
		@foreach($data["employees"]->jsonSerialize() as $key=>$item)
			<tr>
				<th scope="row">{{$key+1}}</th>
				<td>{{$item["lastname"]}}</td>
				<td>{{$item["name"]}}</td>
				<td class="text-center">{{$item["attendances"]}}</td>
				<td class="text-center">{{$item["absences"]}}</td>
				<td class="text-center">{{$item["justified_absences"]}}</td>
				<td class="text-center">{{$item["working_hours"]}}</td>

			</tr>
		@endforeach
		<tr>
			<td colspan="3" class="text-center"><strong>Total Employees {{$data["total_employees"]}}</strong></td>
			<td class="text-center"><strong>{{$data["total_attendances"]}}</strong></td>
			<td class="text-center"><strong>{{$data["total_absences"]}}</strong></td>
			<td class="text-center"><strong>{{$data["total_justified_absences"]}}</strong></td>
			<td class="text-center"></td>

		</tr>
		</tbody>
	</table>
</div>
</body>
</html>
