<?php
if (!defined('ABSPATH')) {
    die('No puedes acceder a este fichero directamente');
}

define( 'WP_USE_THEMES', false );
require_once( __DIR__ . '/../../../../wp-load.php' );

// Comprobamos si hay una llamada ajax para devolver los datos de la consulta
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST['endpoint'])) {
        $res = conectar_api($_POST['endpoint']);
        print_r($res);
        die(); // Paramos la ejecución del script para que sólo se muestren los datos de la consulta
    }
}