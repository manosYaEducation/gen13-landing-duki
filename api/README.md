# Documentación de la API

## Endpoints

### Procesar Pago
`POST /api/procesar_pago.php`

Procesa un pago a través de la pasarela Surpay.

#### Headers
```
Content-Type: application/json
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: POST
Access-Control-Allow-Headers: Content-Type
```

#### Request Body
```json
{
    "idcliente": "string",    // ID del cliente
    "monto": number,          // Monto a pagar
    "issue": "string",        // Identificador único de la venta
    "transaction_id": "string" // ID de transacción único
}
```

#### Response
```json
{
    "success": boolean,       // true si el pago se procesó correctamente
    "url_pago": "string"      // URL de pago de Surpay (si success es true)
}
```

#### Códigos de Error
- 400: Datos incompletos
- 500: Error al comunicarse con Surpay
- 500: Respuesta inválida de Surpay

### Ejemplo de Uso

```javascript
const paymentData = {
    idcliente: "1",
    monto: 120000,
    issue: `VENTA-${Date.now()}`,
    transaction_id: "TX-123456789"
};

const response = await fetch('/api/procesar_pago.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(paymentData)
});

const result = await response.json();
if (result.success) {
    window.location.href = result.url_pago;
}
```

## Consideraciones de Seguridad

1. Todos los endpoints requieren validación de datos de entrada
2. Se implementan headers CORS para control de acceso
3. Las transacciones deben tener IDs únicos
4. Los montos deben ser validados antes de procesar el pago

## Mejores Prácticas

1. Siempre manejar los errores en el cliente
2. Validar los datos antes de enviarlos
3. Usar HTTPS en producción
4. Implementar rate limiting para prevenir abusos
5. Mantener logs de todas las transacciones