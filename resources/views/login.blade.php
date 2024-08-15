<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
	<div class="container mt-5">
		<div class="col text-center mb-3">	
			<img src="{{asset('assets/images/magistv.png')}}" width="100" alt="">
		</div>
		@if(session('status'))
		<div class="row justify-content-center">	
			<div class="col-md-4 alert alert-danger" role="alert">
				{{session('status')}}
			</div>
		</div>
		@endif
		{{-- <div class="row justify-content-center">
			<h2 class="col-md-4 mb-3">Iniciar sesion</h2>
		</div> --}}
		<form action="{{route('login.post')}}" method="post">
			@csrf
			<div class="row justify-content-center">
				<div class="mb-3 col-md-4">
					<label for="username" class="form-label">Nombre de usuario <span style="color:red">*</span></label>
					<input id="username" name="username" type="text" class="form-control">
				</div>
				<div class="row justify-content-center">
					<div class="mb-3 col-md-4">
						<label for="passwd" class="form-label">Contraseña <span style="color:red">*</span></label>
						<input id="passwd" name="password" type="password" class="form-control">
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-4">
						<button type="submit" class="btn btn-primary">Ingresar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>