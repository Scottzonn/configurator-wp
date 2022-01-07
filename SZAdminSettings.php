<?php
echo '<h1>working</h1>';

include( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );
class SZAdminSettings extends CConfiguratorAdminPageFramework {
    /**
     * The set-up method which is triggered automatically with the 'wp_loaded' hook.
     * Here we define the setup() method to set how many pages, page titles and icons etc.
     */
    public function setUp() {
        echo '<h1>working</h1>';
        // Create the root menu - specifies to which parent menu to add.
        $this->setRootMenuPage( 'Settings' );
        // Add the sub menus and the pages.
        $this->addSubMenuItems(
            array(
                'title'     => 'Camper Configurator Settings',  // page and menu title
                'page_slug' => 'camper_config_settings'     // page slug
            )
        );
    }
    /**
     * One of the pre-defined methods which is triggered when the page contents is going to be rendered.
     *
     * Notice that the name of the method is 'do_' + the page slug.
     * So the slug should not contain characters which cannot be used in function names such as dots and hyphens.
     */
    public function do_camper_config_settings() {
        ?>
        <h3>Action Hook</h3>
        <p>This is inserted by the 'do_' + page slug method.</p>
        <?php
    }
}
// Instantiate the class object.
new SZAdminSettings;
// That's it!! See, it's very short and easy, huh?