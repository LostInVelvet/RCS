<?php

if (!defined('ABSPATH')) { exit; }

function SomethingOrOther(){
    echo "rawr!";
}

//add_action('woocommerce_before_add_to_cart_button', 'SomethingOrOther', 10, 0);
//add_filter('woocommerce_add_to_cart_validation', $true, $product_id, $quantity);
?>