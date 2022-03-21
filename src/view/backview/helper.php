<div class="container pt-5 bgw">
    <div class="row">
        <div class="alert alert-primary" role="alert">
            <?php _e('This helper allows you to utilize CryptoWS functions to interact with Cryptocoins API. It means, that this page contains reminder of CWS plugin API, and not Coingecko itself.
            <br>For example, if you want to create a shortcode, that will display prices for some coins: <br>

            <br> <b>1.</b> Inside the shortcode function, you need to take "params" from needed API function and call CWS API. In the following example, we calling <b>simplePrice</b> function from
           chapter <b>simple</b>. Also don\'t forget to create an instance of Api class, like $api = new \Cryptows\Classes\Api();<br>
            <br><b>2</b>. callApi() function takes 3 arguments - chapter name, function name, $data array of "params". If params are not required, simply send it as empty array - []<br>', 'cws'); ?>


            <br>&nbsp; $api = new \Cryptows\Classes\Api();<br>
            <br><?php _e('//$data is array of "params", taken from corresponding API chapter and function inside it.', 'cws'); ?><br>
            <br>$data = [
            <br><span class="ms-3">'ids' => 'pegascoin,  3x-short-sushi-token',</span>
            <br><span class="ms-3">'vs_currencies' => 'btc',</span>
            <br><span class="ms-3">'include_market_cap' => false,</span>
            <br><span class="ms-3">'include_24hr_vol' => true,</span>
            <br><span class="ms-3">'include_24hr_change' => false,</span>
            <br><span class="ms-3">'include_last_updated_at' => false,</span>
            <br>];

            <br><?php _e('//Calling CWS API', 'cws'); ?>
           <br> print_r($api->callApi('simple', 'simplePrice', $data));

            <h3 class="mt-2"><?php _e('Example for "ping" function, where no parameters required:', 'cws'); ?></h3>

            print_r($api->callApi('ping', 'ping', []));<br>

            <br><b>3</b>. <?php _e('Combining all together:', 'cws'); ?> <br>

            <br>function MyShortcodeCallback() {

            <br>&nbsp; $api = new \Cryptows\Classes\Api();
            <br>&nbsp; print_r($api->callApi('ping', 'ping', []));

            <br>}
            <br>add_shortcode('MyShortcode', 'MyShortcodeCallback');
        </div>

        <h2><?php _e('Helper for API functions', 'cws'); ?></h2>
        <div class="col">

            <?php
            foreach($helper as $chapters => $functions) {
                echo '<div class="alert alert-info mt-3 mb-3" role="alert"><h3>Chapter: ' . $chapters . '</h3></div>';


                foreach($functions as $function => $function_content ) {
                    echo '<div class="single_func"><h5>';
                    _e('Function name: ', 'cws');
                    echo '<span style=\'color: green;\';>' . $function . '</span></h5>';

                    foreach($function_content as $content => $value ) {

                        if($content !== 'params') {

                            if($content == 'url') {
                                echo '<b>' . $content . '</b>: <span class="copythis">' . $value . '</span><span class="cancopy">';
                                _e('<--- Click to copy', 'cws');
                                echo '</span><br>';
                            } else {
                                echo '<b>' . $content . '</b>: ' . $value . '<br>';
                            }

                        } else {

                            if($value !== false) {
                                echo '<b>' . $content . '</b>: <br>';
                                echo '<table class="table">';
                                foreach ( $value as $param_name => $param_value) {
                                    $required = !empty($param_value->required) ? "<span style='color: red;';>" . $param_value->required . "</span>" : "No";
                                    echo '<tr><th>' . $param_name . '</th></tr> <tr><td><span style=\'color: blue;\';>';
                                    _e('Type:', 'cws');

                                    echo '</span>' . $param_value->type . '</td></tr><tr><td><span style=\'color: blue;\';>';
                                    _e(' Required:', 'cws');

                                    echo '</span> ' . $required . '</td></tr><tr><td><span style=\'color: blue;\';>';
                                    _e('Description:', 'cws');

                                    echo '</span>' . $param_value->descr . '</td></tr>';

                                }
                                echo '</table>';
                            } else {
                                echo '<b>' . $content . '</b>: ';
                                _e('<b>No parameters required</b>', 'cws');

                            }
                        }

                    }
                    echo '</div>';
                }
            }

            ?>


        </div>
    </div>
</div>