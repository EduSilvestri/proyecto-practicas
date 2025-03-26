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
            height: 40px;
            margin-right: 10px;
        }
        .navbar-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            flex-grow: 1;
            text-align: center;
        }
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
            transition: background-color 0.3s;
        }
        .floating-btn:hover {
            background-color: #202617;
            color: white;
        }
        .form-container {
            position: fixed;
            bottom: 90px;
            left: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            display: none;
            width: 250px;
        }
        .show {
            display: block !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40">
            </a>
            <span class="navbar-text">Pantalla principal</span>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1>Página de Inicio</h1>
    </div>

    <button class="floating-btn" id="toggleForm">+</button>
    
    <div class="form-container" id="floatingForm">
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" placeholder="Tu nombre">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" class="form-control" id="email" placeholder="tu@email.com">
            </div>
            <button type="submit" class="btn btn-primary">Mandar ticket</button>
        </form>
    </div>

    <script>
        document.getElementById('toggleForm').addEventListener('click', function() {
            var form = document.getElementById('floatingForm');
            form.classList.toggle('show');
        });
    </script>
</body>
</html>
