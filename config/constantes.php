<?php 
define('BASE_URL', '/elorrieta/');
// Usuarios
define('JEFE_DEP', 0);
define('ADMIN', 1);
// Estados
define('BORRADOR', 1);
define('PEN_VALI', 2);
define('PEN_PROV', 3);
define('PEN_FACT', 4);
define('PEN_ARCH', 5);
define('ARCHIVADO', 6);

// Gasto maximo Proveedor
define('GASTO_PROVEEDOR', 18000.00);

// Email
define('EMAIL_HOST', 'smtp.gmail.com');
define('EMAIL_CORREO', '');
//No se usan con Gmail Oauth2
//define('EMAIL_CONTRASENA', '');
define('EMAIL_PORT', '587');
define('EMAIL_FROM_NAME','Plataforma Elorrieta');
define('CLIENT_ID', '');
define('CLIENT_SECRET', '');
define('REFRESH_TOKEN', '');