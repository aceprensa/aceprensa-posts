<?php
if (!defined('ABSPATH')) {
    die('No puedes acceder a este fichero directamente');
}
    
$posts = obtener_posts();
echo '<div class="aceprensa_posts-container">';
foreach ($posts as $post) {
?>
    <div class="aceprensa_post-container">
        <div class="aceprensa_posts-image"><img src="<?php echo $post["image"]; ?>" /></div>
        <div class="aceprensa_posts-content">
            <div class="aceprensa_posts-title">
                <h2>
                    <a href="<?php echo $post["link"]; ?>" target="_blank">
                        <?php echo $post["title"]; ?>
                    </a>
                </h2>
            </div>
            <div class="aceprensa_posts-date"><?php echo date("d-M-Y", strtotime($post["date"])); ?></div>
            <div class="aceprensa_posts-autor">
                <a href="<?php echo $post['autor_link']; ?>" target="_blank">
                    <?php echo $post["autor"]; ?>
                </a>
            </div>
            <div class="aceprensa_posts-excerpt"><?php echo $post["excerpt"]; ?></div>
        </div>
    </div>
<?php
}
echo '</div>';