<?php
/**
 * @package ASM Shipping Api
 * @version 1.2.7
 */
global $woocommerce;

if (!function_exists('asmCap'))   {
	function asmCap($getcmeta, $index) {
		return isset($getcmeta[$index], $getcmeta[$index]['0']) ? $getcmeta[$index]['0'] : '';
	}
}

$items = $woocommerce->cart->get_cart();

//Box Weight
$boxTotalWeight = 0;
$TaxableProductPrice = 0;
$NonTaxableProductPrice = 0;

foreach ($items as $item => $values) {
    //Product is varibale or simple so fetch value as per
    if ($values['variation_id']) {
        $_product = wc_get_product($values['variation_id']);
    } elseif
    ($values['product_id'] == "") {
        $_product = wc_get_product($values['data']->get_id());
    } else {
        $_product = wc_get_product($values['product_id']);
    }

// Total Weight
    if ($_product->get_weight() != "") {
        $boxTotalWeight += ($_product->get_weight() * $values['quantity']);
    }

//check taxbale
    if ($_product->is_taxable()) {
        $TaxableProductPrice += ($_product->get_price() * $values['quantity']);
    }
//check Nontaxbale
    if ($_product->is_taxable() == false) {
        $NonTaxableProductPrice += ($_product->get_price() * $values['quantity']);
    }
// check taxable value and set amount
}

//Get Coupon Value
$coupons_amount = 0;
if (isset($woocommerce->cart->get_applied_coupons()['0']) && $woocommerce->cart->get_applied_coupons()['0'] != "") {
    $coupons_obj = new WC_Coupon($woocommerce->cart->get_applied_coupons()['0']);
    $coupons_amount = $woocommerce->cart->get_discount_total();
}

//Get Coupon Value
if (wc_tax_enabled() == true) {
    $TotalTaxable = (($woocommerce->cart->get_subtotal()) - $coupons_amount);
}

//Get Taxable Value
if ($TaxableProductPrice != "") {
    $TotalTaxbaleProductPrice = $TaxableProductPrice;
}

$domainname = '';
$pieces = parse_url(home_url());
$domain = isset($pieces['host']) ? $pieces['host'] : '';
if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    $domainname = strstr($regs['domain'], '.', true);
}

//<StoreIndicator>getfoundsocial</StoreIndicator>
$xml_data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <ShippingQuery>
                    <AccountIdentifier>BD8h3Dhs7qj18shr2p</AccountIdentifier>
                    <StoreIndicator>" . $domainname . "</StoreIndicator>
                    <Total>" . ($woocommerce->cart->cart_contents_total + $coupons_amount) . "</Total>
                    <TotalTaxable>" . $TotalTaxbaleProductPrice . "</TotalTaxable>
                    <TotalNonTaxable>" . $NonTaxableProductPrice . "</TotalNonTaxable>
                    <TotalWeight>" . $boxTotalWeight . "</TotalWeight>
                    <ShipToAddress>
                        <Address1><![CDATA[" . $woocommerce->customer->get_shipping_address_1() . "]]></Address1>
                        <Address2><![CDATA[" . $woocommerce->customer->get_shipping_address_2() . "]]></Address2>
                        <City><![CDATA[" . $woocommerce->customer->get_shipping_city() . "]]></City>
                        <State>" . $woocommerce->customer->get_shipping_state() . "</State>
                        <ZipCode>" . $woocommerce->customer->get_shipping_postcode() . "</ZipCode>
                        <Country>" . $woocommerce->customer->get_shipping_country() . "</Country>
                    </ShipToAddress>
                    <Products>";

