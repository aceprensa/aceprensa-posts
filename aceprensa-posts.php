<?php
/*
Plugin Name: Aceprensa posts
Description: Un plugin para obtener los últimos artículos publicados en Aceprensa.
Version: 1.0
Author: Manuel Rojas
Author URI: https://www.aquiles.es
Email: mrojas@aquiles.es
*/
/*
Aceprensa posts is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Aceprensa posts is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/

// Incluye las funciones auxiliares del plugin
include plugin_dir_path(__FILE__) . '/inc/functions.php';

// Define los ajustes de la página en el menú de administración.
function aceprensa_posts_options_page()
{
    // Icono de administración obtenido del fichero y pasado como imagen en base64
    $svg = file_get_contents(plugin_dir_path(__FILE__) . 'assets/img/icon.svg');
    $menu_icon = 'data:image/svg+xml;base64,' . base64_encode($svg);
    add_menu_page(
        'Ajustes de Aceprensa posts',   // Título de la página
        'Aceprensa posts',              // Título del menú
        'manage_options',               // Permisos de acceso: 'capabilities'
        'aceprensa-posts',              // Slug de la página / Nombre fichero
        'aceprensa_posts_page',         // Función a ejecutar / null
        $menu_icon,                     // Icono del menú
        20                              // Posición del menú
    );
}
// Agrega una acción para cargar la página de ajustes.
add_action('admin_menu', 'aceprensa_posts_options_page');

// Registra y guarda las opciones.
function aceprensa_posts_register_settings()
{
    register_setting('aceprensa-posts-settings-group', 'aceprensa_site_url');
    register_setting('aceprensa-posts-settings-group', 'aceprensa_username');
    register_setting('aceprensa-posts-settings-group', 'aceprensa_password');
    register_setting('aceprensa-posts-settings-group', 'aceprensa_selected_categories');
    register_setting('aceprensa-posts-settings-group', 'aceprensa_num_posts');
    register_setting('aceprensa-posts-settings-group', 'aceprensa_image_size');
    register_setting('aceprensa-posts-settings-group', 'aceprensa_un_click');
}
add_action('admin_init', 'aceprensa_posts_register_settings');

// Muestra la página de ajustes.
function aceprensa_posts_page()
{
    include plugin_dir_path(__FILE__) . 'admin-view.php';
}

// Registra el fichero css para el shortcode pero no lo mete en la cola
function aceprena_posts_shortcode_enqueue_scripts()
{
    wp_register_style('aceprensa_posts_style', plugin_dir_url(__FILE__) . '/assets/css/shortcode.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'aceprena_posts_shortcode_enqueue_scripts');

// Comprueba si hay una llamada a la función que ejecuta el shortcode
if (function_exists('obtener_posts')) {
    function aceprensa_posts_shortcode()
    {
        // Si existe la llamada encola el estilo para que sólo se ejecute en las páginas donde se use
        wp_enqueue_style('aceprensa_posts_style');
        include plugin_dir_path(__FILE__) . 'shortcode.php';
    }
    add_shortcode('aceprensa-posts', 'aceprensa_posts_shortcode');
}
