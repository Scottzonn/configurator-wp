<?php

// require __DIR__ . '/vendor/autoload.php';

// use Automattic\WooCommerce\Client;


// add_filter('woocommerce_cart_item_remove_link', 'customized_cart_item_remove_link', 20, 2 );
// function customized_cart_item_remove_link( $button_link, $cart_item_key ){
//     // $targeted_products_ids = array( 98,99,100 );

//     $cart_item = WC()->cart->get_cart()[$cart_item_key];

//     // if( in_array($cart_item['data']->get_id(), $targeted_products_ids) )
//     //     $button_link = '';

//     return 'szlink'.$button_link.'szlink';
// }

add_filter( 'woocommerce_checkout_get_value' , 'custom_checkout_get_value', 20, 2 );
function custom_checkout_get_value( $value, $input ) {
    // // Billing first name
    // if(isset($_GET['FirstName']) && ! empty($_GET['FirstName']) && $input == 'billing_first_name' )
    //     $value = esc_attr( $_GET['FirstName'] );

    // // Billing last name
    // if(isset($_GET['LastName']) && ! empty($_GET['LastName']) && $input == 'billing_last_name' )
    //     $value = esc_attr( $_GET['LastName'] );

    // // Billing email
    // if(isset($_GET['EmailAddress']) && ! empty($_GET['EmailAddress']) && $input == 'billing_email' )
    //     $value = sanitize_email( $_GET['EmailAddress'] );

    echo '<h1>Hello  world!</h1>';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    return $value;
}

class SZWoocommerce {

    private $woocommerce;

    function __construct(){

        // $this->woo = new Client(
        //     'http://example.com', 
        //     'ck_87d7a2e2511dd1ae9bf745d7f5c3dfb43af74474', 
        //     'cs_3ecdf4c9dc47ddeceebf97b6f0eb560207df5633',
        //     ['version' => 'wc/v3',]
        //     );
        // }    
        
    }

    public function addBuildToCart( $buildJson){

        $description = '<h3>Added Accessories</h3>';
        foreach($buildJson['accessories'] as $accessory){
            $description .= $accessory['name'] . ' - $' . $accessory['rrp'] . '<br>';
        }
        $description .= '<h3>Dealer</h3>';
        $description .= $buildJson['dealer']['name'];
        

        $id = $this->create_product(array(

            'type'               => '', // Simple product by default
            'name'               => 'Custom ' . $buildJson['model']['name'] . ' - ' . $buildJson['customer']['firstName'] . ' ' . $buildJson['customer']['surname'],
            'description'        => $description,
            'short_description'  => "A custom build for " . $buildJson['customer']['firstName'] . $buildJson['customer']['surname'],
            // 'sku'                => '',
            'regular_price'      => $buildJson['totalPrice'] . "",
            'visibility'         => 'visible', //or search/catalog/visible/hidden
            // 'sale_price'         => '',
            'reviews_allowed'    => false,
            'attributes'         => array(
                // Taxonomy and term name values
                'pa_color' => array(
                    'term_names' => array('Red', 'Blue'),
                    'is_visible' => true,
                    'for_variation' => false,
                ),
                'pa_size' =>  array(
                    'term_names' => array('X Large'),
                    'is_visible' => true,
                    'for_variation' => false,
                ),
            ),
        ) );  

        return $id;

    }

    

