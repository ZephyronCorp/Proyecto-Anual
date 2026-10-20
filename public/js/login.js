const form = document.getElementById("formLogin");
const mensaje = document.getElementById("Mensaje");

form.addEventListener("submit", (event) => {
    event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada
    const email = document.getElementById('email').value.trim();  
    const contrasena = document.getElementById('contrasena').value.trim();

    // Validación de campos vacíos y longitud de la contraseña
    if (email === "" || contrasena === "") {
        mensaje.textContent = "Por favor, completa todos los campos.";
        mensaje.style.color = "red";
        return;
    }
    // Validar que la contraseña tenga al menos 8 caracteres
    if (contrasena.length < 8) {
        mensaje.textContent = "La contraseña debe tener al menos 8 caracteres.";
        mensaje.style.color = "red";
        return;
    }

    mensaje.textContent = "Inicio de sesión exitoso.";
    mensaje.style.color = "green";

});