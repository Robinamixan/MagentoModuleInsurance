var ShippingInsurance = Class.create();
ShippingInsurance.prototype = {
    initialize: function (subtotal, insurance_ajax_url) {
        var code = 0;

        $$('#s_method_insurance').each(function(el){
            Event.observe(el, 'click', function(){
                if (el.checked === true) {
                    var code = 0;
                    $('shipping_insurance_panel').removeClassName('hidden');

                    $$('input[type="radio"][name="shipping_method"]').each(function(el){
                        if (el.checked === true) {
                            code = el.getValue();
                            return false;
                        }
                    });

                    new Ajax.Request(insurance_ajax_url, {
                        parameters: {shipping_code: code, subtotal: subtotal},
                        onSuccess: function(transport, json){
                            $("result_insurance").update(transport.responseJSON.outputValue);
                        }
                    });

                    return false;
                } else {
                    $('result_insurance').update('');
                    $('shipping_insurance_panel').addClassName('hidden');
                }
            });
        });

        $$('input[type="radio"][name="shipping_method"]').each(function(el){
            Event.observe(el, 'click', function(){
                if (el.checked === true) {
                    var code = el.getValue();
                    $$('#s_method_insurance').each(function(el2){
                        if (el2.checked === true) {

                            new Ajax.Request(insurance_ajax_url, {
                                parameters: {shipping_code: code, subtotal: subtotal},
                                onSuccess: function(transport, json){
                                    $("result_insurance").update(transport.responseJSON.outputValue);
                                }
                            });

                            return false;
                        }
                    });

                    return false;
                }
            });
        });
    }
};