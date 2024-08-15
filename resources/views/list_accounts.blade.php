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
				<th>Información Adicional</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($accounts as $account)
			<tr class="table-active">
				<td>{{$account->id}}</td>
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
				<td>Total dispositivos: {{$account->number_devices}}</td>
				<td>
					@if($account->number_devices < 3)
					<a href="{{route('accounts.add_device', ['account'=>$account])}}"><button type="button" class="btn btn-info btn-sm"><i class="fas fa-solid fa-tv"></i> Agregar</button></a>
					@endif
					{{-- <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-solid fa-pen"></i> Editar</button> --}}
					<button id="btnAccount" type="button" class="btn btn-danger btn-sm btnAccount" data-bs-toggle="modal" data-bs-target="#modalAccount" data-info="{{$account->username}}" data-id="{{$account->id}}">Eliminar</button>
				</td>
			</tr>
			@if($account->devices->count() > 0)
			@php $devices = $account->devices @endphp
			@foreach($devices as $device)
			<tr>
				<td><i class="bi bi-person-square"></i></td>
				<td>
					<span>{{$device->name}}<br></span>
					<small class="link-secondary">{{$device->phone}}</small>
					</div>
				</td>
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
				<td>
					<small>Cant. dispositivos: {{$device->quantity}}</small> <br>
					@if($device->progress > 100)
						<small style="color: red">Tiempo finalizado</small>
					@else 
						<small>Vence en {{$device->days_remaining}} días</small>
					@endif
				</td>
				<td>
					<a href="https://wa.me/591{{$device->phone}}" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="bi bi-whatsapp"></i> Enviar</button></a>
					<button id="btnDevice" type="button" class="btn btn-danger btn-sm btnDevice" data-bs-toggle="modal" data-bs-target="#modalDevice" data-info="{{$device->name}}" data-id="{{$device->id}}">Eliminar</button>
				</td>
			</tr>
			@endforeach
			@endif
			@endforeach
		</tbody>
	</table>

	<!-- Modal -->
	<div class="modal fade" id="modalAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar cuenta</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>¿Esta seguro de eliminar la cuenta <strong id="code"></strong>?</p>
					<p>¡Se eliminaran también los dispositivos asociados a la cuenta!	</p>					
				</div>
				<div class="modal-footer">
					<form id="formDelAccount" action="#" method="post">
						@csrf
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					<input id="account_id" type="hidden" name="id" value="">
					<button type="submit" class="btn btn-primary">Si, Eliminar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalDevice" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar dispositivo</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>¿Esta seguro de eliminar el dispositivo con el nombre <strong id="nameDevice"></strong>?</p>
				</div>
				<div class="modal-footer">
					<form id="formDelDevice" action="#" method="post">
						@csrf
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					<input id="device_id" type="hidden" name="id" value="">
					<button type="submit" class="btn btn-primary">Si, Eliminar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	{{$accounts->links()}}

</x-layout>

<script type="text/javascript">
	$(document).ready(function(){
		$(".btnAccount").on("click",  function () {
        let info = $(this).data('info');
        let id = $(this).data('id');
				let base = "{{url('').'/accounts/destroy/'}}"+id;
        $('#code').html(info);
        $('#account_id').val(id);
        $('#formDelAccount').attr("action", base);
        console.log(info);
    });

    $(".btnDevice").on("click",  function () {
        let info = $(this).data('info');
        let id = $(this).data('id');
				let base = "{{url('').'/devices/destroy/'}}"+id;
        $('#nameDevice').html(info);
        $('#device_id').val(id);
        $('#formDelDevice').attr("action", base);
        console.log(info);
        console.log(id);
        console.log(base);
    });
	});
</script>