foreach ($items as $item => $values) {
    //Product is varibale or simple so fetch value as per
    if (isset($values['variation_id']) && $values['variation_id'] > 0) {
        $_product = wc_get_product($values['variation_id']);
        $getcmeta = get_post_meta($values['product_id']);
    } elseif ($values['product_id'] == "") {
        $_product = wc_get_product($values['data']->get_id());
        $getcmeta = get_post_meta($values['data']->get_id());
    } else {
        $_product = wc_get_product($values['product_id']);
        $getcmeta = get_post_meta($values['product_id']);
    }

    $color = isset($values['variation'], $values['variation']['attribute_pa_color']) ? $values['variation']['attribute_pa_color'] : '';
    $size = isset($values['variation'], $values['variation']['attribute_pa_size']) ? $values['variation']['attribute_pa_size'] : '';

    if ($color != "") {
        $colorSize = "<Option type=\"Size\"><![CDATA[" . ucfirst($size) . "]]></Option>";
        $colorSize .= "<Option type=\"Color\"><![CDATA[" . ucfirst($color) . "]]></Option>";
    } else {
        $colorSize = "";
    }

    $product_tags = get_the_terms( $values['product_id'], 'product_tag' );
    $product_tags_array = array();
    if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ){
        foreach ( $product_tags as $product_tag ) {
            $product_tags_array[] = $product_tag->name;
        }
    }

    $xml_data .= "<Product>";
    $xml_data .= "<Code><![CDATA[" . $_product->get_sku() . "]]></Code>
                        <Qty>" . $values['quantity'] . "</Qty>
                        <UnitPrice>" . $_product->get_price() . "</UnitPrice>
                        $colorSize
                            <Attributes>
                                <Name><![CDATA[" . $_product->get_name() . "]]></Name>                                
                                <Price>" . $_product->get_regular_price() . "</Price>
                                <SalePrice>" . $_product->get_sale_price() . "</SalePrice>
                                <ShipWeight>" . $_product->get_weight() . "</ShipWeight>                             
                                <Taxable>" . ($_product->get_tax_status() == 'taxable' ? 'Y' : 'N') . "</Taxable>
                                <GiftCertDownloadable>N</GiftCertDownloadable>
                                <Dimensions>" . asmCap($getcmeta, 'asmplsww_dimensions') . "</Dimensions>
                                <FreeShip>" . (asmCap($getcmeta, 'asmplsww_free_shipping') == 1 ? 'Y' : 'N') . "</FreeShip>
                                <FreeShipMethods>" . asmCap($getcmeta, 'asmplsww_free_shipping_method') . "</FreeShipMethods>
                                <ShipAlone>" . (asmCap($getcmeta, 'asmplsww_ship_alone') == 1 ? 'Y' : 'N') . "</ShipAlone>
                                <FlatShipRates><![CDATA[" . asmCap($getcmeta, 'asmplsww_flat_ship_rates') . "]]></FlatShipRates>
                                <OriginZip>" . asmCap($getcmeta, 'asmplsww_origin_zip') . "</OriginZip>
                                <MultipleBox>" . asmCap($getcmeta, 'asmplsww_addons_number_boxes') . "</MultipleBox>
                                <MultipleBoxWeights>" . asmCap($getcmeta, 'asmplsww_multi_box_weight') . "</MultipleBoxWeights>
                                <MultipleBoxDimensions><![CDATA[" . asmCap($getcmeta, 'asmplsww_multi_box_dimensions') . "]]></MultipleBoxDimensions>
                                <MultipleBoxPoints>" . asmCap($getcmeta, 'asmplsww_addons_multi_box_points') . "</MultipleBoxPoints>
                                <InvalidMethods>" . asmCap($getcmeta, 'asmplsww_invalid_ship_methods') . "</InvalidMethods>
                                <Markup>" . asmCap($getcmeta, 'asmplsww_markup') . "</Markup>
                                <ItemPoints>" . asmCap($getcmeta, 'asmplsww_addons_item_points') . "</ItemPoints>
                                <BundledQty>" . asmCap($getcmeta, 'asmplsww_addons_bundled_qty') . "</BundledQty>      
                                <BundledWeight>" . asmCap($getcmeta, 'asmplsww_addons_bundled_weight') . "</BundledWeight>
                                <BundledDimensions>" . asmCap($getcmeta, 'asmplsww_addons_bundled_dimension') . "</BundledDimensions>
                                <BundledPoints>" . asmCap($getcmeta, 'asmplsww_addons_bundled_points') . "</BundledPoints>
                                <ExcludeFromFreeShip>" . (asmCap($getcmeta, 'asmplsww_global_free_ship_exclusion') == 1 ? 'Y' : 'N') . "</ExcludeFromFreeShip>
                                <ProcessTime>" . asmCap($getcmeta, 'asmplsww_addons_process_time') . "</ProcessTime>
                                <InvalidStates>" . asmCap($getcmeta, 'asmplsww_exclude_state') . "</InvalidStates>
                                <InvalidCountries>" . asmCap($getcmeta, 'asmplsww_exclude_countries') . "</InvalidCountries>
                                <HazMat>" . (asmCap($getcmeta, 'asmplsww_addons_hazmat') == 1 ? 'Y' : 'N') . "</HazMat>
                                <OptionsWeightPoints>" . asmCap($getcmeta, 'asmplsww_addons_options_weight_points') . "</OptionsWeightPoints>                             
                                <ProductTags>" . implode (", ", $product_tags_array) . "</ProductTags>                             
                            </Attributes>
                          </Product>";
}

$xml_data .= "</Products>
                <CouponCode>" . (isset($woocommerce->cart->get_applied_coupons()['0']) ? $woocommerce->cart->get_applied_coupons()['0'] : '') . "</CouponCode>
                <CouponValue>" . $coupons_amount . "</CouponValue>
                </ShippingQuery>";
