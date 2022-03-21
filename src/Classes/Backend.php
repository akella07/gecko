<?php

namespace Cryptows\Classes;

use Cryptows\Classes\Backview;
use Cryptows\Classes\View;
use Cryptows\Classes\Api;

class Backend
{

    public function __construct()
    {
        add_action( 'init', array( $this, 'add_admin_shortcodes' ) );
        add_action( 'admin_menu', array( $this, 'add_wp_admin_pages' ) );

    }

    public function add_admin_shortcodes()
    {

        // add_shortcode('testws', array( $this, 'testws_callback' ));

    }

    public function add_wp_admin_pages()
    {
        $slug = 'Crypto-WS-Solution';
        $icon = "dashicons-database-view";
        \add_menu_page('Crypto WS', 'Crypto WS', 'manage_options', $slug , array( __CLASS__, 'ShowCWSOverview' ) ,$icon);
        \add_submenu_page($slug, 'Settings', 'Crypto WS Settings', "manage_options", "cws_settings_menu", array( __CLASS__, 'ShowSettingsPage' ));
        \add_submenu_page($slug, 'API helper', 'API helper', "manage_options", "cws_api_helper", array( __CLASS__, 'ShowHelperPage' ));
        // add_submenu_page(null, 'Transaction', 'Transaction', "manage_options", "cws_transaction", array( __CLASS__, 'ShowTransactionPage' ));
        remove_submenu_page($slug,$slug);
    }

    public function ShowCWSOverview()
    {
        //nothing here
    }

    public static function ShowSettingsPage()
    {
        $view = new View();
        echo $view->getStyles();
        echo $view->getInline();

        $backview = new Backview();

        include CWSROOT . '/src/view/backview/settings.php';

    }

    public static function ShowHelperPage()
    {
        $backview = new Backview();
        $api = new Api();

        echo $backview->getStyles();
        echo $backview->getInline();

        $helper = $api->Helper('', '', true);

        include CWSROOT . '/src/view/backview/helper.php';

        echo $backview->getScripts();

    }

}