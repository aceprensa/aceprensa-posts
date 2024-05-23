<?php

if (!defined('ABSPATH')) {
    die('No puedes acceder a este fichero directamente');
}

// Función para conectarse a la API y obtener datos en función del endpoint
function conectar_api($endpoint) {
    $site_url = get_option('aceprensa_site_url');
    $api_url = $site_url . '/wp-json/wp/v2/' . $endpoint; // Reemplaza con la URL de la API del sitio remoto.
    $username = get_option('aceprensa_username');
    $password = get_option('aceprensa_password');
    $headers = array(
        'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
    );
 
    $response = wp_remote_get($api_url, array(
        'headers' => $headers,
    ));
 
    if (is_wp_error($response)) {
        // Maneja errores aquí.
        return false;
    } else {
        $results = wp_remote_retrieve_body($response);
        return $results;
    }
}

// Obtiene los posts del servidor remoto
function obtener_posts() {
    $status = '&status=publish';
    $limit = (get_option('aceprensa_num_posts')) ? '&per_page=' . esc_attr(get_option('aceprensa_num_posts')) : "" ;
    $cats = (get_option('aceprensa_selected_categories')) ? '&categories=' . json_encode(array_keys(get_option('aceprensa_selected_categories'))) : "";
    $categories = ($cats) ? str_replace("[", "", str_replace("]", "", $cats)) : "";
    $relation = ($categories) ? '&tax_relation=OR' : "" ;
    $endpoint= "posts/?_embed". $status . $limit . $categories . $relation;
    $post_image_size = (get_option('aceprensa_image_size')) ? esc_attr(get_option('aceprensa_image_size')) : "medium";
    $aceprensa_un_click = (get_option('aceprensa_un_click')) ? "?user=" . esc_attr(get_option('aceprensa_username')) : "" ;

    $results = json_decode(conectar_api($endpoint));

    foreach($results as $result) {
        if($result->firmante) {
            $firmanteId = $result->firmante[0];
            $ep = 'firmante';
        } else {
            $firmanteId = $result->firma_invitada[0];
            $ep = 'firma_invitada';
        }
        $firmante = json_decode(conectar_api($ep . '/' . $firmanteId));
        $posts[] = array(
            'date' => $result->date,
            'title' => $result->title->rendered,
            'link' => $result->link . $aceprensa_un_click,
            'excerpt' => $result->excerpt->rendered,
            'autor' => $firmante->name,
            'autor_link' => $firmante->link . $aceprensa_un_click,
            'image' => $result->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->$post_image_size->source_url
            );
    }
    return $posts;
}