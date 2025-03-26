@extends('layouts.app')

@section('title', 'Home - Laravel')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Laravel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .floating-btn {
      position: fixed;
      bottom: 20px;
      left: 20px;
      background-color: #efe300;
      color: #202617;
      border: none;
      border-radius: 30px;
      width: 160px;
      height: 60px;
      font-size: 17px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
      transition: background-color 0.3s;
    }
    .boton{
      background-color: #efe300;
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
      width: 350px;
      max-height: 80vh; /* Altura máxima relativa a la ventana */
      overflow-y: auto; /* Añade scroll vertical */
    }
    .show {
      display: block !important;
    }
  </style>
</head>
<body>

  <button class="floating-btn" id="toggleForm">
    ¿Necesitas ayuda?
  </button>
  
  <div class="form-container" id="floatingForm">
    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
      @csrf
      <!-- Campo oculto para enviar el ID del usuario autenticado -->
      <input type="hidden" name="usuario_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <!-- Muestra el nombre, pero no se envía (ya que se usa usuario_id) -->
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" value="{{ auth()->check() ? auth()->user()->name : '' }}" readonly required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <!-- Muestra el email, pero se utiliza el usuario_id para la relación -->
        <input type="email" class="form-control" id="email" name="email" placeholder="Tu email" value="{{ auth()->check() ? auth()->user()->email : '' }}" readonly required>
      </div>
      <div class="mb-3">
        <label for="asunto" class="form-label">Asunto</label>
        <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del ticket" required>
      </div>
      <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-control" id="tipo" name="tipo" required>
          <option value="">Seleccione una opción</option>
          <option value="Preguntas generales">Preguntas generales</option>
          <option value="Problemas de lanzamiento">Problemas de lanzamiento</option>
          <option value="Problemas de Pagina Web">Problemas de Pagina Web</option>
          <option value="Pagos">Pagos</option>
          <option value="Peticion de Actualizacion de Lanzamiento">Peticion de Actualizacion de Lanzamiento</option>
          <option value="Peticion de Takedown">Peticion de Takedown</option>
          <option value="Peticion de Copyright">Peticion de Copyright</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Describe tu problema" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <button type="button" class="btn btn-warning boton" id="screenshotBtn">Hacer captura de pantalla</button>
        <!-- Vista previa de la captura -->
        <div id="screenshotPreview" class="mt-2"></div>
      </div>
      <div class="mb-3">
        <label for="archivos" class="form-label">Subir archivos (máximo 5)</label>
        <input type="file" class="form-control" id="archivos" name="archivos[]" multiple accept="image/*,application/pdf">
        <small class="form-text text-muted">Puedes subir hasta 5 archivos.</small>
      </div>
      <button type="submit" class="btn btn-warning boton">Enviar ticket</button>
    </form>
  </div>

  <!-- Se incluye la librería html2canvas para la funcionalidad de captura de pantalla -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script>
    document.getElementById('toggleForm').addEventListener('click', function() {
      var form = document.getElementById('floatingForm');
      form.classList.toggle('show');
    });

    document.getElementById('screenshotBtn').addEventListener('click', function() {
      // Captura de toda la pantalla utilizando el elemento raíz del documento
      html2canvas(document.documentElement).then(function(canvas) {
        var preview = document.getElementById('screenshotPreview');
        preview.innerHTML = "";
        canvas.style.maxWidth = "100%";
        preview.appendChild(canvas);
      });
    });

    // Validación para limitar el máximo de archivos a 5
    document.getElementById('archivos').addEventListener('change', function() {
      if (this.files.length > 5) {
        alert("Solo puedes subir un máximo de 5 archivos.");
        this.value = "";
      }
    });
  </script>
</body>
</html>
@endsection


