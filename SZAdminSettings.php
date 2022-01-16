<?php


include_once( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );
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
                'title'     => 'Camper Configurator',  // page and menu title
                'page_slug' => 'camper_config_settings'     // page slug
            )
        );

        $this->addInPageTabs(
            'camper_config_settings',    // set the target page slug so that the 'page_slug' key can be omitted from the next continuing in-page tab arrays.
            array(
                'tab_slug'  =>    'tab_general',    // avoid hyphen(dash), dots, and white spaces
                'title'     =>    __( 'General Settings', 'sztext' ),
            ),        
            // array(
            //     'tab_slug'  =>    'tab_manufacturer_settings',
            //     'title'     =>    __( 'Manufacturer Settings', 'sztext' ),
            // ), 
            array(
                'tab_slug'  =>    'tab_self_emails',
                'title'     =>    __( 'Admin Email Notifications', 'sztext' ),
            ),
            array(
                'tab_slug'  =>    'tab_customer_emails',
                'title'     =>    __( 'Customer Email Notification', 'sztext' ),
            ),     
            array(
                'tab_slug'  =>    'tab_dealer_emails',
                'title'     =>    __( 'Dealer Email Notification', 'sztext' ),
            ), 
            
        );    
    }

    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_self_emails( $sContent ) {      
        $shortcodes = "[first name] [surname] [full name] [email] [postcode] [phone] [address line 1] [address line 2] [city] [country] [state] [product name] [rrp] [image url] [accessories list]";
        return $sContent . '<h3>Available Shortcodes</h3>' . $shortcodes;
    }
    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_customer_emails( $sContent ) {      
        $shortcodes = "[first name] [surname] [full name] [email] [postcode] [phone] [address line 1] [address line 2] [city] [country] [state] [product name] [rrp] [image url] [accessories list]";
        return $sContent . '<h3>Available Shortcodes</h3>' . $shortcodes;
    }
    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_dealer_emails( $sContent ) {      
        $shortcodes = "[first name] [surname] [full name] [email] [postcode] [phone] [address line 1] [address line 2] [city] [country] [state] [product name] [rrp] [image url] [accessories list]";
        return $sContent . '<h3>Available Shortcodes</h3>' . $shortcodes;
    }

    /**
     * One of the pre-defined methods which is triggered when the registered page loads.
     *
     * Here we add form fields.
     * @callback        action      load_{page slug}
     */
    public function load_camper_config_settings_tab_general( $oAdminPage ) {
        $this->addSettingFields(
            array(
                'field_id'      => 'require_user_contact_details_upfront',
                'title'         => 'Require User Details First',
                'type'          => 'checkbox',
                'label'         => 'Require user contact details before showing prices',
                'default'   => false,
            ),
            array(
                'field_id'      => 'accent_color',
                'title'         => __( 'Accent Colour', 'admin-page-framework-loader' ),
                'type'          => 'color',
                'default'       => '#f26100',
            ),
            array(    // Single text field
                'field_id'      => 'webhook_url',
                'type'          => 'text',
                'title'         => 'Webhook URL (Optional)',
                'description'   => 'Customer build data will be sent',
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
    // public function load_camper_config_settings_tab_manufacturer_settings( $oAdminPage ) {
    //     //names must match strapi exactly
    //     $this->addSettingFields(
    //         array(
    //             'field_id'      => 'dealer_checkboxes',
    //             'title'         => __( 'Our Dealers', 'admin-page-framework-loader' ),
    //             'type'          => 'checkbox',
    //             'label'         => array(
    //                 'thedirt'  =>       __( 'The Dirt Off Road Campers', 'admin-page-framework-loader' ),
    //                 'tracktrailer' =>   __( 'Track Trailer', 'admin-page-framework-loader' ),
    //             ),
    //             'after_label'   => '<br />',
    //         ),            
    //         array( // Submit button
    //             'field_id'      => 'submit_button',
    //             'type'          => 'submit',
    //         )
    //     );
    // }

    /**
     * One of the pre-defined methods which is triggered when the registered page loads.
     *
     * Here we add form fields.
     * @callback        action      load_{page slug}
     */
    public function load_camper_config_settings_tab_self_emails( $oAdminPage ) {
        $this->addSettingFields(
            array(    // Single text field
                'field_id'      => 'self_email_to',
                'type'          => 'text',
                'title'         => 'Recipients',
                'description'   => 'eg. admin@campers.com, sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'youremail@company.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'self_email_from_name',
                'type'          => 'text',
                'title'         => 'From Name',
                'description'   => 'eg. My Dealership',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'youremail@company.com'
                )
            ),

            array(    // Single text field
                'field_id'      => 'self_email_from_email',
                'type'          => 'text',
                'title'         => 'From Email',
                'description'   => 'eg. sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'sales@campers.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'self_email_reply_to',
                'type'          => 'text',
                'title'         => 'Reply To',
                'description'   => 'eg. sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'sales@campers.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'self_email_subject',
                'type'          => 'text',
                'title'         => 'Subject',
                'description'   => 'eg. Alert: Customer Camper Submitted',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'Your Subject'
                )
            ),
            array(    // rich
                'field_id'      => 'self_email_template',
                'title'         => 'Email Template',
                'type'          => 'textarea',
                'rich'          => array(
                    'wpautop' => false
                ),
                'attributes'    => array(
                    'field' => array(
                        'style' => 'width: 100%;' // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    ),
                ),
            ),
            array( // Submit button
                'field_id'      => 'self_submit_button',
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
    public function load_camper_config_settings_tab_customer_emails( $oAdminPage ) {
        $this->addSettingFields(

            array(    // Single text field
                'field_id'      => 'customer_email_from_name',
                'type'          => 'text',
                'title'         => 'From Name',
                'description'   => 'eg. My Dealership',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'youremail@company.com'
                )
            ),

            array(    // Single text field
                'field_id'      => 'customer_email_from_email',
                'type'          => 'text',
                'title'         => 'From Email',
                'description'   => 'eg. sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'sales@campers.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'customer_email_reply_to',
                'type'          => 'text',
                'title'         => 'Reply To',
                'description'   => 'eg. sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'sales@campers.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'customer_email_subject',
                'type'          => 'text',
                'title'         => 'Subject',
                'description'   => 'eg. Alert: Customer Camper Submitted',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'Your Subject'
                )
            ),
            array(    // rich
                'field_id'      => 'customer_email_template',
                'title'         => 'Email Template',
                'type'          => 'textarea',
                'rich'          => array(
                    'wpautop' => false
                ),
                'attributes'    => array(
                    'field' => array(
                        
                        'style' => 'width: 100%;' // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    ),
                ),
            ),
            array( // Submit button
                'field_id'      => 'customer_submit_button',
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
    public function load_camper_config_settings_tab_dealer_emails( $oAdminPage ) {
        $this->addSettingFields(
            array(    // Single text field
                'field_id'      => 'dealer_email_to',
                'type'          => 'text',
                'title'         => 'Recipients',
                'description'   => 'eg. admin@campers.com, sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'youremail@company.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'dealer_email_from_name',
                'type'          => 'text',
                'title'         => 'From Name',
                'description'   => 'eg. My Dealership',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'youremail@company.com'
                )
            ),

            array(    // Single text field
                'field_id'      => 'dealer_email_from_email',
                'type'          => 'text',
                'title'         => 'From Email',
                'description'   => 'eg. sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'sales@campers.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'dealer_email_reply_to',
                'type'          => 'text',
                'title'         => 'Reply To',
                'description'   => 'eg. sales@campers.com',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'sales@campers.com'
                )
            ),
            array(    // Single text field
                'field_id'      => 'dealer_email_subject',
                'type'          => 'text',
                'title'         => 'Subject',
                'description'   => 'eg. Alert: Customer Camper Submitted',
                'attributes'    => array(
                    'size' => 60,
                    'placeholder' => 'Your Subject'
                )
            ),
            array(    // rich
                'field_id'      => 'dealer_email_template',
                'title'         => 'Email Template',
                'type'          => 'textarea',
                'rich'          => array(
                    'wpautop' => false
                ),
                'attributes'    => array(
                    'field' => array(
                        'style' => 'width: 100%;' // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    ),
                ),
            ),
            array( // Submit button
                'field_id'      => 'dealer_submit_button',
                'type'          => 'submit',
            )
        );
    }

    public function getWebhookUrl(){
        return CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'webhook_url', '');
    }
    public function getRequireUserDetailsFirst(){
        return CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'require_user_contact_details_upfront', '');
    }
    public function getAccentColor(){
        return CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'accent_color', '');
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
