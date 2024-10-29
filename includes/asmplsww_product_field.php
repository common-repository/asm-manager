<?php
/**
 * @package ASM product field
 * @version 1.2.7
 */

if (!class_exists('ASMPLSWW_Shipping_Field')) {
    class ASMPLSWW_Admin_Field
    {
        public function __construct()
        {
            add_filter('woocommerce_product_data_tabs', 'add_asm_product_data_tab');
            function add_asm_product_data_tab($product_data_tabs)
            {
                $product_data_tabs['my-custom-tab'] = array(
                    'label' => __('Advanced Shipping Manager', 'my_text_domain'),
                    'target' => 'my_custom_product_data',
                );
                return $product_data_tabs;
            }

            add_action('woocommerce_product_data_panels', 'add_asm_product_data_fields');
            function add_asm_product_data_fields()
            {
                global $woocommerce, $post;

                // id below must match target registered in above add_my_custom_product_data_tab function
                echo "<div id=\"my_custom_product_data\" class=\"panel woocommerce_options_panel\">";
                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_dimensions',
                        'label' => __('Dimensions', 'as_dimensions'),
                        'desc_tip' => 'true',
                        'description' => __('Enter the Dimension of package.', 'woocommerce')
                    )
                );

                $_asm_free_shipping = get_post_meta($post->ID, '_asm_free_shipping', true);
                if ($_asm_free_shipping == 1) {
                    $checked_free_shipping = "checked=checked";
                }
                echo "<p class=\"form-field _asm_free_shipping \"><label>Free Shipping</label>";
                echo "<input type=\"checkbox\" id=\"_asm_free_shipping\" name=\"_asm_free_shipping\" value=\"1\"  $checked_free_shipping>";

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_free_shipping_method',
                        'label' => __('Free Shipping Method', 'asm_free_shipping_method'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Free Shipping Method', 'woocommerce')
                    )
                );


                $_asm_ship_alone = get_post_meta($post->ID, '_asm_ship_alone', true);
                if ($_asm_ship_alone == 1) {
                    $checked_asm_ship_alone = "checked=checked";
                }
                echo "<p class=\"form-field _asm_ship_alone \"><label>Ship Alone</label>";
                echo "<input type=\"checkbox\" id=\"_asm_ship_alone\" name=\"_asm_ship_alone\" value=\"1\"  $checked_asm_ship_alone>";

                woocommerce_wp_textarea_input(
                    array(
                        'id' => '_asm_flat_ship_rates',
                        'label' => __('Flat Ship Rates', 'asm_flat_ship_rates'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Flat Ship Rates', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_origin_zip',
                        'label' => __('Origin Zip', 'asm_origin_zip'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Origin Zip', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_number_boxes',
                        'label' => __('Number of Boxes', '_asm_addons_number_boxes'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Number of Boxes', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_multi_box_weight',
                        'label' => __('Multi Box Weights', 'asm_multi_box_weight'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Multi Box Weights', 'woocommerce')
                    )
                );

                woocommerce_wp_textarea_input(
                    array(
                        'id' => '_asm_multi_box_dimensions',
                        'label' => __('Multi Box Dimensions', 'asm_multi_box_dimensions'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Multi Box Dimensions', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_invalid_ship_methods',
                        'label' => __('Invalid Ship Methods', 'asm_invalid_ship_methods'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Invalid Ship Methods', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_markup',
                        'label' => __('Markup', 'asm_markup'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Markup', 'woocommerce')
                    )
                );

                $_asm_global_free_ship_exclusion = get_post_meta($post->ID, '_asm_global_free_ship_exclusion', true);
                if ($_asm_global_free_ship_exclusion == 1) {
                    $checked_asm_global_free_ship_exclusion = "checked=checked";
                }
                echo "<p class=\"form-field asm_global_free_ship_exclusion \"><label>Global Free Ship Exclusion</label>";
                echo "<input type=\"checkbox\" id=\"_asm_global_free_ship_exclusion\" name=\"_asm_global_free_ship_exclusion\" value=\"1\"  $checked_asm_global_free_ship_exclusion>";

                woocommerce_wp_textarea_input(
                    array(
                        'id' => '_asm_exclude_state',
                        'label' => __('Exclude States', 'asm_exclude_state'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Exclude States', 'woocommerce')
                    )
                );

                woocommerce_wp_textarea_input(
                    array(
                        'id' => '_asm_exclude_countries',
                        'label' => __('Exclude Countries', 'asm_exclude_countries'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Exclude Countries', 'woocommerce')
                    )
                );

                echo "<h1 style='padding-left:10px;border-bottom: 1px solid #ccc;'>Optional Add-Ons</h1>";

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_item_points',
                        'label' => __('Item Points', 'asm_addons_item_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Item Points', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_multi_box_points',
                        'label' => __('Multi Box Points', '_asm_addons_multi_box_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Item Points', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_bundled_qty',
                        'label' => __('Bundled Quantity', '_asm_addons_bundled_qty'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Qty', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_bundled_weight',
                        'label' => __('Bundled Weight', '_asm_addons_bundled_weight'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Weight', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_bundled_dimension',
                        'label' => __('Bundled Dimensions', '_asm_addons_bundled_dimension'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Dimension', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_bundled_points',
                        'label' => __('Bundled Points', '_asm_addons_bundled_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Points', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_asm_addons_process_time',
                        'label' => __('Processing Time', '_asm_addons_process'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Process Time', 'woocommerce')
                    )
                );

                $_asm_addons_hazmat = get_post_meta($post->ID, '_asm_addons_hazmat', true);
                if ($_asm_addons_hazmat == 1) {
                    $checked_asm_addons_hazmat = "checked=checked";
                }
                echo "<p class=\"form-field asm_global_free_ship_exclusion \"><label>Hazmat</label>";
                echo "<input type=\"checkbox\" id=\"_asm_addons_hazmat\" name=\"_asm_addons_hazmat\" value=\"1\"  $checked_asm_addons_hazmat>";

                woocommerce_wp_textarea_input(
                    array(
                        'id' => '_asm_addons_options_weight_points',
                        'label' => __('Option Weight Points', '_asm_addons_options_weight_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Option Weight Points', 'woocommerce')
                    )
                );


                echo "</div>";
            }

            /** Hook callback function to save custom fields information */
            function save_asm_product_data_fields($post_id)
            {
                // Save Text Field
                $_asm_dimensions = $_POST['_asm_dimensions'];
                update_post_meta($post_id, '_asm_dimensions', sanitize_text_field($_asm_dimensions));

                // Save Checkbox
                $_asm_free_shipping = isset($_POST['_asm_free_shipping']) ? true : false;
                update_post_meta($post_id, '_asm_free_shipping', $_asm_free_shipping);

                // Save Hidden field
                $_asm_free_shipping_method = $_POST['_asm_free_shipping_method'];
                update_post_meta($post_id, '_asm_free_shipping_method', sanitize_text_field($_asm_free_shipping_method));

                $_asm_ship_alone = isset($_POST['_asm_ship_alone']) ? true : false;
                update_post_meta($post_id, '_asm_ship_alone', $_asm_ship_alone);

                $_asm_flat_ship_rates = $_POST['_asm_flat_ship_rates'];
                update_post_meta($post_id, '_asm_flat_ship_rates', sanitize_textarea_field($_asm_flat_ship_rates));

                $_asm_origin_zip = $_POST['_asm_origin_zip'];
                update_post_meta($post_id, '_asm_origin_zip', sanitize_text_field($_asm_origin_zip));

                $_asm_multi_box_weight = $_POST['_asm_multi_box_weight'];
                update_post_meta($post_id, '_asm_multi_box_weight', sanitize_text_field($_asm_multi_box_weight));

                $_asm_multi_box_dimensions = $_POST['_asm_multi_box_dimensions'];
                update_post_meta($post_id, '_asm_multi_box_dimensions', sanitize_text_field($_asm_multi_box_dimensions));

                $_asm_invalid_ship_methods = $_POST['_asm_invalid_ship_methods'];
                update_post_meta($post_id, '_asm_invalid_ship_methods', sanitize_text_field($_asm_invalid_ship_methods));

                $_asm_markup = $_POST['_asm_markup'];
                update_post_meta($post_id, '_asm_markup', sanitize_text_field($_asm_markup));

                $_asm_global_free_ship_exclusion = isset($_POST['_asm_global_free_ship_exclusion']) ? true : false;
                update_post_meta($post_id, '_asm_global_free_ship_exclusion', $_asm_global_free_ship_exclusion);

                $_asm_exclude_state = $_POST['_asm_exclude_state'];
                update_post_meta($post_id, '_asm_exclude_state', sanitize_textarea_field($_asm_exclude_state));

                $_asm_exclude_countries = $_POST['_asm_exclude_countries'];
                update_post_meta($post_id, '_asm_exclude_countries', sanitize_textarea_field($_asm_exclude_countries));

                $_asm_addons_number_boxes = $_POST['_asm_addons_number_boxes'];
                update_post_meta($post_id, '_asm_addons_number_boxes', sanitize_text_field($_asm_addons_number_boxes));

                $_asm_addons_item_points = $_POST['_asm_addons_item_points'];
                update_post_meta($post_id, '_asm_addons_item_points', sanitize_text_field($_asm_addons_item_points));

                $_asm_addons_multi_box_points = $_POST['_asm_addons_multi_box_points'];
                update_post_meta($post_id, '_asm_addons_multi_box_points', sanitize_text_field($_asm_addons_multi_box_points));

                $_asm_addons_bundled_qty = $_POST['_asm_addons_bundled_qty'];
                update_post_meta($post_id, '_asm_addons_bundled_qty', sanitize_text_field($_asm_addons_bundled_qty));

                $_asm_addons_bundled_weight = $_POST['_asm_addons_bundled_weight'];
                update_post_meta($post_id, '_asm_addons_bundled_weight', sanitize_text_field($_asm_addons_bundled_weight));

                $_asm_addons_bundled_dimension = $_POST['_asm_addons_bundled_dimension'];
                update_post_meta($post_id, '_asm_addons_bundled_dimension', sanitize_text_field($_asm_addons_bundled_dimension));

                $_asm_addons_bundled_points = $_POST['_asm_addons_bundled_points'];
                update_post_meta($post_id, '_asm_addons_bundled_points', sanitize_text_field($_asm_addons_bundled_points));

                $_asm_addons_process_time = $_POST['_asm_addons_process_time'];
                update_post_meta($post_id, '_asm_addons_process_time', sanitize_text_field($_asm_addons_process_time));

                $_asm_addons_hazmat = isset($_POST['_asm_addons_hazmat']) ? true : false;
                update_post_meta($post_id, '_asm_addons_hazmat', $_asm_addons_hazmat);

                $_asm_addons_options_weight_points = $_POST['_asm_addons_options_weight_points'];
                update_post_meta($post_id, '_asm_addons_options_weight_points', sanitize_textarea_field($_asm_addons_options_weight_points));
            }

            add_action('woocommerce_process_product_meta', 'save_asm_product_data_fields');
        }
    }

    $shippingField = new Asm_Shipping_Field;
}