<?php

class OpalService_Shortcode_Base extends WPBakeryShortCode {
    public function __construct( $settings ){
        parent::__construct($settings);
        if( !file_exists( get_template_directory().'/vc_templates/'.$this->settings['base'] ) ){
            $this->html_template = OPALSERVICE_PLUGIN_DIR.'templates/vc_templates/'.$this->settings['base'].'.php';
        }
    }
}

class WPBakeryShortCode_Opalservice_VC_List_Service extends OpalService_Shortcode_Base{}
class WPBakeryShortCode_Opalservice_VC_Carousel_Service extends OpalService_Shortcode_Base{}
class WPBakeryShortCode_Opalservice_VC_Category_Service extends OpalService_Shortcode_Base{}
class WPBakeryShortCode_Opalservice_VC_Tabs_Service extends OpalService_Shortcode_Base{}