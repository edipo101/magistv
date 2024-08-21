<x-layout>
	<h2 class="mb-3">Editar dispositivo</h2>

	<form action="{{route('devices.update', ['id' => $device->id])}}" method="post">
		{{$errors}}
		@csrf
		<div class="row mb-3">	
			<h4 class="mb-3">Datos del plan</h4>
			
			{{-- Quantity devices--}}
			<div class="mb-3 col-md-2">
				<label for="quantity" class="form-label">Cant. dispositivos</label>
				<select class="form-select @error('quantity') is-invalid @enderror" name="quantity" id="quantity">
					<option @if((old('quantity') == 1) || ($device->quantity == 1)) selected="" @endif>1</option> 
					@if($device->account->devices->count() <= 2) 
					<option @if((old('quantity') == 2) || ($device->quantity == 2)) selected="" @endif>2</option> 
					@endif
					@if($device->account->devices->count() == 1) 
					<option @if((old('quantity') == 3) || ($device->quantity == 3)) selected="" @endif>3</option> 
					@endif
				</select>

			</div>

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
					if(($device->plan_id == $plan->id) && !($selected)) {
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
				<input type="date" name="started_at" id="started_at" class="form-control @error('started_at') is-invalid @enderror" 
				value="{{($errors->count() > 0) ? old('started_at') : $device->started_at}}">
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
					{{-- @error('finished_at') @else disabled @enderror --}}
					value="{{($errors->count() > 0) ? old('finished_at') : $device->finished_at}}" >
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

		<div class="row mb-3">	
			<h4 class="mb-3">Datos del cliente</h4>
			<div class="mb-3 col-md-4">
				<label for="customer_name" class="form-label">Nombre <span style="color: red">*</span></label>
				<input type="text" 
				class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{($errors->count() > 0) ? old('customer_name') : $device->name}}">
				@error('customer_name') <div class="invalid-feedback">{{$message}}</div>
				@else <div id="emailHelp" class="form-text">Nombre del cliente</div>
				@enderror
			</div>
			<div class="mb-3 col-md-4">
				<label for="phone" class="form-label">Celular o teléfono <span style="color: red">*</span></label>
				<div class="input-group">
					<span class="input-group-text" id="phone"><i class="bi bi-phone"></i></span>
					<input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{($errors->count() > 0) ? old('phone') : $device->phone}}">
					@error('phone') <div class="invalid-feedback">{{$message}}</div> @enderror
				</div>
			</div>
			<div class="mb-3 col-md-4">
				<label for="an_account" class="form-label">A cuenta (Bs.) <span style="color: red">*</span></label>
				<input type="text" name="an_account" id="an_account" class="form-control @error('an_account') is-invalid @enderror" value="{{($errors->count() > 0) ? old('an_account') : $device->an_account}}">				
				@error('an_account')
				<div class="invalid-feedback">{{$message}}</div>
				@else
				<div class="form-text">Monto cancelado o adelantado por el cliente</div>
				@enderror
			</div>

			<div class="mb-3">
				<label for="additional_data" class="form-label">Datos adicionales</label>
				<textarea id="additional_data" class="form-control" name="additional_data" id="floatingTextarea">{{($errors->count() > 0) ? old('additional_data') : $device->additional_data}}</textarea>
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