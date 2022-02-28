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
            array(
                'tab_slug'  =>    'tab_products',
                'title'     =>    __( 'Products', 'sztext' ),
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
            array(
                'tab_slug'  =>    'tab_help',
                'title'     =>    __( 'Shortcodes', 'sztext' ),
            ),
            
        );    
    }
    private function shortcode_instructions(){
        $customercodes = "<h4>Customer Details</h4>
        [first_name]
        [surname]
        [full_name]
        [email]
        [postcode]
        [phone]
        [address_line_1]
        [address_line_2]
        [city]
        [country]
        [state]
        [deliveryMethod]";

        $product ="<h4>Build Details</h4>
        [product_name]
        [rrp]
        [totalPrice]
        [image_url]
        [accessories_list]
        [custom_options_list]
        [model_name]
        [shareLinkURL]";

        $dealerAdmin = "<h4>Dealer Admin</h4>
        [salesperson]
        [location]
        [match_wheels]
        [towVehicleMake]
        [towVehicleModel]
        [towVehicleYear]
        [towVehicleWheelSize]
        [towVehicleTyreSize]
        [specialRequests]
        [comments]
        [buildDateRequested]
        [discount]
        [discountType]";

        $loop = "<h4>Accessories Loop</h4><p>[accessories list] prints a default list, but you can do a custom display by looping through accessories like so:</p>";
        $loop .= "[acc_loop]<br>";
        $loop .= "[acc_name] - $[acc_rrp] - Part Number:[acc_part_number]<br>";
        $loop .= "[/acc_loop]<br>";
        
        return '<h3>Available Shortcodes</h3>' . $customercodes . $product . $dealerAdmin . $loop;
    }
    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_self_emails( $sContent ) {      
        return $sContent . $this->shortcode_instructions();
    }
    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_customer_emails( $sContent ) {      
        return $sContent . $this->shortcode_instructions();
    }


    
    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_dealer_emails( $sContent ) {      
        return $sContent . $this->shortcode_instructions();
    }

    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_help( $sContent ) {      
        $shortcodes = "<p>Use <strong>[camper_configurator]</strong> shortcode to embed the configurator on any page. ";
        $info = "To default to a specific product (eg. for use on a product or model page) you can add attributes:</p>";
        $info .= "<p><strong>[camper_configurator product=\"tvan\"]</strong> or</p>";
        $info .= "<p><strong>[camper_configurator product=\"tvan\" model=\"Inspire\"]</strong></p>";
        $info .= "<p>Note: If you specify a model, you must also specify the corresponding product.</p>";
        $info .= "<p>Note: The embedded configurators will respect your \"Require User Details First\" setting (see General Settings).</p>";
        $info .= "<h3>Dealer Mode</h3>";
        $info .= "<p>[camper_configurator mode=\"dealer\"]</p>";
        $info .= "<p>This will add the configurator in dealer mode which allows your staff to input further details such as: Discount, Wheel Matching, Build Date, Comments, Location (show/showroom)</p>";
        
        
        return $sContent . '<h3>Available Shortcodes</h3>' . $shortcodes . $info;
    }

    /**
     * One of the predefined callback method.
     * 
     * @remark      content_{page slug}
     */    
    public function content_camper_config_settings_tab_products( $sContent ) {      
        $shortcodes = "<p>Select the Products you want to sell through the configurator</p>";
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://camper-configurator-spw7u.ondigitalocean.app/api/products?fields%5B0%5D=name&fields%5B1%5D=id&pagination%5Blimit%5D=500',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        $products = json_decode($response);
        
        for($i = 0; $i < count($products->data); $i++){
            $this->addSettingsField(
                array(
                    'field_id'      =>    'product_' . $products->data[$i]->id,
                    'title'         =>    $products->data[$i]->attributes->name,
                    'type'          =>    'checkbox',
                    'default'       =>    false,
                )
            );
        }
        return $sContent . $shortcodes . $response;
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
                'title'         => 'Require Contact Details',
                'type'          => 'checkbox',
                'label'         => 'Require user contact details before showing prices',
                'default'   => false,
            ),
            array(
                'field_id'      => 'enable_cart',
                'title'         => 'Woocommerce Integration',
                'type'          => 'checkbox',
                'label'         => 'Include an "Add to cart" button at the end of the build process. (Woocommerce must be installed)',
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
                'description'   => 'Customer build data and contact details will be sent to this URL. This can be used to integrate with other software. <p>The webhook will get called twice. Once when a customer fills in their contact details, and a second time when they complete their build.</p>',
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
                    'rows' => 30,
                    'cols' => 120,
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
                    'rows' => 30,
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
                    'rows' => 30,
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
        return CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'accent_color', '#f26100');
    }
    public function getEnableCart(){
        return CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'enable_cart', '');
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


function additionalStyles( $sCSSRules ) {
    return $sCSSRules
        . '.sz-field .sz-input-label-container{ display:block; width: 100%; }'
        . '.sz-field sz-field-textarea {width: 100%;} ';

}
add_filter( 'style_common_admin_page_framework', 'additionalStyles' );