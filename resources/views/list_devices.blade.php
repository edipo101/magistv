<x-layout>
	<h2>Listado de dispositivos</h2> 
	<p>Total registros: {{$devices->total()}}</p>
	<button type="button" class="btn btn-success">Agregar</button>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Nombre/Celular</th>
				<th>Plan</th>
				<th>Meses</th>
				<th>Inicio</th>
				<th>Fin</th>
				<th>Trans.</th>
				<th>Progreso</th>
				<th>Cuenta</th>
			</tr>
		</thead>
		<tbody>
			@php
				$active = false; 
				$ac_id = $devices->first()->account->id;
			@endphp
			@foreach ($devices as $device)
			@if ($device->account->id <> $ac_id)
				@php
					$ac_id = $device->account->id;
					$active = !$active;
				@endphp
			@endif
			<tr class="{{($active)?:'table-active'}}">
				<td>{{$device->id}}</td>
				<td>
					<a href="#">{{$device->name}}</a> {{($device->id != $device->account->first_device())?'':'(*)'}}
					<span style="display: flex">{{$device->phone}}</span>
				</td>
				<td>{{$device->plan->name}}</td>
				<td>{{$device->plan->months}}</td>
				<td>{{Carbon\Carbon::parse($device->started_at)->locale('es-ES')->isoFormat('DD MMM')}}</td>
				<td>{{Carbon\Carbon::parse($device->finished_at)->locale('es-ES')->isoFormat('DD MMM')}}</td>
				<td>{{$device->days_elapsed}}/{{$device->total_days}}</td>
				<td>
					<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar" style="width: {{$device->progress}}%"></div>
					</div>
					<span style="display: flex">{{$device->progress}}%</span>
				</td>
				<td>
					<a href="#">{{$device->account->username}}</a>
				</td>
				<td>
					<button type="button" class="btn btn-primary btn-sm">Editar</button>
					<button type="button" class="btn btn-danger btn-sm">Eliminar</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{{$devices->links()}}

</x-layout>