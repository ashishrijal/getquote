<p>In stock</p>
<form action='<?php $home_url = home_url(); echo $home_url."/quote"; ?>' method="post">
    <?php 
        global $post;
        if($post->ID){
            $id = $post->ID;
            $product = wc_get_product($id);
        }
    ?>
    <button value="<?php echo esc_attr( $product->get_id() );?>" name="idofproduct" class="get_quote_button">
        Get a quote
    </button>
</form>