    // Custom function for product creation (For Woocommerce 3+ only)
    // https://gist.github.com/alphasider/b9916b51083c48466f330ab0006328e6
    public function create_product( $args ){

        // Get an empty instance of the product object (defining it's type)
        $product = $this->wc_get_product_object_type( $args['type'] );
        if( ! $product )
            return false;

        // Product name (Title) and slug
        $product->set_name( $args['name'] ); // Name (title).
        if( isset( $args['slug'] ) )
            $product->set_name( $args['slug'] );

        // Description and short description:
        $product->set_description( $args['description'] );
        $product->set_short_description( $args['short_description'] );

        // Status ('publish', 'pending', 'draft' or 'trash')
        $product->set_status( isset($args['status']) ? $args['status'] : 'publish' );

        // Visibility ('hidden', 'visible', 'search' or 'catalog')
        $product->set_catalog_visibility( isset($args['visibility']) ? $args['visibility'] : 'visible' );

        // Featured (boolean)
        $product->set_featured(  isset($args['featured']) ? $args['featured'] : false );

        // Virtual (boolean)
        $product->set_virtual( isset($args['virtual']) ? $args['virtual'] : false );

        // Prices
        $product->set_regular_price( $args['regular_price'] );
        $product->set_sale_price( isset( $args['sale_price'] ) ? $args['sale_price'] : '' );
        $product->set_price( isset( $args['sale_price'] ) ? $args['sale_price'] :  $args['regular_price'] );
        if( isset( $args['sale_price'] ) ){
            $product->set_date_on_sale_from( isset( $args['sale_from'] ) ? $args['sale_from'] : '' );
            $product->set_date_on_sale_to( isset( $args['sale_to'] ) ? $args['sale_to'] : '' );
        }

        // Downloadable (boolean)
        $product->set_downloadable(  isset($args['downloadable']) ? $args['downloadable'] : false );
        if( isset($args['downloadable']) && $args['downloadable'] ) {
            $product->set_downloads(  isset($args['downloads']) ? $args['downloads'] : array() );
            $product->set_download_limit(  isset($args['download_limit']) ? $args['download_limit'] : '-1' );
            $product->set_download_expiry(  isset($args['download_expiry']) ? $args['download_expiry'] : '-1' );
        }

        // Taxes
        if ( get_option( 'woocommerce_calc_taxes' ) === 'yes' ) {
            $product->set_tax_status(  isset($args['tax_status']) ? $args['tax_status'] : 'taxable' );
            $product->set_tax_class(  isset($args['tax_class']) ? $args['tax_class'] : '' );
        }

        // SKU and Stock (Not a virtual product)
        if( isset($args['virtual']) && ! $args['virtual'] ) {
            $product->set_sku( isset( $args['sku'] ) ? $args['sku'] : '' );
            $product->set_manage_stock( isset( $args['manage_stock'] ) ? $args['manage_stock'] : false );
            $product->set_stock_status( isset( $args['stock_status'] ) ? $args['stock_status'] : 'instock' );
            if( isset( $args['manage_stock'] ) && $args['manage_stock'] ) {
                $product->set_stock_status( $args['stock_qty'] );
                $product->set_backorders( isset( $args['backorders'] ) ? $args['backorders'] : 'no' ); // 'yes', 'no' or 'notify'
            }
        }

        // Sold Individually
        $product->set_sold_individually( isset( $args['sold_individually'] ) ? $args['sold_individually'] : false );

        // Weight, dimensions and shipping class
        $product->set_weight( isset( $args['weight'] ) ? $args['weight'] : '' );
        $product->set_length( isset( $args['length'] ) ? $args['length'] : '' );
        $product->set_width( isset(  $args['width'] ) ?  $args['width']  : '' );
        $product->set_height( isset( $args['height'] ) ? $args['height'] : '' );
        if( isset( $args['shipping_class_id'] ) )
            $product->set_shipping_class_id( $args['shipping_class_id'] );

        // Upsell and Cross sell (IDs)
        $product->set_upsell_ids( isset( $args['upsells'] ) ? $args['upsells'] : '' );
        $product->set_cross_sell_ids( isset( $args['cross_sells'] ) ? $args['upsells'] : '' );

        // Attributes et default attributes
        if( isset( $args['attributes'] ) )
            $product->set_attributes( $this->wc_prepare_product_attributes($args['attributes']) );
        if( isset( $args['default_attributes'] ) )
            $product->set_default_attributes( $args['default_attributes'] ); // Needs a special formatting

        // Reviews, purchase note and menu order
        $product->set_reviews_allowed( isset( $args['reviews'] ) ? $args['reviews'] : false );
        $product->set_purchase_note( isset( $args['note'] ) ? $args['note'] : '' );
        if( isset( $args['menu_order'] ) )
            $product->set_menu_order( $args['menu_order'] );

        // Product categories and Tags
        if( isset( $args['category_ids'] ) )
            $product->set_category_ids( $args['category_ids'] );
        if( isset( $args['tag_ids'] ) )
            $product->set_tag_ids( $args['tag_ids'] );


        // Images and Gallery
        $product->set_image_id( isset( $args['image_id'] ) ? $args['image_id'] : "" );
        $product->set_gallery_image_ids( isset( $args['gallery_ids'] ) ? $args['gallery_ids'] : array() );

        ## --- SAVE PRODUCT --- ##
        $product_id = $product->save();

        return $product_id;
    }

    // Utility function that returns the correct product object instance
    private function wc_get_product_object_type( $type ) {
        // Get an instance of the WC_Product object (depending on his type)
        if( isset($args['type']) && $args['type'] === 'variable' ){
            $product = new WC_Product_Variable();
        } elseif( isset($args['type']) && $args['type'] === 'grouped' ){
            $product = new WC_Product_Grouped();
        } elseif( isset($args['type']) && $args['type'] === 'external' ){
            $product = new WC_Product_External();
        } else {
            $product = new WC_Product_Simple(); // "simple" By default
        } 
        
        if( ! is_a( $product, 'WC_Product' ) )
            return false;
        else
            return $product;
    }

    // Utility function that prepare product attributes before saving
    private function wc_prepare_product_attributes( $attributes ){
        global $woocommerce;

        $data = array();
        $position = 0;

        foreach( $attributes as $taxonomy => $values ){
            if( ! taxonomy_exists( $taxonomy ) )
                continue;

            // Get an instance of the WC_Product_Attribute Object
            $attribute = new WC_Product_Attribute();

            $term_ids = array();

            // Loop through the term names
            foreach( $values['term_names'] as $term_name ){
                if( term_exists( $term_name, $taxonomy ) )
                    // Get and set the term ID in the array from the term name
                    $term_ids[] = get_term_by( 'name', $term_name, $taxonomy )->term_id;
                else
                    continue;
            }

            $taxonomy_id = wc_attribute_taxonomy_id_by_name( $taxonomy ); // Get taxonomy ID

            $attribute->set_id( $taxonomy_id );
            $attribute->set_name( $taxonomy );
            $attribute->set_options( $term_ids );
            $attribute->set_position( $position );
            $attribute->set_visible( $values['is_visible'] );
            $attribute->set_variation( $values['for_variation'] );

            $data[$taxonomy] = $attribute; // Set in an array

            $position++; // Increase position
        }
        return $data;
    }
}