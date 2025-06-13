# Aplicacion_Pedidos



## 🔐 Configurar Google Cloud para usar OAuth2 con Gmail

Sigue estos pasos para habilitar el envío de correos mediante Gmail y OAuth2:

1. Accede a [Google Cloud Console](https://console.cloud.google.com/).

2. Crea un nuevo proyecto web.

3. Activa la **API de Gmail**:
   - Ve a **API y servicios** > **Biblioteca**.
   - Busca **Gmail API** y haz clic en **Habilitar**.

4. Crea credenciales OAuth2:
   - Ve a **API y servicios** > **Credenciales**.
   - Haz clic en **Crear credenciales** > `ID de cliente de OAuth 2.0`.
   - Selecciona el tipo de aplicación: **Aplicación web**.

5. Copia tu Client ID y Client Secret.

6. En la configuración del cliente OAuth, añade un URI de redirección autorizado: 
     [callback para obtener refresh_token](http://localhost/get_refresh_token.php)

7. Obten **Access Token** mediante la llamada del callback del paso 6.
