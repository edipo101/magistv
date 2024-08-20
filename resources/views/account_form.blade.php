<x-layout>
	@php
	$route = (!isset($account)) ? 'accounts.store' : 'accounts.store.add_device';
	$title = (!isset($account)) ? 'Crear nueva cuenta' : 'Agregar nuevo dispositivo';
	@endphp
	<h2 class="mb-3">{{$title}}</h2>
	@if(isset($account)) <p>Nota: Esta cuenta actualmente contiene {{$account->number_devices}} dispostivos</p> @endif

	<form action="{{route($route)}}" method="post">
		{{-- {{$errors}} --}}
		{{-- {{old('passwd')}} --}}
		<div class="row mb-3">
			@if(!isset($account)) 
			<h4 class="mb-3">Datos de la cuenta</h4>	
			<div class="mb-3 col-md-4">
				<label for="username" class="form-label">Nombre de usuario <span style="color: red">*</span></label>
				<input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" aria-describedby="emailHelp" value="{{old('username')}}">
				@error('username') <div class="invalid-feedback">{{$message}}</div>
				@else	<div id="emailHelp" class="form-text">Nombre de usuario para la cuenta MagisTV.</div>
				@enderror
			</div>
			<div class="mb-3 col-md-4">
				<label for="passwd" class="form-label">Contraseña <span style="color: red">*</span></label>
				<input type="text" 
					class="form-control @error('passwd') is-invalid @enderror" id="passwd" name="passwd" value="{{old('passwd')}}">
				@error('passwd')
				<div class="invalid-feedback">{{$message}}</div>
				@enderror
			</div>
			@else
			<input type="hidden" name="account_id" value="{{$account->id}}">
			@endif
		</div>

		@csrf
		<div class="row">	
			<h4 class="mb-3">Datos del plan</h4>
			<div class="mb-3 col-md-2">
				<label for="quantity" class="form-label">Cant. dispositivos</label>
				<select class="form-select @error('quantity') is-invalid @enderror" name="quantity" id="quantity">
					<option selected="">1</option>
					{{-- <option>2</option> --}}
					@if((!isset($account)) || isset($account) && ($account->number_devices < 2)) <option>2</option> @endif
					@if(!isset($account)) <option>3</option> @endif
				</select>

			</div>
			<div class="mb-3 col-md-4">
				<label for="plan_id" class="form-label">Seleccione un plan <span style="color: red">*</span></label>
				<select class="form-select @error('plan_id') is-invalid @enderror" name="plan_id" id="plan_id">
					<option value="">Ninguno</option>
					@foreach($plans as $plan)
					<option 
						@if((old('plan_id') == $plan->id)) selected="" @endif 
						value="{{$plan->id}}">{{$plan->name}} ({{$plan->description}}) Bs. {{$plan->price}}</option>
					@endforeach
				</select>
				@error('plan_id') <div class="invalid-feedback">{{$message}}</div>	@enderror
			</div>
			<div class="mb-3 col-md-3">
				<label for="started_at" class="form-label">Inicio <span style="color: red">*</span></label>
				<input type="date" name="started_at" id="started_at" class="form-control @error('started_at') is-invalid @enderror" value="{{old('started_at')}}">
				@error('started_at')
				<div class="invalid-feedback">{{$message}}</div>
				@else
				<div class="form-text">Fecha de inicio. Ejm.: 15/08/2024</div>
				@enderror
			</div>
			<div class="col-md-3">	
				<div class="mb-3">
					<label for="finished_at" class="form-label">Fin</label>
					<input type="date" name="finished_at" id="finished_at" 
						class="form-control @error('finished_at') is-invalid @enderror" 
						@error('finished_at') @else disabled @enderror >
						@error('finished_at') <div class="invalid-feedback">{{$message}}</div>
						@else <div class="form-text">Fecha de finalización del servicio</div>
						@enderror
				</div>
				<div class="col-12">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="gridCheck" 
						@error('finished_at') @else checked @enderror 
						name="calculate">
						<label class="form-check-label" for="gridCheck">
							Calcular automáticamente
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row mb-3">	
			<h4 class="mb-3">Datos del cliente</h4>
			<div class="mb-3 col-md-4">
				<label for="customer_name" class="form-label">Nombre <span style="color: red">*</span></label>
				<input type="text" 
					class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{(old('customer_name'))?old('customer_name'):'Sin nombre'}}">
					@error('customer_name') <div class="invalid-feedback">{{$message}}</div>
					@else <div id="emailHelp" class="form-text">Nombre del cliente</div>
					@enderror
			</div>
			<div class="mb-3 col-md-4">
				<label for="phone" class="form-label">Celular o teléfono <span style="color: red">*</span></label>
				<input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{old('phone')}}">
				@error('phone') <div class="invalid-feedback">{{$message}}</div> @enderror
			</div>
			<div class="mb-3 col-md-4">
				<label for="an_account" class="form-label">A cuenta (Bs.)</label>
				<input type="text" name="an_account" id="an_account" class="form-control">
				<div class="form-text">Monto cancelado o adelantado por el cliente</div>
			</div>
			<div class="mb-3">
				<label for="additional_data" class="form-label">Datos adicionales</label>
				<textarea id="additional_data" class="form-control" name="additional_data" id="floatingTextarea"></textarea>
				<div class="form-text">Datos adicionales con respecto al cliente y su pago.</div>
			</div>
		</div>
		<p>Los campos con (<span style="color: red">*</span>) son obligatorios.</p>
		<button type="submit" class="btn btn-primary">Enviar</button>
		<a href="{{route('accounts.index')}}"><button type="button" class="btn btn-danger">Volver</button></a>
	</form>
</x-layout>

<script type="text/javascript">
	$(document).ready(function(){
		$("input[name='calculate']").on('change',function(){
			if($("input[name='finished_at").prop('disabled') == true)
				$("input[name='finished_at']").prop("disabled", false);
			else{
				$("input[name='finished_at']").prop("disabled", true);
				$("input[name='finished_at']").val('');
			}
		});
	});
</script>
