<?php


include_once( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );
include_once( dirname( __FILE__ ) . 'SZCustomer.php' );
class SZBuildSubmissionPost extends CConfiguratorAdminPageFramework_PostType {
    /**
     * Automatically called with the 'wp_loaded' hook.
     */
    public function setUp() {

        $this->setArguments(
            array( // argument - for the array structure, refer to http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
                'labels' => array(
                    'name'               => 'Customer Builds',
                    'add_new_item'       => 'New Customer Build',
                ),
                'supports'          => array( 'title' ), // e.g. array( 'title', 'editor', 'comments', 'thumbnail', 'excerpt' ),
                'public'            => true,
                'menu_icon'         => version_compare( $GLOBALS['wp_version'], '3.8', '>=' )
                    ? 'dashicons-admin-generic'
                    : plugins_url( 'asset/image/wp-logo_16x16.png', APFDEMO_FILE ),
                // (framework specific key) this sets the screen icon for the post type for WordPress v3.7.1 or below.
                'screen_icon' => dirname( APFDEMO_FILE  ) . '/asset/image/wp-logo_32x32.png', // a file path can be passed instead of a url, plugins_url( 'asset/image/wp-logo_32x32.png', APFDEMO_FILE )
            )
        );

        // $this->addTaxonomy(
        //     'apf_tutorial_example_taxonomy',  // taxonomy slug
        //     array(                  // argument - for the argument array keys, refer to : http://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
        //         'labels'                => array(
        //             'name'          => __( 'Tutorial Taxonomy', 'admin-page-framework-tutorial' ),
        //             'add_new_item'  => __( 'Add New Taxonomy', 'admin-page-framework-tutorial' ),
        //             'new_item_name' => __( 'New Taxonomy', 'admin-page-framework-tutorial' )
        //         ),
        //         'show_ui'               => true,
        //         'show_tagcloud'         => false,
        //         'hierarchical'          => true,
        //         'show_admin_column'     => true,
        //         'show_in_nav_menus'     => true,
        //         'show_table_filter'     => true,    // framework specific key
        //         'show_in_sidebar_menus' => true,    // framework specific key
        //     )
        // );
    }

    public function content( $sContent ) { 
                    
        $rrp = get_post_meta( $GLOBALS['post']->ID, 'rrp', true );
        $rrp = $rrp ? $rrp : '0';
        return "<h3>" . "RRP" . "</h3>";
 
    }    
}


class SZBuildMetabox extends CConfiguratorAdminPageFramework_MetaBox {
    /*
     * Use the setUp() method to define settings of this meta box.
     */
    public function setUp() {
        /**
         * Adds setting fields in the meta box.
         */
        $this->addSettingFields(
            array(
                'field_id'  => 'rrp',
                'type'      => 'text',
                'title'     => 'Build RRP',
            )
        );
    }
}

new SZBuildMetabox(
    null,   // meta box ID - can be null.
    'Build Details', // title
    array( 'sz_build_submission' ),                 // post type slugs: post, page, etc.
    'normal',                                      // context
    'low'                                          // priority
); 


class SZCustomerMetabox extends CConfiguratorAdminPageFramework_MetaBox {
    /*
     * Use the setUp() method to define settings of this meta box.
     */
    public function setUp() {
        /**
         * Adds setting fields in the meta box.
         */
        $this->addSettingFields(
            array(
                'field_id'  => 'firstName',
                'type'      => 'text',
                'title'     => 'First Name',
            ),
            array(
                'field_id'  => 'surname',
                'type'      => 'text',
                'title'     => 'Surname',
            ),
            array(
                'field_id'  => 'phone',
                'type'      => 'text',
                'title'     => 'Phone',
            ),
            array(
                'field_id'  => 'email',
                'type'      => 'text',
                'title'     => 'Email',
            ),
            array(
                'field_id'  => 'newsletter',
                'type'      => 'checkbox',
                'title'     => 'Newsletter',
            ),
            array(
                'field_id'  => 'deliveryMethod',
                'type'      => 'text',
                'title'     => 'Surname',
            ),
            array(
                'field_id'  => 'postcode',
                'type'      => 'text',
                'title'     => 'Surname',
            )
        );
    }
}

new SZCustomerMetabox (
    null,   // meta box ID - can be null.
    'Customer Details', // title
    array( 'sz_build_submission' ),                 // post type slugs: post, page, etc.
    'normal',                                      // context
    'low'                                          // priority
); 
