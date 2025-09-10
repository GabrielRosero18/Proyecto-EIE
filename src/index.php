<form method="POST" action="src/bakend/signup.php" class="auth-form">
  <input type="text" name="nombre" placeholder="Nombre" required>
  <input type="number" name="edad" placeholder="Edad" required min="1">
  
  <select name="genero" required>
    <option value="">Selecciona el género</option>
    <option value="masculino">Masculino</option>
    <option value="femenino">Femenino</option>
    <option value="otro">Otro</option>
  </select>
  
  <input type="email" name="email" placeholder="Correo electrónico" required>
  <input type="text" name="idioma_preferido" placeholder="Idioma preferido" required>
  
<input type="text" name="frecuencia_uso_facebook" placeholder="Frecuencia de uso Facebook" required>
  <input type="text" name="usuario_facebook" placeholder="Usuario de Facebook (opcional)">
  <input type="password" name="contraseña" placeholder="Contraseña" required>
  <input type="password" name="confirmar_contraseña" placeholder="Confirmar contraseña" required>
  
  <button type="submit">Crear cuenta</button>
</form>