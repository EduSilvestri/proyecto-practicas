<div>
  <!-- Botón flotante para mostrar/ocultar el formulario -->
  <button class="floating-btn" id="toggleForm" onclick="toggleForm()">
    ¿Necesitas ayuda?
  </button>

  <!-- Contenedor del formulario flotante -->
  <div class="form-container" id="floatingForm" wire:ignore>
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
      @csrf
      <!-- Campo oculto para usuario_id -->
      <input type="hidden" wire:model="usuario_id">

      <div class="field-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" wire:model="nombre" readonly required>
      </div>

      <div class="field-group">
        <label for="email">Email</label>
        <input type="email" id="email" wire:model="email" readonly required>
      </div>

      <div class="field-group">
        <label for="asunto">Asunto</label>
        <input type="text" id="asunto" wire:model="asunto" placeholder="Asunto del ticket" required>
      </div>

      <div class="field-group">
        <label for="tipo">Tipo</label>
        <select id="tipo" wire:model="tipo" required>
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

      <div class="field-group">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" wire:model="descripcion" placeholder="Describe tu problema" rows="4" required></textarea>
      </div>

      <div class="field-group">
        <label>Hacer captura de pantalla</label>
        <!-- Botón para iniciar la captura -->
        <button type="button" class="capture-btn" id="screenshotBtn">Capturar</button>
        <!-- Vista previa de la captura -->
        <div id="screenshotPreview" class="mt-2"></div>
        <!-- Campo oculto para guardar la captura en base64 -->
        <input type="hidden" wire:model="screenshot" id="screenshot">
      </div>

      <div class="field-group">
        <label for="archivos">Subir imágenes (máximo 5)</label>
        <input type="file" id="archivos" wire:model="archivos" multiple accept="image/jpeg,image/png,image/jpg,image/gif">
        <small>Puedes subir hasta 5 imágenes. Resolución máxima permitida: 1920x1080.</small>
      </div>

      <button type="submit"
        wire:loading.attr="disabled"
        wire:target="submit"
        class="submit-btn">
        <span wire:loading.remove wire:target="submit">Enviar ticket</span>
        <span wire:loading wire:target="submit">
          Enviando...
        </span>
      </button>
    </form>
  </div>

  <!-- Script para el widget flotante y funcionalidad de captura -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script>
    function toggleForm() {
      var form = document.getElementById('floatingForm');
      form.classList.toggle('show');
    }

    // Se asigna el evento al botón de captura para que solo se ejecute al hacer click
    document.getElementById('screenshotBtn').addEventListener('click', function() {
      html2canvas(document.documentElement, {
        ignoreElements: function(element) {
          // Ignora elementos que estén dentro del formulario flotante
          return element.closest('#floatingForm') !== null;
        }
      }).then(function(canvas) {
        var preview = document.getElementById('screenshotPreview');
        preview.innerHTML = "";
        canvas.style.width = "300px";
        canvas.style.height = "auto";
        preview.appendChild(canvas);
        // Actualiza el valor del campo oculto en Livewire
        @this.set('screenshot', canvas.toDataURL('image/png'));
      }).catch(function(error) {
        console.error("Error al capturar la pantalla:", error);
      });
    });

    document.getElementById('archivos').addEventListener('change', function() {
      if (this.files.length > 5) {
        alert("Solo puedes subir un máximo de 5 imágenes.");
        this.value = "";
      }
    });
  </script>

  <!-- Estilos personalizados -->
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
      max-height: 80vh;
      overflow-y: auto;
    }

    .show {
      display: block !important;
    }

    /* Estructura básica del formulario */
    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .field-group {
      display: flex;
      flex-direction: column;
      gap: 0.3rem;
    }

    .field-group label {
      font-weight: bold;
      color: #333;
    }

    .field-group input[type="text"],
    .field-group input[type="email"],
    .field-group input[type="file"],
    .field-group select,
    .field-group textarea {
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 0.9rem;
    }

    .field-group small {
      font-size: 0.75rem;
      color: #666;
    }

    .capture-btn {
      background-color: #ccc;
      color: #000;
      border: none;
      border-radius: 4px;
      padding: 0.5rem 1rem;
      cursor: pointer;
    }

    .capture-btn:hover {
      background-color: #aaa;
    }

    .submit-btn {
      background-color: #efe300;
      color: #202617;
      border: none;
      border-radius: 4px;
      padding: 0.75rem 1rem;
      font-size: 1rem;
      cursor: pointer;
      font-weight: bold;
      margin-top: 1rem;
    }

    .submit-btn:hover {
      background-color: #202617;
      color: white;
    }
  </style>
</div>