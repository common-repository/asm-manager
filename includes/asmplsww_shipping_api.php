<?php
/**
 * @package ASM Shipping Api
 * @version 1.2.7
 */
/*
*/
add_filter('http_request_timeout', 'ASMPLSWW_timeout_extend');
function ASMPLSWW_timeout_extend($time)
{
    return 500;
}

//shipping method on
if (!class_exists('ASMPLSWW_Shipping_Api')) {
    class ASMPLSWW_Shipping_Api
    {
        private static $ch;
        private static $output;
        private static $url = 'https://www.advancedshippingmanager.com/clients/web_services/asm_web_service.php';

        public static function isValidXml($content)
        {
            $content = trim($content);
            if (empty($content)) {
                return false;
            }

            if (stripos($content, '<!DOCTYPE html>') !== false) {
                return false;
            }

            libxml_use_internal_errors(true);
            simplexml_load_string($content);
            $errors = libxml_get_errors();
            libxml_clear_errors();

            return empty($errors);
        }

        public static function asmplswwGetShippingValue($xml_data)
        {
            $data = wp_remote_retrieve_body(wp_remote_post(self::$url, array('body' => $xml_data)));
            if (self::isValidXml($data)) {
                self::$output = json_decode(json_encode(simplexml_load_string($data)), true);
                if (self::$output) {
                    return self::$output['AvailableMethods']['ShippingMethod'];
                } else {
                    return;
                }
            }
        }

    }
}