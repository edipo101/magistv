<x-layout>	
	<div class="row mb-3">
		<div class="d-flex justify-content-between">
			<h2>Listado de cuentas con dispositivos</h2>
		</div>
	</div>

	<div class="d-flex mb-3 gap-2 justify-content-between">
		<div>
			<a href="{{route('accounts.create')}}"><button type="button" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Crear cuenta</button></a>
			{{-- <button class="btn btn-primary btn-sm">Nuevo</button>
			<button class="btn btn-primary btn-sm">Nuevo</button> --}}
		</div>
		<div>
			<form action="#">
				<div class="input-group">
					<input class="form-control border-end-0 border" type="search" value="" id="example-search-input" placeholder="Buscar...">
					<span class="input-group-append">
						<button class="btn btn-outline-secondary border-start-0 border-bottom-0 border ms-n5" type="button">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</form>
		</div>
	</div>

	<table class="table table-bordered" id="accounts-list">
		<thead>
			<tr>
				{{-- <th>#</th> --}}
				<th class="col-account">Cuenta</th>
				<th class="col-plain">Plan</th>
				{{-- <th>Meses</th> --}}
				<th class="col-date">Inicio</th>
				<th class="col-date">Fin</th>
				{{-- <th>Trans.</th> --}}
				<th class="col-progress">Progreso</th>
				<th class="additional-data">Información Adicional</th>
				<th></th>
			</tr>
		</thead>
	</table>

	@foreach ($accounts as $account)
	<table class="table table-bordered mb-4">
		<tbody>
			<tr class="table-active">
				<td class="col-account">
					<div class="d-flex gap-2">	
						<img src="https://styles.redditmedia.com/t5_bsa9br/styles/communityIcon_l22kg2y2yp7d1.png" alt="twbs" width="30" height="30" class="rounded-circle flex-shrink-0">
						<span>{{$account->username}} </span>
						<small class="d-block mb-1">
							@if($account->days_remaining < 1)
							<span class="badge text-bg-danger">Finalizado</span>
							@elseif($account->days_remaining < 7)
							<span class="badge text-bg-warning">Por finalizar</span>
							@else
							<span class="badge text-bg-success">En curso</span>
							@endif 
						</small>
						<small class="d-block">

						</div>
					</td>
					{{-- <td><a href="#">{{$account->username}}</a></td> --}}
					<td class="col-plain">
						{{$account->plan->name}}
						<small class="d-block">{{$account->plan->months}} {{($account->plan->months > 1) ? 'meses' : 'mes'}}</small>
					</td>
					{{-- <td>{{$account->plan->months}}</td> --}}
					<td class="col-date">{{Carbon\Carbon::parse($account->started_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
					<td class="col-date">{{Carbon\Carbon::parse($account->finished_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
					{{-- <td>{{$account->days_elapsed}}/{{$account->total_days}}</td> --}}
					<td class="col-progress">
						<div class="progress border" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar
							@if($account->days_remaining < 1) bg-danger 
							@elseif($account->days_remaining < 7) bg-warning
							@else bg-success
							@endif" 
							style="width: {{$account->progress}}%"></div>
						</div>
						<div class="d-flex justify-content-between">
							<small class="text-body-secondary">{{$account->days_elapsed}}/{{$account->total_days}}</small>
							<small>{{$account->progress}}%</small>
						</div>
					</td>
					<td class="additional-data">
						<small>
							Total dispositivos: {{$account->number_devices}}
						</small>
					</td>

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
				<td>
					{{-- <span>{{$device->name}}<br></span> --}}
					{{-- <small class="link-secondary">{{$device->phone}}</small> --}}
					<div class="d-flex gap-2">
						<img src="{{asset('assets/images/user.png')}}" alt="twbs" width="30" height="30" class="rounded-circle flex-shrink-0">
						<span>
							{{$device->name}} 
							<small class="d-block text-info-emphasis">
								<i class="bi bi-phone"></i> {{$device->phone}} 								
							</small>
						</span>
					</div>
				</td>
				<td>
					{{$device->plan->name}}
					<small class="d-block text-body-secondary">{{$device->plan->months}} {{($device->plan->months > 1) ? 'meses' : 'mes'}}</small>
				</td>
				{{-- <td>{{$device->plan->months}}</td> --}}
				<td>{{Carbon\Carbon::parse($device->started_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
				<td>{{Carbon\Carbon::parse($device->finished_at)->locale('es-ES')->isoFormat('DD MMM Y')}}</td>
				{{-- <td>{{$device->days_elapsed}}/{{$device->total_days}}</td> --}}
				<td>
					<div class="progress border" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar 
						@if($device->days_remaining < 1) bg-danger 
						@elseif($device->days_remaining < 7) bg-warning
						@else bg-success
						@endif" 
						style="width: {{$device->progress}}%"></div>
					</div>
					<div class="d-flex justify-content-between">
						<small class="text-body-secondary">{{$device->days_elapsed}}/{{$device->total_days}}</small>
						<small>{{$device->progress}}%</small>
					</div>
				</td>
				<td>
					{{-- <small>Cant. dispositivos: {{$device->quantity}}</small> <br>					 --}}
					<small class="d-block mb-1">
						@if($device->days_remaining < 1)
						<span class="badge text-bg-danger">Finalizado</span>
						@elseif($device->days_remaining < 7)
						<span class="badge text-bg-warning">Por finalizar</span>
						@else
						<span class="badge text-bg-success">En curso</span>
						@endif 
						• <i class="bi bi-tv"></i> {{$device->quantity}}
						• <i class="bi bi-coin"></i> {{$device->an_account}} Bs
					</small>
					<small class="d-block">{{Str::limit($device->additional_data, 30)}} 
						@if(Str::length($device->additional_data) > 30)
						<a data-bs-toggle="collapse" href="#collapseExample{{$device->id}}" role="button" aria-expanded="false" aria-controls="collapseExample{{$device->id}}"><i class="bi bi-info-circle"></i></a>
						@endif
					</small>
					<div class="collapse" id="collapseExample{{$device->id}}">
						<div class="card card-body p-1" style="width: 250px">
							<small class="fst-italic">{{$device->additional_data}} </small>
						</div>
					</div>
				</td>
				{{-- Buttons --}}
				<td>
					<div class="d-flex gap-2">
						<a href="https://wa.me/591{{$device->phone}}" target="_blank"><button type="button" class="btn btn-success btn-circle"><i class="bi bi-whatsapp"></i></button></a>
						<a href="{{route('devices.edit', ['id' => $device->id])}}"><button type="button" class="btn btn-primary btn-circle"><i class="fas fa-solid fa-pen"></i></button></a>
						<button id="btnDevice" type="button" class="btn btn-danger btn-sm btnDevice btn-circle" data-bs-toggle="modal" data-bs-target="#modalDevice" data-info="{{$device->name}}" data-id="{{$device->id}}"><i class="fa fa-times"></i></button>
					</div> 
				</td>
			</tr>
			@endforeach
			@endif
		</tbody>
		{{-- <caption>Total cuentas registradas: {{$accounts->total()}}</caption> --}}
	</table>
	@endforeach

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