<x-layout>
	<h2 class="mb-3">Bienvenido a MagisTV</h2>
	<div class="d-flex gap-2">
		<a href="{{route('accounts.index')}}"><button type="btn" class="btn btn-primary">Listar cuentas con dispositivos</button></a>
		<div id="app"></div>
	</div>
	@vite('resources/js/app.js')
</x-layout>