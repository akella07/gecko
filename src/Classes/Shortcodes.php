<?php

namespace Cryptows\Classes;

use Cryptows\Classes\Config;
use Cryptows\Classes\View;
use Cryptows\Classes\Api;

class Shortcodes
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'add_shortcodes' ) );


    }

    public function add_shortcodes()
    {

        add_shortcode('testws', array( $this, 'testws_callback' ));
        add_shortcode( 'mainview', array( $this, 'mainview_cb' ) );
    }

    public function testws_callback()
    {
        $api = new Api();

        $data = [
           'ids' => 'pegascoin,  3x-short-sushi-token',
            'vs_currencies' => 'btc',
            'include_market_cap' => false,
            'include_24hr_vol' => true,
            'include_24hr_change' => false,
            'include_last_updated_at' => false,
        ];

       // simpleSupportedVsCurrencies

        //string $chapter, string $apiFuncName, bool $all
        echo '<pre>';
        //print_r($api->Helper('simple','simpleSupportedVsCurrencies', false));
        print_r($api->callApi('simple', 'simpleSupportedVsCurrencies', []));
        echo '</pre>';
    }

    public function mainview_cb(): ?string
    {

        $view = new View();
        $output = '';

        $output .= $view->getStyles();
        $output .= $view->getInline();

        //session_destroy();

        $conf = new Config();
        $config = $conf->getConfig();

        $output .= $view->getTemplate();

        return $output;
    }

}