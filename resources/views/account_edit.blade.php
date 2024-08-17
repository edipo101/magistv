<x-layout>
	@php
	$route = ($state == 'account_edition') ? 'accounts.update' : 'accounts.store.add_device';
	$title = ($state == 'account_edition') ? 'Editar cuenta' : 'Editar dispositivo';
	@endphp
	<h2 class="mb-3">{{$title}}</h2>
	{{-- @if(isset($account)) <p>Nota: Esta cuenta actualmente contiene {{$account->number_devices}} dispositivos</p> @endif --}}

	<form action="{{route($route, ['id' => $account->id])}}" method="post">
		{{-- {{$errors->count()}} --}}
		{{-- {{old('passwd')}} --}}
		@csrf
		<input type="hidden" name="account_id" value="{{$account->id}}">
		<div class="row mb-3">
			@if($state == 'account_edition') 
			<h4 class="mb-3">Datos de la cuenta</h4>	
			<div class="mb-3 col-md-6">
				<label for="username" class="form-label">Nombre de usuario <span style="color: red">*</span></label>
				<input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" 
				aria-describedby="emailHelp" value="{{($errors->count() > 0) ? old('username') : $account->username}}">
				@error('username') <div class="invalid-feedback">{{$message}}</div>
				@else	<div id="emailHelp" class="form-text">Nombre de usuario para la cuenta MagisTV.</div>
				@enderror
			</div>
			<div class="mb-3 col-md-6">
				<label for="passwd" class="form-label">Contraseña <span style="color: red">*</span></label>
				<input type="text" 
					class="form-control @error('passwd') is-invalid @enderror" id="passwd" name="passwd" 
					value="{{($errors->count() > 0) ? old('passwd') : $account->password}}">
				@error('passwd')
				<div class="invalid-feedback">{{$message}}</div>
				@enderror
			</div>
			@endif
		</div>

		<div class="row mb-3">	
			<h4 class="mb-3">Datos del plan</h4>
			
			@if($state == 'device_edition') 
			<div class="mb-3 col-md-2">
				<label for="quantity" class="form-label">Cant. dispositivos</label>
				<select class="form-select @error('quantity') is-invalid @enderror" name="quantity" id="quantity">
					<option selected="">1</option>
					@if((!isset($account)) || isset($account) && ($account->number_devices < 2)) <option>2</option> @endif
					@if(!isset($account)) <option>3</option> @endif
				</select>

			</div>
			@endif

			<div class="mb-3 col-md-4">
				<label for="plan_id" class="form-label">Seleccione un plan <span style="color: red">*</span></label>
				<select class="form-select @error('plan_id') is-invalid @enderror" name="plan_id" id="plan_id">
					@php	$selected = false;	@endphp
					<option value="" 
						@php 
						if($errors->first('plan_id')) {
							echo 'selected';	
							$selected = true; 
						} 
						@endphp
					>Ninguno</option>
					@foreach($plans as $plan)
					<option 
						@php
						if ((old('plan_id') == $plan->id) && !($selected)) {
							echo 'selected';
							$selected = true;
						}
						if (($account->plan_id == $plan->id) && !($selected)) {
							$selected = true;
							echo 'selected';
						}
						@endphp 
						value="{{$plan->id}}">{{$plan->name}} ({{$plan->description}}) Bs. {{$plan->price}}</option>
					@endforeach
				</select>
				@error('plan_id') <div class="invalid-feedback">{{$message}}</div>	@enderror
			</div>

			<div class="mb-3 col-md-3">
				<label for="started_at" class="form-label">Inicio <span style="color: red">*</span></label>
				<input type="text" name="started_at" id="started_at" class="form-control @error('started_at') is-invalid @enderror" 
				value="{{($errors->count() > 0) ? old('started_at') : \Carbon\Carbon::parse($account->started_at)->format('d/m/Y')}}">
				@error('started_at')
				<div class="invalid-feedback">{{$message}}</div>
				@else
				<div class="form-text">Fecha de inicio. Ejm.: 15/08/2024</div>
				@enderror
			</div>

			<div class="col-md-3">	
				<div class="mb-3">
					<label for="finished_at" class="form-label">Fin</label>
					<input type="text" name="finished_at" id="finished_at" 
						class="form-control @error('finished_at') is-invalid @enderror" 
						{{-- @error('finished_at') @else disabled @enderror --}}
						value="{{($errors->count() > 0) ? old('finished_at') : \Carbon\Carbon::parse($account->finished_at)->format('d/m/Y')}}" >
						@error('finished_at') <div class="invalid-feedback">{{$message}}</div>
						@else <div class="form-text">Fecha de finalización del servicio</div>
						@enderror
				</div>
				<div class="col-12">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="gridCheck" name="calculate" >
						{{-- @error('finished_at') @else checked @enderror --}} 						
						<label class="form-check-label" for="gridCheck">
							Calcular automáticamente
						</label>
					</div>
				</div>
			</div>
		</div>

		{{-- @if($state == 'device_edition') 
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
				<label for="a_cuenta" class="form-label">A cuenta (Bs.)</label>
				<input type="text" name="a_cuenta" id="a_cuenta" class="form-control">
				<div class="form-text">Monto cancelado o adelantado por el cliente</div>
			</div>
			<div class="mb-3">
				<label for="obs" class="form-label">Datos adicionales</label>
				<textarea id="obs" class="form-control" name="obs" id="floatingTextarea"></textarea>
				<div class="form-text">Datos adicionales con respecto al cliente y su pago.</div>
			</div>
		</div>
		@endif --}}
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