const form = document.getElementById("formLogin");
const mensaje = document.getElementById("Mensaje");

form.addEventListener("submit", (event) => {

    const email = document.getElementById('email').value.trim();  
    const contrasena = document.getElementById('contrasena').value.trim();

    // Validación de campos vacíos y longitud de la contraseña
    if (email === "" || contrasena === "") {
        event.preventDefault();
        mensaje.textContent = "Por favor, completa todos los campos.";
        mensaje.style.color = "red";
        return;
    }
    // Validar que la contraseña tenga al menos 8 caracteres
    if (contrasena.length < 8) {
        event.preventDefault();
        mensaje.textContent = "La contraseña debe tener al menos 8 caracteres.";
        mensaje.style.color = "red";
        return;
    }

});