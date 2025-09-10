<form method="post" action="index.php">
  <input type="text" name="nombre" placeholder="Nombre" required>
  <input type="number" name="edad" placeholder="Edad" required>
  
  <select name="genero" required>
    <option value="">Selecciona el género</option>
    <option value="masculino">Masculino</option>
    <option value="femenino">Femenino</option>
    <option value="otro">Otro</option>
  </select>
  
  <input type="email" name="email" placeholder="Correo electrónico" required>
  <input type="text" name="idioma_preferido" placeholder="Idioma preferido (ej: español)" required>
  <input type="text" name="frecuencia_uso_facebook" placeholder="Frecuencia de uso (ej: diario)" required>
  <input type="text" name="usuario_facebook" placeholder="Usuario de Facebook (opcional)">
  
  <button type="submit">Crear cuenta</button>
</form>

