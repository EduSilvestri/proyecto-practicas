@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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
    .floating-btn:hover {
      background-color: #202617;
      color: white;
    }
    .boton {
      background-color: #efe300;
      color: #202617;
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
    /* Estilo para el logo y texto centrados */
    .center-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh; /* Ocupa toda la altura de la pantalla */
    }
    .center-content img {
      margin-bottom: 20px;
      height: 100px;
    }
    .center-content h1 {
      font-size: 3rem; /* Título grande */
      text-align: center;
      color: #202617;
    }
  </style>
</head>
<body>

  <div class="center-content">
    <img src="{{ asset('img/logo_negro.png') }}" alt="Logo">
    <h1>Bienvenido a Lujo Network</h1>
  </div>

  <button class="floating-btn" id="toggleForm">
    ¿Necesitas ayuda?
  </button>
  
  <div class="form-container" id="floatingForm">
    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="usuario_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" 
               value="{{ auth()->check() ? auth()->user()->name : '' }}" readonly required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" 
               value="{{ auth()->check() ? auth()->user()->email : '' }}" readonly required>
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
        <textarea class="form-control" id="descripcion" name="descripcion" 
                  placeholder="Describe tu problema" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <button type="button" class="btn btn-secondary boton" id="screenshotBtn">
          Hacer captura de pantalla
        </button>
        <div id="screenshotPreview" class="mt-2"></div>
        <input type="hidden" name="screenshot" id="screenshot">
      </div>
      <div class="mb-3">
        <label for="archivos" class="form-label">Subir imágenes (máximo 5)</label>
        <!-- Se acepta solo imágenes -->
        <input type="file" class="form-control" id="archivos" name="archivos[]" multiple accept="image/*">
        <small class="form-text text-muted">Puedes subir hasta 5 imágenes. Resolución máxima permitida: 1920x1080.</small>
      </div>
      <button type="submit" class="btn btn-primary boton">Enviar ticket</button>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script>
    // Mostrar/ocultar el formulario al pulsar "¿Necesitas ayuda?"
    document.getElementById('toggleForm').addEventListener('click', function() {
      var form = document.getElementById('floatingForm');
      form.classList.toggle('show');
    });

    // Captura de pantalla ignorando el formulario
    document.getElementById('screenshotBtn').addEventListener('click', function() {
      html2canvas(document.body, {
        ignoreElements: function(element) {
          return element.id === "floatingForm";
        }
      }).then(function(canvas) {
        var preview = document.getElementById('screenshotPreview');
        preview.innerHTML = "";
        canvas.style.width = "300px";
        canvas.style.height = "auto";
        preview.appendChild(canvas);
        document.getElementById('screenshot').value = canvas.toDataURL('image/png');
      }).catch(function(error) {
        console.error("Error al capturar la pantalla:", error);
      });
    });

    // Validación para imágenes: máximo 5 archivos y resolución máxima 1920x1080
    document.getElementById('archivos').addEventListener('change', function() {
      var files = this.files;
      if (files.length > 5) {
        alert("Solo puedes subir un máximo de 5 imágenes.");
        this.value = "";
        return;
      }

      const maxWidth = 1920;
      const maxHeight = 1080;
      let promises = [];
      
      // Comprobar la resolución de cada imagen usando let para evitar problemas de closure
      for (let i = 0; i < files.length; i++) {
        promises.push(new Promise((resolve, reject) => {
          let img = new Image();
          img.onload = function() {
            if (img.width > maxWidth || img.height > maxHeight) {
              reject(`La imagen "${files[i].name}" excede la resolución máxima permitida (${maxWidth}x${maxHeight}).`);
            } else {
              resolve();
            }
          };
          img.onerror = function() {
            reject(`No se pudo verificar la imagen "${files[i].name}".`);
          };
          img.src = URL.createObjectURL(files[i]);
        }));
      }

      Promise.all(promises).catch(error => {
        alert(error);
        document.getElementById('archivos').value = "";
      });
    });
  </script>
</body>
</html>
@endsection

