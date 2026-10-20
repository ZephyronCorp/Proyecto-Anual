const form = document.getElementById("formRegister");
const mensaje = document.getElementById("Mensaje");

form.addEventListener("submit", (event)=>{
    // Evita que el formulario se envíe de forma predeterminada
    event.preventDefault();
    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const email = document.getElementById("email").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();
    const confirmarContrasena = document.getElementById("confirmar-contrasena").value.trim();

    // Validación de campos vacíos y longitud de la contraseña
    if (nombre === "" || apellido === "" || email === "" || contrasena === "" || confirmarContrasena === "") {
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
    //Confirmar que las contraseñas coincidan
    if (contrasena !== confirmarContrasena) {
        mensaje.textContent = "Las contraseñas no coinciden.";
        mensaje.style.color = "red";
        return;
    }

    mensaje.textContent = "Registro exitoso.";
    mensaje.style.color = "green";
});