<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #202617;
        }
        .navbar-brand img {
            height: 40px; /* Ajusta el tamaño del logo */
            margin-right: 10px;
        }
        .navbar-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            flex-grow: 1;
            text-align: center;
        }
                /* Estilos del botón flotante */
                .floating-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #efe300;
            color: #202617;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }
        .floating-btn:hover {
            background-color: #202617;
            color: white
        }
    </style>
</head>
<body>
<nav class="navbar navbar-custom">
        <div class="container d-flex align-items-center">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40"> <!-- Reemplaza con tu logo -->
            </a>
            <!-- Texto centrado -->
            <span class="navbar-text">Pantalla principal</span>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1>Página de Inicio</h1>
    </div>

    <button class="floating-btn" data-bs-toggle="modal" data-bs-target="#formModal">
        +
    </button>

    <!-- Modal con el Formulario -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" placeholder="Tu nombre">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" placeholder="tu@email.com">
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
