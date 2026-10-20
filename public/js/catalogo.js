// Agrega un producto al carrito (o le suma 1 a la cantidad si ya estaba)
function agregarAlCarrito(producto) {
  const carrito = cargarCarrito();

  // Buscamos si el producto ya está en el carrito por su id
  const existente = carrito.find(item => item.id === producto.id);

  if (existente) {
    existente.cantidad++;
  } else {
    carrito.push({
      id: producto.id,
      nombre: producto.nombre,
      precio: producto.precio,
      cantidad: 1
    });
  }

  guardarCarrito(carrito);
  actualizarContadorCarrito();
  mostrarMensaje(`${producto.nombre} agregado al carrito`);
}

// Muestra un mensaje flotante breve de confirmación.

function mostrarMensaje(texto) {
  const mensaje = document.getElementById("mensaje-flotante");
  if (!mensaje) return;

  mensaje.textContent = texto;
  mensaje.classList.add("mensaje-flotante-visible");

  setTimeout(() => {
    mensaje.classList.remove("mensaje-flotante-visible");
  }, 5500);
}


document.addEventListener("DOMContentLoaded", () => {
  actualizarContadorCarrito();

  // Cada botón "Agregar al carrito" trae los datos del producto

  const botones = document.querySelectorAll("[id='carrito-btn']");

  botones.forEach(boton => {
    boton.addEventListener("click", () => {
      const producto = {
        id: Number(boton.dataset.id),
        nombre: boton.dataset.nombre,
        precio: Number(boton.dataset.precio)
      };

      agregarAlCarrito(producto);
    });
  });
});