<x-layout>
	<h2 class="mb-3">Formulario para crear nueva cuenta</h2>
	@php
	$route = (!isset($account)) ? 'accounts.store' : 'accounts.store.add_device';
	@endphp

	<form action="{{route($route)}}" method="post">
		<div class="row mb-3">
			<h4 class="mb-3">Datos de la cuenta</h4>	
			@if(!isset($account)) 
			<div class="mb-3 col-md-6">
				<label for="username" class="form-label">Nombre de usuario <span style="color: red">*</span></label>
				<input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
				<div id="emailHelp" class="form-text">Nombre de usuario para la cuenta MagisTV.</div>
			</div>
			<div class="mb-3 col-md-6">
				<label for="password" class="form-label">Contraseña <span style="color: red">*</span></label>
				<input type="text" class="form-control" id="password" name="password">
			</div>
			@else
			<input type="hidden" name="account_id" value="{{$account->id}}">
			@endif
		</div>

		@csrf
		<div class="row">	
			<h4 class="mb-3">Datos del plan</h4>
			<div class="mb-3 col-md-4">
				<label for="plan_id" class="form-label">Seleccione un plan <span style="color: red">*</span></label>
				<select class="form-select" name="plan_id" id="plan_id">
					<option selected="">Ninguno</option>
					@foreach($plans as $plan)
					<option value="{{$plan->id}}">{{$plan->name}} ({{$plan->description}}) Bs. {{$plan->price}}</option>
					@endforeach
				</select>
			</div>
			<div class="mb-3 col-md-4">
				<label for="started_at" class="form-label">Inicio <span style="color: red">*</span></label>
				<input type="text" name="started_at" id="started_at" class="form-control">
				<div class="form-text">Fecha de inicio del servicio</div>
			</div>
			<div class="col-md-4">	
				<div class="mb-3">
					<label for="finished_at" class="form-label">Fin</label>
					<input type="text" name="finished_at" id="finished_at" class="form-control" disabled="">
					<div class="form-text">Fecha de finalización del servicio</div>
				</div>
				<div class="col-12">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="gridCheck" checked="" name="calculate">
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
				<input type="text" class="form-control" id="customer_name" name="customer_name" aria-describedby="emailHelp">
				<div id="emailHelp" class="form-text">Nombre del cliente</div>
			</div>
			<div class="mb-3 col-md-4">
				<label for="phone" class="form-label">Celular o teléfono <span style="color: red">*</span></label>
				<input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
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
		<p>Los campos con (<span style="color: red">*</span>) son obligatorios.</p>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</x-layout>

<script type="text/javascript">
	$(document).ready(function(){
		$("input[name='calculate']").on('change',function(){
			if($(this).val()=="on"){
				$("input[name='finished_at']").prop("disabled",false);
				$(this).val('');
			}else{
				$("input[name='finished_at']").prop("disabled",true);
				$(this).val('on');
			}
		});
	});
</script>