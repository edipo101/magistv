<x-layout>	
	<div class="row mb-3">
	<h2>Listado de cuentas con dispositivos</h2>
	<a href="{{route('accounts.create')}}"><button type="button" class="btn btn-success">Crear nueva cuenta</button></a>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
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
				<td><img src="https://styles.redditmedia.com/t5_bsa9br/styles/communityIcon_l22kg2y2yp7d1.png" alt="twbs" width="30" height="30" class="rounded-circle flex-shrink-0"></td>
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
				{{-- Buttons --}}
				<td>
					<div class="d-flex gap-2">
						@if($account->number_devices < 3)
						<a href="{{route('accounts.add_device', ['account'=>$account])}}"><button type="button" class="btn btn-info btn-circle"><i class="fas fa-solid fa-tv"></i></button></a>
						@endif
						<a href="{{route('accounts.edit', ['id' => $account->id])}}"><button type="button" class="btn btn-primary btn-circle"><i class="fas fa-solid fa-pen"></i></button></a>
						<button id="btnAccount" type="button" class="btn btn-danger btn-sm btnAccount btn-circle" data-bs-toggle="modal" data-bs-target="#modalAccount" data-info="{{$account->username}}" data-id="{{$account->id}}"><i class="fa fa-times"></i></button>
					</div>
				</td>
			</tr>
			@if($account->devices->count() > 0)
			@php $devices = $account->devices @endphp
			@foreach($devices as $device)
			<tr>
				{{-- <td><img src="https://w7.pngwing.com/pngs/945/530/png-transparent-male-avatar-boy-face-man-user-flat-classy-users-icon.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
				</td> --}}
				<td colspan="2">
					{{-- <span>{{$device->name}}<br></span> --}}
					{{-- <small class="link-secondary">{{$device->phone}}</small> --}}
					<div class="d-flex gap-2">
						<img src="{{asset('assets/images/user.png')}}" alt="twbs" width="30" height="30" class="rounded-circle flex-shrink-0">
						<span>
							{{$device->name}}
							<small class="d-block text-body-secondary">{{$device->phone}}</small>
						</span>
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
				{{-- Buttons --}}
				<td>
					<div class="d-flex gap-2">
						<a href="https://wa.me/591{{$device->phone}}" target="_blank"><button type="button" class="btn btn-success btn-circle"><i class="bi bi-whatsapp"></i></button></a>
						<button id="btnDevice" type="button" class="btn btn-danger btn-sm btnDevice btn-circle" data-bs-toggle="modal" data-bs-target="#modalDevice" data-info="{{$device->name}}" data-id="{{$device->id}}"><i class="fa fa-times"></i></button>
					</div> 
				</td>
			</tr>
			@endforeach
			@endif
			@endforeach
		</tbody>
		<caption>Total cuentas registradas: {{$accounts->total()}}</caption>
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