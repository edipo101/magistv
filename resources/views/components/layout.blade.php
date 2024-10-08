<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MagisTV</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">	
	{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous"> --}}
	
	<!-- Enlaza Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  {{-- <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet"> --}}

	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>
	<header class="p-3 mb-3 border-bottom">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
					<img src="{{asset('assets/images/magistv.png')}}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
				</a>

				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="{{route('dashboard')}}" class="nav-link px-2 link-body-emphasis">Inicio</a></li>
					<li><a href="#" class="nav-link px-2 link-secondary">Planes</a></li>
					<li><a href="{{route('accounts.index')}}" class="nav-link px-2 link-body-emphasis">Cuentas</a></li>
					<li><a href="#" class="nav-link px-2 link-secondary">Dispositivos</a></li>
				</ul>

				<div class="dropdown text-end">
					<a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
					</a>
					<ul class="dropdown-menu text-small" style="">
						<li><a class="dropdown-item" href="#">Configuración</a></li>
						<li><a class="dropdown-item" href="#">Perfil</a></li>
						<li><hr class="dropdown-divider"></li>
						<li>
							<form action="{{route('logout')}}" method="post">
								@csrf
								<a class="dropdown-item" href="#" onclick="this.closest('form').submit()">Salir</a>
							</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<div class="container mt-3">
		{{$slot}}
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --}}
	{{-- <script src="js/bootstrap-datetimepicker.min.js"></script> --}}
</body>
</html>