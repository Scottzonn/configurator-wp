<?php
/*
    Plugin Name:    Camper Configurator
    Plugin URI:     http://webcrunch.com.au
    Description:    Camper configurator for Australian brands
    Author:         Scott Zonneveldt
    Author URI:     http://webcrunch.com.au
    Version:        1.0.3
*/
include( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );

class APF_CreatePage extends CConfigurator_AdminPageFramework {
    /**
     * The set-up method which is triggered automatically with the 'wp_loaded' hook.
     *
     * Here we define the setup() method to set how many pages, page titles and icons etc.
     */
    public function setUp() {
        // Create the root menu - specifies to which parent menu to add.
        $this->setRootMenuPage( 'Settings' );
        // Add the sub menus and the pages.
        $this->addSubMenuItems(
            array(
                'title'     => '1. My First Setting Page',  // page and menu title
                'page_slug' => 'my_first_settings_page'     // page slug
            )
        );
    }
    /**
     * One of the pre-defined methods which is triggered when the page contents is going to be rendered.
     *
     * Notice that the name of the method is 'do_' + the page slug.
     * So the slug should not contain characters which cannot be used in function names such as dots and hyphens.
     */
    public function do_my_first_settings_page() {
        ?>
        <h3>Action Hook</h3>
        <p>This is inserted by the 'do_' + page slug method.</p>
        <?php
    }
}
// Instantiate the class object.
new APF_CreatePage;
// That's it!! See, it's very short and easy, huh?