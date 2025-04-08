document.addEventListener('livewire:init', () => {
    Livewire.on('load-component', (data) => {
        // Cargar componente dinámicamente
        Livewire.dispatch('update-component', {
            name: data.component,
            params: data.params || {},
            target: data.target
        });
    });

    // Manejar navegación adelante/atrás
    window.addEventListener('popstate', () => {
        Livewire.dispatch('urlChanged', { url: window.location.href });
    });
});