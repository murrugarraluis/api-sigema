<!DOCTYPE html>
<html lang="es">
<head>
	@include('includes.head')
</head>
<body>
<header>
	@include('includes.header',['title' => 'Attendance Sheet'])
</header>
<div>
	<table class="table-info">
		<tr>
			<td class="text-left">Sort By: {{$data["sort_by"]}}</td>
		</tr>
	</table>
	<table class="table-info">
		<tr>
			<td class="text-left">Start Date: {{$data["start_date"]}}</td>
			<td class="text-center">End Date: {{$data["end_date"]}}</td>
			<td class="text-right">Report Date: {{$data["date_report"]}}</td>
		</tr>
	</table>
</div>
<hr>
<table class="table-data">
	<thead>
	<th scope="col">#</th>
	<th scope="col">Last Name</th>
	<th scope="col">Name</th>
	@if ($data["type"] == 'attended')
		<th scope="col" class="text-center">Attendances</th>
		<th scope="col" class="text-center">Absences</th>
		<th scope="col" class="text-center">Justified Absences</th>
		<th scope="col" class="text-center">Working Hours</th>
	@else
		<th scope="col" class="text-center">Date</th>
		<th scope="col" class="text-center">Reason</th>
		<th scope="col" class="text-center">Description</th>
	@endif
	</thead>
	<tbody>
	@if($data["type"] == "attended")
		@foreach($data["employees"]->jsonSerialize() as $key=>$item)
			<tr>
				<td>{{$key+1}}</td>
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
	@else
		@php
			$number_employee = 0;
		@endphp
		@foreach($data["employees"]->jsonSerialize() as $key=>$item)
			@if ($item["get_total_absences"]->jsonSerialize())
				@php
					$number_employee += 1;
				@endphp
				@foreach($item["get_total_absences"]->jsonSerialize() as $key2 => $item2)
					<tr>
						{{--						@if($key2 == 0)--}}
						{{--							<td rowspan="{{count($item["get_total_absences"])}}" class="align-middle">{{$number_employee}}--}}
						{{--							</td>--}}
						{{--							<td rowspan="{{count($item["get_total_absences"])}}" class="align-middle">{{$item["lastname"]}}</td>--}}
						{{--							<td rowspan="{{count($item["get_total_absences"])}}" class="align-middle">{{$item["name"]}}</td>--}}
						{{--						@endif--}}
						<td class="align-middle">{{$key2 == 0 ?$number_employee : ''}}
						</td>
						<td class="align-middle">{{$key2 == 0?$item["lastname"]: ''}}</td>
						<td class="align-middle">{{$key2 == 0?$item["name"]:''}}</td>
						<td>{{$item2["date"]}}</td>
						<td>{{$item2["pivot"]["missed_reason"]}}</td>
						<td>{{$item2["pivot"]["missed_description"]}}</td>
					</tr>
				@endforeach
				<tr>
					<td colspan="2"><strong>Total Justified Absences: {{$item["justified_absences"]}}</strong></td>
					<td colspan="2"><strong>Total Unexcused Absences: {{$item["absences"]}}</strong>
					</td>
					<td colspan="2"><strong>Total Absences: {{$item["absences"] + $item["justified_absences"]}}</strong></td>
				</tr>
			@endif
		@endforeach
		<tr>
			<td colspan="6"><strong>Total Employees {{$number_employee}}</strong></td>
			{{--				<td class="text-center"><strong>{{$data["total_attendances"]}}</strong></td>--}}
			{{--				<td class="text-center"><strong>{{$data["total_absences"]}}</strong></td>--}}
			{{--				<td class="text-center"><strong>{{$data["total_justified_absences"]}}</strong></td>--}}
			{{--				<td class="text-center"></td>--}}
		</tr>
	@endif
	</tbody>
</table>
</body>
</html>
