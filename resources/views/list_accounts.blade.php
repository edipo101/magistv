<x-layout>
	<h2>Listado de cuentas</h2>
	<p>Total registros: {{$accounts->total()}}</p>
	{{-- {{var_dump(route())}} --}}
	<a href="{{route('accounts.form')}}"><button type="button" class="btn btn-success">Crear cuenta</button></a>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Cuenta</th>
				<th>Plan</th>
				<th>Meses</th>
				<th>Inicio</th>
				<th>Fin</th>
				<th>Trans.</th>
				<th>Progreso</th>
				<th>Dispositivos</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($accounts as $account)
			<tr class="table-active">
				<td><i class="fas fa-solid fa-user"></i></td>
				<td><a href="#">{{$account->username}}</a></td>
				<td>{{$account->plan->name}}</td>
				<td>{{$account->plan->months}}</td>
				<td>{{Carbon\Carbon::parse($account->started_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
				<td>{{Carbon\Carbon::parse($account->finished_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
				<td>{{$account->days_elapsed}}/{{$account->total_days}}</td>
				<td>
					<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar" style="width: {{$account->progress}}%">{{$account->progress}}%</div>
					</div>
				</td>
				<td>{{$account->devices->count()}}</td>
				<td>
					<button type="button" class="btn btn-success btn-sm"><i class="fas fa-solid fa-tv"></i> Agregar</button>
					<button type="button" class="btn btn-primary btn-sm"><i class="fas fa-solid fa-pen"></i> Editar</button>
					<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar</button>
				</td>
			</tr>
			@if($account->devices->count() > 0)
			@php $devices = $account->devices @endphp
			@foreach($devices as $device)
			<tr>
				<td><i class="fas fa-solid fa-tv"></i></td>
				<td>{{$device->name}}</td>
				<td>{{$device->plan->name}}</td>
				<td>{{$device->plan->months}}</td>
				<td>{{Carbon\Carbon::parse($device->started_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
				<td>{{Carbon\Carbon::parse($device->finished_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
				<td>{{$device->days_elapsed}}/{{$device->total_days}}</td>
				<td>
					<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar bg-success" style="width: {{$device->progress}}%">{{$device->progress}}%</div>
					</div>
				</td>
				<td colspan="2">Vence en {{$device->days_remaining}} días	</td>
			</tr>
			@endforeach
			@endif
			@endforeach
		</tbody>
	</table>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				{{-- <div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div> --}}
				<div class="modal-body">
					<p>¿Esta seguro de eliminar el registro?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					<button type="button" class="btn btn-primary">Si, Eliminar</button>
				</div>
			</div>
		</div>
	</div>
	
	{{$accounts->links()}}

</x-layout>