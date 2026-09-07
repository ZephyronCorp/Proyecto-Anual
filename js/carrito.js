// Dibuja el contenido actual del carrito en #lista-carrito
function mostrarCarrito() {
  const carrito = cargarCarrito();
  const contenedor = document.getElementById("lista-carrito");
  const totalTexto = document.getElementById("total");
  const cantidadTexto = document.getElementById("cantidad-productos");

  contenedor.innerHTML = "";

  if (carrito.length === 0) {
    contenedor.innerHTML = "<p>Tu carrito está vacío. ¡Agregá productos desde el catálogo!</p>";
    totalTexto.textContent = "$0";
    cantidadTexto.textContent = "0";
    return;
  }

  let total = 0;

  carrito.forEach(item => {
    const subtotal = item.precio * item.cantidad;
    total += subtotal;

    // 1) Crear el elemento
    const div = document.createElement("div");
    div.classList.add("producto-carrito");

    // 2) Configurarlo
    div.innerHTML = `
      <div class="info-carrito">
        <h3>${item.nombre}</h3>
        <p>$${item.precio} x ${item.cantidad} = $${subtotal}</p>
        <button class="btn-restar">−</button>
        <button class="btn-sumar">+</button>
        <button class="btn-eliminar">Eliminar</button>
      </div>
    `;

    // Cada botón queda conectado al producto de ESTE item (por id)
    div.querySelector(".btn-sumar").addEventListener("click", () => cambiarCantidad(item.id, 1));
    div.querySelector(".btn-restar").addEventListener("click", () => cambiarCantidad(item.id, -1));
    div.querySelector(".btn-eliminar").addEventListener("click", () => eliminarDelCarrito(item.id));

    // 3) Agregarlo a la página
    contenedor.appendChild(div);
  });

  totalTexto.textContent = `$${total}`;
  cantidadTexto.textContent = contarItemsCarrito(carrito);
}

// Suma o resta 1 a la cantidad de un producto (delta = 1 o -1)
function cambiarCantidad(id, delta) {
  let carrito = cargarCarrito();
  const item = carrito.find(p => p.id === id);

  if (!item) return;

  item.cantidad += delta;

  // Si la cantidad llega a 0, sacamos el producto del carrito
  if (item.cantidad <= 0) {
    carrito = carrito.filter(p => p.id !== id);
  }

  guardarCarrito(carrito);
  actualizarContadorCarrito();
  mostrarCarrito();
}

// Elimina un producto del carrito, sin importar su cantidad
function eliminarDelCarrito(id) {
  const carrito = cargarCarrito().filter(p => p.id !== id);
  guardarCarrito(carrito);
  actualizarContadorCarrito();
  mostrarCarrito();
}

// Vacía el carrito completo
function vaciarCarrito() {
  guardarCarrito([]);
  mostrarCarrito();
  actualizarContadorCarrito();
}

// Simula una compra: en el proyecto real acá se haría un fetch()
// al servidor para registrar el pedido. Por ahora solo confirmamos
// y vaciamos el carrito.
function finalizarCompra() {
  const carrito = cargarCarrito();

  if (carrito.length === 0) return;

  alert("¡Gracias por tu compra! (simulado)");
  vaciarCarrito();
}

document.addEventListener("DOMContentLoaded", () => {
  actualizarContadorCarrito();
  mostrarCarrito();

  document.getElementById("finalizar-compra").addEventListener("click", finalizarCompra);
});