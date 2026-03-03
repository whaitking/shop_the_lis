import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Esperamos a que el DOM esté cargado Foto Create Producto
document.addEventListener("DOMContentLoaded", function () {
    const inputImages = document.querySelector("#images");
    const previewContainer = document.querySelector("#image-preview");

    // Solo ejecutamos si los elementos existen en la página actual
    if (inputImages && previewContainer) {
        inputImages.addEventListener("change", function () {
            // Limpiar previsualización anterior
            previewContainer.innerHTML = "";

            const files = Array.from(this.files).slice(0, 10);

            files.forEach((file) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const div = document.createElement("div");
                    div.className =
                        "relative h-24 w-full border rounded-lg overflow-hidden bg-gray-100 shadow-sm";

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "h-full w-full object-cover";

                    div.appendChild(img);
                    previewContainer.appendChild(div);
                };

                reader.readAsDataURL(file);
            });
        });
    }
});

// Función para el scroll automático del chat
document.addEventListener("DOMContentLoaded", () => {
    const chatContainer = document.querySelector(".overflow-y-auto");

    // Solo ejecutamos si estamos en la vista de chat (si existe el contenedor)
    if (chatContainer && window.location.pathname.includes("/messages/")) {
        chatContainer.scrollTop = chatContainer.scrollHeight;

        // Opcional: Si quieres que haga scroll cada vez que el contenido cambie
        // (por ejemplo, si añades mensajes dinámicamente)
        const observer = new MutationObserver(() => {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });

        observer.observe(chatContainer, { childList: true });
    }
});
