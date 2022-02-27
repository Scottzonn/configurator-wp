<?php 

include_once( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );

class Build_PostType extends CConfiguratorAdminPageFramework_PostType {
        
    /**
     * Sets up necessary settings.
     */
    public function setUp() {
 
        $this->setArguments(
            array( // argument - for the array structure, refer to http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
                'labels'            => array(
                    'name'           => __( 'Colors', 'admin-page-framework-turorial' ),
                    'add_new_item'   => __( 'Add Color', 'admin-page-framework-tutorial' ),
                ),
                'supports'          => array( 'title' ), // e.g. array( 'title', 'editor', 'comments', 'thumbnail', 'excerpt' ),
                'public'            => true,
                'menu_icon'         => version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) 
                    ? 'dashicons-welcome-learn-more' 
                    : 'https://lh4.googleusercontent.com/-z7ydw-aPWGc/UwpeB96m5eI/AAAAAAAABjs/Brz6edaUB58/s800/demo04_16x16.png',
                // (framework specific key) this sets the screen icon for the post type for WordPress v3.7.1 or below.
            )    
        );    
 
    }

}