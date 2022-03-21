jQuery("#check_domain").click(function() {
    event.preventDefault();
        var data = {
            action: 'ord_domain_check',
            security: ord_ajx_data.nonce,
            domain: jQuery("#domain").val(),
        };

    jQuery.post( ord_ajx_data.ajaxurl, data, function( response )  {

            resp = JSON.parse(response);

            console.log(resp.result);
            if(resp.result == true) {
                jQuery(".alert_available").show();
                jQuery(".alert_occupied").hide();
                jQuery("#other_data").show();
                jQuery("#chosen_domain").val(jQuery("#domain").val());
            } else {
                jQuery(".alert_available").hide();
                jQuery(".alert_occupied").show();
                jQuery("#other_data").hide();
                jQuery("#chosen_domain").val("");
            }

        });
});