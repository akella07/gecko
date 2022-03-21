<?php

namespace Cryptows\Classes;

use Cryptows\Classes\Config;

use Cryptows\Classes\View;

class Ajax
{
    public function __construct() {

        // Add Javascript and CSS for front-end display
        add_action('wp_enqueue_scripts', array($this,'enqueue'));

        // Add ajax function that will receive the call back for logged in users
        add_action( 'wp_ajax_my_action', array( $this, 'ord_domain_check_callback') );
        // Add ajax function that will receive the call back for guest or not logged in users
        add_action( 'wp_ajax_nopriv_my_action', array( $this, 'ord_domain_check_callback') );

    }

    // This is an example of enqueuing a JavaScript file and a CSS file for use on the front end display
    public function enqueue() {
        // Actual enqueues, note the files are in the js and css folders
        // For scripts, make sure you are including the relevant dependencies (jquery in this case)
        wp_enqueue_script('order-ajx', CWSSCRIPTPATH . 'app/assets/js/ajax/main.js', array('jquery'), '1.0', true);

        // Sometimes you want to have access to data on the front end in your Javascript file
        // Getting that requires this call. Always go ahead and include ajaxurl. Any other variables,
        // add to the array.
        // Then in the Javascript file, you can refer to it like this: ord_ajx_data.ajaxurl
        wp_localize_script( 'order-ajx', 'ord_ajx_data', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('_wpnonce')
        ));

    }



    /**
     * Callback function for the my_action used in the form.
     *
     * Processses the data recieved from the form, and you can do whatever you want with it.
     *
     * @return    echo   response string about the completion of the ajax call.
     */
    function ord_domain_check_callback() {
        // echo wp_die('<pre>' . print_r($_REQUEST) . "<pre>");

        check_ajax_referer( '_wpnonce', 'security');

        if( ! empty( $_POST )){

            $pos = strpos($_SERVER['SCRIPT_URI'], $_SERVER['HTTP_REFERER']);

            if ($pos === false) {
                echo 'bad';
            } else {
                if ((isset($_POST['action'])) && (isset($_POST['domain']))) {

         /*            $conf = new Config();
                    $config = $conf->getConfig();

                    $auth_token = $config->apiToken;
                    $post = [
                        'domain' => $_POST['domain'],
                    ];

                    $HostingAPI = new HostingApi($auth_token);

                    $response = $HostingAPI->apiCall('domain/check', $post);

                    echo json_encode($response); */

                }
            }

        } else {

            echo 'bad';
        }

      wp_die(); // required to terminate the call so, otherwise wordpress initiates the termination and outputs weird '0' at the end.

    }

}
