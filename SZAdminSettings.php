<?php


include( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );
class SZAdminSettings extends CConfiguratorAdminPageFramework {
    /**
     * The set-up method which is triggered automatically with the 'wp_loaded' hook.
     * Here we define the setup() method to set how many pages, page titles and icons etc.
     */
    public function setUp() {

        // Create the root menu - specifies to which parent menu to add.
        $this->setRootMenuPage( 'Settings' );
        // Add the sub menus and the pages.
        $this->addSubMenuItems(
            array(
                'title'     => 'Camper Configurator Settings',  // page and menu title
                'page_slug' => 'camper_config_settings'     // page slug
            )
        );

        $this->addInPageTabs(
            'camper_config_settings',    // set the target page slug so that the 'page_slug' key can be omitted from the next continuing in-page tab arrays.
            array(
                'tab_slug'  =>    'tab_general',    // avoid hyphen(dash), dots, and white spaces
                'title'     =>    __( 'General Settings', 'sztext' ),
            ),        
            array(
                'tab_slug'  =>    'tab_emails',
                'title'     =>    __( 'Email Notifications', 'sztext' ),
            ),                    
        );    
    }
    // $this->setPageHeadingTabsVisibility( false );

    /**
     * One of the pre-defined methods which is triggered when the page contents is going to be rendered.
     *
     * Notice that the name of the method is 'do_' + the page slug.
     * So the slug should not contain characters which cannot be used in function names such as dots and hyphens.
     */
    // public function do_camper_config_settings() {

    // }
        /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_general( $sContent ) {      
        return $sContent 
            . '<h3>Tab Content Filter</h3>'
            . '<p>This is the first tab! This is inserted by the <b><i>\'content_ + page slug + _ + tab slug\'</i></b> method.</p>';
            
    }
        /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}_{tab slug}
     */    
    public function content_camper_config_settings_tab_emails( $sContent ) {      
        return $sContent 
            . '<h3>Tab Content Filter</h3>'
            . '<p>This is the second tab! This is inserted by the <b><i>\'content_ + page slug + _ + tab slug\'</i></b> method.</p>';
            
    }

    /**
     * One of the pre-defined methods which is triggered when the registered page loads.
     *
     * Here we add form fields.
     * @callback        action      load_{page slug}
     */
    public function load_camper_config_settings_tab_general( $oAdminPage ) {
        $this->addSettingFields(
            array(    // Single text field
                'field_id'      => 'webhook_url',
                'type'          => 'text',
                'title'         => 'Webhook URL',
                'description'   => 'Customer build data will be sent here',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'https://www.integromat.com/yoururl'
                )
                ),
            array( // Submit button
                'field_id'      => 'submit_button',
                'type'          => 'submit',
            )
        );
    }

    /**
     * One of the pre-defined methods which is triggered when the registered page loads.
     *
     * Here we add form fields.
     * @callback        action      load_{page slug}
     */
    public function load_camper_config_settings_tab_emails( $oAdminPage ) {
        $this->addSettingFields(
            array(    // Single text field
                'field_id'      => 'self_email_recipients',
                'type'          => 'text',
                'title'         => 'Recipients',
                'description'   => 'eg. admin@campers.com, sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'youremail@company.com'
                )
            ),
            array(    // rich
                'field_id'      => 'self_email_notification',
                'title'         => 'Email Template',
                'type'          => 'textarea',
                'rich'          => true,
                'attributes'    => array(
                    'field' => array(
                        'style' => 'width: 100%;' // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    ),
                ),
            ),
            array( // Submit button
                'field_id'      => 'submit_button',
                'type'          => 'submit',
            )
        );
    }
    /**
     * One of the pre-defined methods which is triggered when the page contents is going to be rendered.
     * @callback        action      do_{page slug}
     */
    // public function do_camper_config_settings() {
    //     // Show the saved option value.
    //     // The extended class name is used as the option key. This can be changed by passing a custom string to the constructor.
    //     echo '<h3>Saved Fields</h3>';
    //     echo '<pre>my_text_field: ' . AdminPageFramework::getOption( 'APF_AddFields', 'my_text_field', 'default text value' ) . '</pre>';
    //     echo '<pre>my_textarea_field: ' . AdminPageFramework::getOption( 'APF_AddFields', 'my_textarea_field', 'default text value' ) . '</pre>';
    //     echo '<h3>Show all the options as an array</h3>';
    //     echo $this->oDebug->get( AdminPageFramework::getOption( 'APF_AddFields' ) );
    // }
}
// Instantiate the class object.
new SZAdminSettings;
// That's it!! See, it's very short and easy, huh?