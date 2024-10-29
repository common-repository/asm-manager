<?php
/**
 * @package ASM Shipping Method
 * @version 1.2.7
 */

function asmplsww_shipping_method_init()
{
    if (!class_exists('ASMPLSWW_Shipping_Method')) {
        class ASMPLSWW_Shipping_Method extends WC_Shipping_Method
        {
            public function __construct($instance_id = 0)
            {
                $this->id = 'asmplsww'; // Id for your shipping method. Should be uunique.

                // new fields added
                $this->instance_id = absint($instance_id);
                $this->supports = array(
                    'shipping-zones',
                    'instance-settings',
                    'instance-settings-modal',
                );

                $this->method_title = __('Advanced Shipping Manager');  // Title shown in admin
                $this->method_description = __('Description of your shipping method'); // Description shown in admin

                $this->enabled = "yes"; // This can be added as an setting but for this example its forced enabled
                $this->title = 'Advanced Shipping Manager';// This can be added as an setting but for this example its forced.

                $this->init();
            }

            function init()
            {
                // Load the settings API
                $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
                $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

                // Save settings in admin if you have any defined
                add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'add_asmplsww_shipping_method'));

            }

            /**
             * Form Fields
             */
            public function init_form_fields()
            {
                $this->instance_form_fields = array(
                    'enabled' => array(
                        'title' => __('Enable / Disable', 'woocommerce'),
                        'type' => 'checkbox',
                        'label' => __('Enable This Shipping Service', 'woocommerce'),
                        'default' => 'yes',
                        'id' => 'asmplsww_enable_disable_shipping',
                    ),
                );
            }

            public function calculate_shipping($package = array())
            {
                //live query
                include 'asmplsww_query_live.php';

                //Shipping API
                if (!class_exists('ASMPLSWW_Shipping_Api')) {
                    include_once 'asmplsww_shipping_api.php';
                }

                try {
                    $shippingValues = ASMPLSWW_Shipping_Api::asmplswwGetShippingValue($xml_data);
                } catch (Exception $e) {
                    $message = $e->getMessage();
                    $messageType = "error";
                    wc_add_notice($message, $messageType);
                }

                if (isset($shippingValues['Name'], $shippingValues['Rate'])) {
                    $shipping_single_rate = array(
                        'id' => $this->id,
                        'label' => $shippingValues['Name'],
                        'cost' => $shippingValues['Rate'],
                    );
                    $this->add_rate($shipping_single_rate);
                } else if (is_array($shippingValues) && !empty($shippingValues)) {
                    foreach ($shippingValues as $key => $value) {
                        if ($shippingValues[$key]['Rate']) {
                            $shipping_rate = array(
                                'id' => 'key_' . $key,
                                'label' => $shippingValues[$key]['Name'],
                                'cost' => $shippingValues[$key]['Rate'],
                            );
                            $this->add_rate($shipping_rate);
                        }
                    }
                }
            }
        }
    }
}