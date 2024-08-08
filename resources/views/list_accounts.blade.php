<x-layout>
	<h2>Listado de cuentas con dispositivos</h2>
	<p>Total registros: {{$accounts->total()}}</p>
	<a href="{{route('accounts.create')}}"><button type="button" class="btn btn-success">Crear nueva cuenta</button></a>
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
				<td>{{$account->number_devices}}</td>
				<td>
					@if($account->devices->count() < 3)
					<a href="{{route('accounts.add_device', ['account'=>$account])}}"><button type="button" class="btn btn-info btn-sm"><i class="fas fa-solid fa-tv"></i> Agregar</button></a>
					@endif
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
				<td>Vence en {{$device->days_remaining}} días</td>
				<td>
					<a href="https://wa.me/59177123130" target="_blank"><button type="button" class="btn btn-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
					<path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
				</svg> Enviar</button></a>
			</td>
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