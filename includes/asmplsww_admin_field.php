<?php
/**
 * @package Asm_Admin_Field
 * @version 1.2.7
 */

if (!class_exists('ASMPLSWW_Admin')) {
    class ASMPLSWW_Admin
    {
        public function __construct()
        {
            /** Hook callback function to Add Tab in Product option section */
            add_filter('woocommerce_product_data_tabs', 'asmplsww_admin_tab_add');
            function asmplsww_admin_tab_add($product_data_tabs)
            {
                $product_data_tabs['asmplsww-custom-tab'] = array(
                    'label' => __('Advanced Shipping Manager', 'asmplsww_text_domain'),
                    'target' => 'asmplsww_custom_product_data',
                );
                return $product_data_tabs;
            }

            /** Hook callback function to Add custom fields information */
            add_action('woocommerce_product_data_panels', 'asmplsww_admin_fields_add');
            function asmplsww_admin_fields_add()
            {
                global $woocommerce, $post;

                // id below must match target registered in above add_my_custom_product_data_tab function
                echo "<div id=\"asmplsww_custom_product_data\" class=\"panel woocommerce_options_panel\">";
                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_dimensions',
                        'label' => __('Dimensions', 'as_dimensions'),
                        'desc_tip' => 'true',
                        'description' => __('Enter the Dimension of package.', 'woocommerce')
                    )
                );

                $checked_free_shipping = '';
                $asmplsww_free_shipping = get_post_meta($post->ID, 'asmplsww_free_shipping', true);
                if ($asmplsww_free_shipping == 1) {
                    $checked_free_shipping = "checked=checked";
                }
                echo "<p class=\"form-field asmplsww_free_shipping \"><label>Free Shipping</label>";
                echo "<input type=\"checkbox\" id=\"asmplsww_free_shipping\" name=\"asmplsww_free_shipping\" value=\"1\"  $checked_free_shipping>";

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_free_shipping_method',
                        'label' => __('Free Shipping Method', 'asm_free_shipping_method'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Free Shipping Method', 'woocommerce')
                    )
                );

                $asmplsww_ship_alone_checked = '';
                $asmplsww_ship_alone = get_post_meta($post->ID, 'asmplsww_ship_alone', true);
                if ($asmplsww_ship_alone == 1) {
                    $asmplsww_ship_alone_checked = "checked=checked";
                }
                echo "<p class=\"form-field asmplsww_ship_alone \"><label>Ship Alone</label>";
                echo "<input type=\"checkbox\" id=\"asmplsww_ship_alone\" name=\"asmplsww_ship_alone\" value=\"1\"  $asmplsww_ship_alone_checked>";

                woocommerce_wp_textarea_input(
                    array(
                        'id' => 'asmplsww_flat_ship_rates',
                        'label' => __('Flat Ship Rates', 'asm_flat_ship_rates'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Flat Ship Rates', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_origin_zip',
                        'label' => __('Origin Zip', 'asm_origin_zip'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Origin Zip', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_number_boxes',
                        'label' => __('Number of Boxes', 'asmplsww_addons_number_boxes'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Number of Boxes', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_multi_box_weight',
                        'label' => __('Multi Box Weights', 'asm_multi_box_weight'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Multi Box Weights', 'woocommerce')
                    )
                );

                woocommerce_wp_textarea_input(
                    array(
                        'id' => 'asmplsww_multi_box_dimensions',
                        'label' => __('Multi Box Dimensions', 'asm_multi_box_dimensions'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Multi Box Dimensions', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_invalid_ship_methods',
                        'label' => __('Invalid Ship Methods', 'asm_invalid_ship_methods'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Invalid Ship Methods', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_markup',
                        'label' => __('Markup', 'asm_markup'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Markup', 'woocommerce')
                    )
                );

                $asmplsww_global_free_ship_exclusion_checked = '';
                $asmplsww_global_free_ship_exclusion = get_post_meta($post->ID, 'asmplsww_global_free_ship_exclusion', true);
                if ($asmplsww_global_free_ship_exclusion == 1) {
                    $asmplsww_global_free_ship_exclusion_checked = "checked=checked";
                }
                echo "<p class=\"form-field asm_global_free_ship_exclusion \"><label>Global Free Ship Exclusion</label>";
                echo "<input type=\"checkbox\" id=\"asmplsww_global_free_ship_exclusion\" name=\"asmplsww_global_free_ship_exclusion\" value=\"1\"  $asmplsww_global_free_ship_exclusion_checked>";

                woocommerce_wp_textarea_input(
                    array(
                        'id' => 'asmplsww_exclude_state',
                        'label' => __('Exclude States', 'asm_exclude_state'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Exclude States', 'woocommerce')
                    )
                );

                woocommerce_wp_textarea_input(
                    array(
                        'id' => 'asmplsww_exclude_countries',
                        'label' => __('Exclude Countries', 'asm_exclude_countries'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Exclude Countries', 'woocommerce')
                    )
                );

                echo "<h1 style='padding-left:10px;border-bottom: 1px solid #ccc;'>Optional Add-Ons</h1>";

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_item_points',
                        'label' => __('Item Points', 'asm_addons_item_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Item Points', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_multi_box_points',
                        'label' => __('Multi Box Points', 'asmplsww_addons_multi_box_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Item Points', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_bundled_qty',
                        'label' => __('Bundled Quantity', 'asmplsww_addons_bundled_qty'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Qty', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_bundled_weight',
                        'label' => __('Bundled Weight', 'asmplsww_addons_bundled_weight'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Weight', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_bundled_dimension',
                        'label' => __('Bundled Dimensions', 'asmplsww_addons_bundled_dimension'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Dimension', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_bundled_points',
                        'label' => __('Bundled Points', 'asmplsww_addons_bundled_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Bundled Points', 'woocommerce')
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => 'asmplsww_addons_process_time',
                        'label' => __('Processing Time', 'asmplsww_addons_process'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Process Time', 'woocommerce')
                    )
                );

                $asmplsww_addons_hazmat_checked = '';
                $asmplsww_addons_hazmat = get_post_meta($post->ID, 'asmplsww_addons_hazmat', true);
                if ($asmplsww_addons_hazmat == 1) {
                    $asmplsww_addons_hazmat_checked = "checked=checked";
                }
                echo "<p class=\"form-field asm_global_free_ship_exclusion \"><label>Hazmat</label>";
                echo "<input type=\"checkbox\" id=\"asmplsww_addons_hazmat\" name=\"asmplsww_addons_hazmat\" value=\"1\"  $asmplsww_addons_hazmat_checked>";

                woocommerce_wp_textarea_input(
                    array(
                        'id' => 'asmplsww_addons_options_weight_points',
                        'label' => __('Option Weight Points', 'asmplsww_addons_options_weight_points'),
                        'desc_tip' => 'true',
                        'description' => __('Enter Option Weight Points', 'woocommerce')
                    )
                );


                echo "</div>";


            }

            /** Hook callback function to save custom fields information */
            function asmplsww_admin_fields_save($post_id)
            {

                // Save Text Field
                $asmplsww_dimensions = $_POST['asmplsww_dimensions'];
                update_post_meta($post_id, 'asmplsww_dimensions', sanitize_text_field($asmplsww_dimensions));

                // Save Checkbox
                $asmplsww_free_shipping = isset($_POST['asmplsww_free_shipping']) ? true : false;
                update_post_meta($post_id, 'asmplsww_free_shipping', $asmplsww_free_shipping);

                // Save Hidden field
                $asmplsww_free_shipping_method = $_POST['asmplsww_free_shipping_method'];
                update_post_meta($post_id, 'asmplsww_free_shipping_method', sanitize_text_field($asmplsww_free_shipping_method));

                $asmplsww_ship_alone = isset($_POST['asmplsww_ship_alone']) ? true : false;
                update_post_meta($post_id, 'asmplsww_ship_alone', $asmplsww_ship_alone);

                $asmplsww_flat_ship_rates = $_POST['asmplsww_flat_ship_rates'];
                update_post_meta($post_id, 'asmplsww_flat_ship_rates', sanitize_textarea_field($asmplsww_flat_ship_rates));

                $asmplsww_origin_zip = $_POST['asmplsww_origin_zip'];
                update_post_meta($post_id, 'asmplsww_origin_zip', sanitize_text_field($asmplsww_origin_zip));

                $asmplsww_multi_box_weight = $_POST['asmplsww_multi_box_weight'];
                update_post_meta($post_id, 'asmplsww_multi_box_weight', sanitize_text_field($asmplsww_multi_box_weight));

                $asmplsww_multi_box_dimensions = $_POST['asmplsww_multi_box_dimensions'];
                update_post_meta($post_id, 'asmplsww_multi_box_dimensions', sanitize_text_field($asmplsww_multi_box_dimensions));

                $asmplsww_invalid_ship_methods = $_POST['asmplsww_invalid_ship_methods'];
                update_post_meta($post_id, 'asmplsww_invalid_ship_methods', sanitize_text_field($asmplsww_invalid_ship_methods));

                $asmplsww_markup = $_POST['asmplsww_markup'];
                update_post_meta($post_id, 'asmplsww_markup', sanitize_text_field($asmplsww_markup));

                $asmplsww_global_free_ship_exclusion = isset($_POST['asmplsww_global_free_ship_exclusion']) ? true : false;
                update_post_meta($post_id, 'asmplsww_global_free_ship_exclusion', $asmplsww_global_free_ship_exclusion);

                $asmplsww_exclude_state = $_POST['asmplsww_exclude_state'];
                update_post_meta($post_id, 'asmplsww_exclude_state', sanitize_textarea_field($asmplsww_exclude_state));

                $asmplsww_exclude_countries = $_POST['asmplsww_exclude_countries'];
                update_post_meta($post_id, 'asmplsww_exclude_countries', sanitize_textarea_field($asmplsww_exclude_countries));

                $asmplsww_addons_number_boxes = $_POST['asmplsww_addons_number_boxes'];
                update_post_meta($post_id, 'asmplsww_addons_number_boxes', sanitize_text_field($asmplsww_addons_number_boxes));

                $asmplsww_addons_item_points = $_POST['asmplsww_addons_item_points'];
                update_post_meta($post_id, 'asmplsww_addons_item_points', sanitize_text_field($asmplsww_addons_item_points));

                $asmplsww_addons_multi_box_points = $_POST['asmplsww_addons_multi_box_points'];
                update_post_meta($post_id, 'asmplsww_addons_multi_box_points', sanitize_text_field($asmplsww_addons_multi_box_points));

                $asmplsww_addons_bundled_qty = $_POST['asmplsww_addons_bundled_qty'];
                update_post_meta($post_id, 'asmplsww_addons_bundled_qty', sanitize_text_field($asmplsww_addons_bundled_qty));

                $asmplsww_addons_bundled_weight = $_POST['asmplsww_addons_bundled_weight'];
                update_post_meta($post_id, 'asmplsww_addons_bundled_weight', sanitize_text_field($asmplsww_addons_bundled_weight));

                $asmplsww_addons_bundled_dimension = $_POST['asmplsww_addons_bundled_dimension'];
                update_post_meta($post_id, 'asmplsww_addons_bundled_dimension', sanitize_text_field($asmplsww_addons_bundled_dimension));

                $asmplsww_addons_bundled_points = $_POST['asmplsww_addons_bundled_points'];
                update_post_meta($post_id, 'asmplsww_addons_bundled_points', sanitize_text_field($asmplsww_addons_bundled_points));

                $asmplsww_addons_process_time = $_POST['asmplsww_addons_process_time'];
                update_post_meta($post_id, 'asmplsww_addons_process_time', sanitize_text_field($asmplsww_addons_process_time));

                $asmplsww_addons_hazmat = isset($_POST['asmplsww_addons_hazmat']) ? true : false;
                update_post_meta($post_id, 'asmplsww_addons_hazmat', $asmplsww_addons_hazmat);

                $asmplsww_addons_options_weight_points = $_POST['asmplsww_addons_options_weight_points'];
                update_post_meta($post_id, 'asmplsww_addons_options_weight_points', sanitize_textarea_field($asmplsww_addons_options_weight_points));


            }

            add_action('woocommerce_process_product_meta', 'asmplsww_admin_fields_save');

        }
    }

    $shippingField = new ASMPLSWW_Admin;
}