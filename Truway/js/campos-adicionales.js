document.addEventListener('DOMContentLoaded', () => {
    const tipoProducto = document.querySelector('select[name="tipo_producto"]');
    const camposAdicionales = document.getElementById('campos-adicionales');

    tipoProducto.addEventListener('change', () => {
        const tipo = tipoProducto.value;
        let campos = '';

        switch (tipo) {
            case '1': // Paquete
                campos = `
                    <label>ID Detalle Paquete:</label>
                    <input type="number" name="id_detalle_paquete" required><br>
                `;
                break;
            case '2': // Excursión
                campos = `
                    <label>Ubicación de Salida:</label>
                    <input type="text" name="ubicacion_salida" required><br>
                    <label>Duración:</label>
                    <input type="time" name="duracion" required><br>
                    <label>Guía:</label>
                    <input type="checkbox" name="guia"><br>
                    <label>Dificultad:</label>
                    <select name="dificultad" required>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select><br>
                `;
                break;
            case '3': // Pasaje
                campos = `
                    <label>Origen:</label>
                    <input type="text" name="origen" required><br>
                    <label>Destino:</label>
                    <input type="text" name="destino" required><br>
                    <label>Aerolínea:</label>
                    <input type="text" name="aerolinea" required><br>
                    <label>Tipo de Pasaje:</label>
                    <select name="tipo_pasaje" required>
                        <option value="ida">Ida</option>
                        <option value="ida_vuelta">Ida y Vuelta</option>
                    </select><br>
                `;
                break;
            case '4': // Alquiler de Vehículo
                campos = `
                    <label>Marca:</label>
                    <input type="text" name="marca" required><br>
                    <label>Modelo:</label>
                    <input type="text" name="modelo" required><br>
                    <label>Capacidad:</label>
                    <input type="number" name="capacidad" required><br>
                    <label>Empresa Rentadora:</label>
                    <input type="text" name="empresa_rentadora" required><br>
                    <label>Tipo:</label>
                    <input type="text" name="tipo" required><br>
                `;
                break;
            case '5': // Estadía
                campos = `
                    <label>Localidad:</label>
                    <input type="text" name="localidad" required><br>
                    <label>Nombre del Hotel:</label>
                    <input type="text" name="nombre_hotel" required><br>
                    <label>Servicios:</label>
                    <textarea name="servicios" required></textarea><br>
                    <label>Categoría:</label>
                    <select name="categoria" required>
                        <option value="1">1 Estrella</option>
                        <option value="2">2 Estrellas</option>
                        <option value="3">3 Estrellas</option>
                        <option value="4">4 Estrellas</option>
                        <option value="5">5 Estrellas</option>
                    </select><br>
                `;
                break;
            default:
                campos = ''; // Si no se selecciona un tipo válido, no mostrar nada
        }

        camposAdicionales.innerHTML = campos;
    });
});