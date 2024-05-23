<?php

if (!defined('ABSPATH')) {
    die('No puedes acceder a este fichero directamente');
}

?>

<div class="wrap">
    <h2>Ajustes de Aceprensa posts</h2>
    <form method="post" action="options.php">
        <?php settings_fields('aceprensa-posts-settings-group'); ?>
        <?php do_settings_sections('aceprensa-posts-settings-group'); ?>
        <?php $selected_categories = get_option('aceprensa_selected_categories'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">URL del Sitio Externo</th>
                <td><input type="text" name="aceprensa_site_url" value="<?php echo esc_attr(get_option('aceprensa_site_url')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Nombre de Usuario</th>
                <td><input type="text" name="aceprensa_username" value="<?php echo esc_attr(get_option('aceprensa_username')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Contraseña de la Aplicación</th>
                <td>
                    <input type="password" id="aceprensa_password" name="aceprensa_password" value="<?php echo esc_attr(get_option('aceprensa_password')); ?>" />
                    <button type="button" id="show_password" class="button dashicons dashicons-visibility" style="min-width: 35px;"></button>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Categorías</th>
                <td>
                    <select name="aceprensa_categories" id="aceprensa_categories" multiple="multiple" style="min-width: 300px;">
                        <!-- Aquí generaremos las opciones dinámicamente con JavaScript -->
                    </select>
                    </td>
            </tr>
            <tr valign="top">
                <th scope="row">Número artículos</th>
                <td>
                    <select name="aceprensa_num_posts" id="aceprensa_num_posts">
                        <?php
                        $num_posts = (get_option('aceprensa_num_posts')) ? esc_attr(get_option('aceprensa_num_posts')) : "" ;
                        ?>
                        <option selected value="<?php echo $num_posts; ?>"><?php echo $num_posts; ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    </td>
            </tr>
            <tr valign="top">
                <th scope="row">Tamaño de la imagen</th>
                <td>
                    <select name="aceprensa_image_size" id="aceprensa_image_size">
                        <?php
                        $image_size = (get_option('aceprensa_image_size')) ? esc_attr(get_option('aceprensa_image_size')) : "" ;
                        ?>
                        <option selected value="<?php echo $image_size; ?>"><?php echo $image_size; ?></option>
                        <option value="thumbnail">Thumbnail</option>
                        <option value="medium">Medium</option>
                        <option value="medium_large">Medium-large</option>
                        <option value="large">Large</option>
                        <option value="full">Full</option>
                    </select>
                    </td>
            </tr>
            <tr valign="top">
                <th scope="row">Integrar con Aceprensa a un click</th>
                <td>
                        <?php $checked = (get_option('aceprensa_un_click')) ? "checked" : ""; ?>
                        <input type="checkbox" name="aceprensa_un_click" <?php echo $checked; ?>>
                    </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
<script type="text/javascript">
    // Cargamos y seleccionamos las categorías guardadas
    var savedCats = <?php echo json_encode($selected_categories); ?>;
</script>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) . '/assets/js/admin.js'; ?>"></script>