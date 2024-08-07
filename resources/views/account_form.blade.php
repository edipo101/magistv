<x-layout>
	<h2 class="mb-3">Formulario para crear nueva cuenta</h2>
	<h4 class="mb-3">Datos de la cuenta</h4>
	<form>
		<div class="mb-3">
			<label for="username" class="form-label">Nombre de usuario</label>
			<input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
			<div id="emailHelp" class="form-text">Nombre de usuario para la cuenta MagisTV.</div>
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Contraseña</label>
			<input type="text" class="form-control" id="password" name="password">
		</div>
		<div class="mb-3">
			<label for="plan_id" class="form-label">Seleccione un plan</label>
			<select class="form-select" name="" id="plan_id">
				<option selected="">Ninguno</option>
				@foreach($plans as $plan)
				<option value="1">{{$plan->name}} ({{$plan->description}})</option>
				@endforeach
			</select>
		</div>
		<div class="mb-3">
			<label for="startet_at" class="form-label">Inicio</label>
			<input type="text" name="startet_at" id="startet_at" class="form-control">
			<div class="form-text">Fecha de inicio del servicio</div>
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" id="gridCheck" checked="">
				<label class="form-check-label" for="gridCheck">
					Calcular automáticamente
				</label>
			</div>
		</div>
		<div class="mb-3">
			<label for="finished_at" class="form-label">Fin</label>
			<input type="text" name="finished_at" id="finished_at" class="form-control" disabled="">
			<div class="form-text">Fecha de finalización del servicio</div>
		</div>
		<h4 class="mb-3">Datos del cliente</h4>
		<div class="mb-3">
			<label for="client_name" class="form-label">Nombre</label>
			<input type="text" class="form-control" id="client_name" name="client_name" aria-describedby="emailHelp">
			<div id="emailHelp" class="form-text">Nombre del cliente</div>
		</div>
		<div class="mb-3">
			<label for="phone" class="form-label">Celular o teléfono</label>
			<input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
		</div>
		<div class="mb-3">
			<label for="" class="form-label">Observaciones</label>
			<textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</x-layout>