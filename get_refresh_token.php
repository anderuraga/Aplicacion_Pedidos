<?php

require 'vendor/autoload.php';
require 'autoload.php';
session_start();

use League\OAuth2\Client\Provider\Google;

$clientId = '';
$clientSecret = '';
$redirectUri = ''; 

$provider = new Google([
    'clientId'     => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $redirectUri,
    'accessType'   => 'offline',
    'scopes'       => ['https://mail.google.com/'],
]);

if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl([
        'access_type' => 'offline',
        'prompt' => 'consent'
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Estado inválido');
} else {
    try {
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        echo "<h3>Access Token:</h3><pre>" . htmlspecialchars($token->getToken()) . "</pre>";
        echo "<h3>Refresh Token:</h3><pre>" . htmlspecialchars($token->getRefreshToken()) . "</pre>";
        echo "<h3>Expires:</h3><pre>" . htmlspecialchars($token->getExpires()) . "</pre>";

    } catch (Exception $e) {
        exit('Error obteniendo token: ' . $e->getMessage());
    }
}
