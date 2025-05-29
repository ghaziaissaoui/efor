<?php
defined('ABSPATH') or die('Please don&rsquo;t call the plugin directly. Thanks :)');

//WooCommerce
//=================================================================================================
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('woocommerce/woocommerce.php')) {


    //noindex WooCommerce page
    if ('1' == seopress_get_toggle_option('woocommerce')) {
        //Cart page
        function seopress_woocommerce_cart_page_no_index_option() {
            $seopress_woocommerce_cart_page_no_index_option = get_option('seopress_pro_option_name');
            if ( ! empty($seopress_woocommerce_cart_page_no_index_option)) {
                foreach ($seopress_woocommerce_cart_page_no_index_option as $key => $seopress_woocommerce_cart_page_no_index_value) {
                    $options[$key] = $seopress_woocommerce_cart_page_no_index_value;
                }
                if (isset($seopress_woocommerce_cart_page_no_index_option['seopress_woocommerce_cart_page_no_index'])) {
                    return $seopress_woocommerce_cart_page_no_index_option['seopress_woocommerce_cart_page_no_index'];
                }
            }
        }
        //Checkout page
        function seopress_woocommerce_checkout_page_no_index_option() {
            $seopress_woocommerce_checkout_page_no_index_option = get_option('seopress_pro_option_name');
            if ( ! empty($seopress_woocommerce_checkout_page_no_index_option)) {
                foreach ($seopress_woocommerce_checkout_page_no_index_option as $key => $seopress_woocommerce_checkout_page_no_index_value) {
                    $options[$key] = $seopress_woocommerce_checkout_page_no_index_value;
                }
                if (isset($seopress_woocommerce_checkout_page_no_index_option['seopress_woocommerce_checkout_page_no_index'])) {
                    return $seopress_woocommerce_checkout_page_no_index_option['seopress_woocommerce_checkout_page_no_index'];
                }
            }
        }
        //Customer Account
        function seopress_woocommerce_customer_account_page_no_index_option() {
            $seopress_woocommerce_customer_account_page_no_index_option = get_option('seopress_pro_option_name');
            if ( ! empty($seopress_woocommerce_customer_account_page_no_index_option)) {
                foreach ($seopress_woocommerce_customer_account_page_no_index_option as $key => $seopress_woocommerce_customer_account_page_no_index_value) {
                    $options[$key] = $seopress_woocommerce_customer_account_page_no_index_value;
                }
                if (isset($seopress_woocommerce_customer_account_page_no_index_option['seopress_woocommerce_customer_account_page_no_index'])) {
                    return $seopress_woocommerce_customer_account_page_no_index_option['seopress_woocommerce_customer_account_page_no_index'];
                }
            }
        }
    }

    add_filter('seopress_titles_noindex_bypass', 'seopress_pro_titles_noindex_bypass');
    function seopress_pro_titles_noindex_bypass($seopress_titles_noindex) {
        if ('1' == seopress_get_toggle_option('woocommerce') && function_exists('is_cart') && function_exists('seopress_woocommerce_cart_page_no_index_option') && (is_cart() && seopress_woocommerce_cart_page_no_index_option())) { //IS WooCommerce Cart page
            $seopress_titles_noindex = seopress_woocommerce_cart_page_no_index_option();
        } elseif ('1' == seopress_get_toggle_option('woocommerce') && function_exists('is_checkout') && function_exists('seopress_woocommerce_checkout_page_no_index_option') && (is_checkout() && seopress_woocommerce_checkout_page_no_index_option())) { //IS WooCommerce Checkout page
            $seopress_titles_noindex = seopress_woocommerce_checkout_page_no_index_option();
        } elseif ('1' == seopress_get_toggle_option('woocommerce') && function_exists('is_account_page') && function_exists('seopress_woocommerce_customer_account_page_no_index_option') && (is_account_page() && seopress_woocommerce_customer_account_page_no_index_option())) { //IS WooCommerce Customer account pages
            $seopress_titles_noindex = seopress_woocommerce_customer_account_page_no_index_option();
        } elseif ('1' == seopress_get_toggle_option('woocommerce') && function_exists('is_wc_endpoint_url') && function_exists('seopress_woocommerce_customer_account_page_no_index_option') && (is_wc_endpoint_url() && seopress_woocommerce_customer_account_page_no_index_option())) { //IS WooCommerce Customer account pages
            $seopress_titles_noindex = seopress_woocommerce_customer_account_page_no_index_option();
        }

        return $seopress_titles_noindex;
    }


    if (is_singular('product')) {
        //OG Price
        function seopress_woocommerce_product_og_price_option() {
            $seopress_woocommerce_product_og_price_option = get_option('seopress_pro_option_name');
            if ( ! empty($seopress_woocommerce_product_og_price_option)) {
                foreach ($seopress_woocommerce_product_og_price_option as $key => $seopress_woocommerce_product_og_price_value) {
                    $options[$key] = $seopress_woocommerce_product_og_price_value;
                }
                if (isset($seopress_woocommerce_product_og_price_option['seopress_woocommerce_product_og_price'])) {
                    return $seopress_woocommerce_product_og_price_option['seopress_woocommerce_product_og_price'];
                }
            }
        };

        function seopress_woocommerce_product_og_price_hook() {
            if (seopress_woocommerce_product_og_price_option() == '1') {
                $product = wc_get_product(get_the_id());

                /*sale price*/
                $get_sale_price = '';
                if (isset($product) && method_exists($product, 'get_sale_price')) {
                    $get_sale_price = $product->get_sale_price();
                }

                /*sale price with tax (regular price as fallback if not available)*/
                $get_sale_price_with_tax = '';
                if (isset($product) && method_exists($product, 'get_price') && function_exists('wc_get_price_including_tax')) {
                    $get_sale_price_with_tax = wc_get_price_including_tax($product, ['price' => $get_sale_price]);
                }

                $seopress_social_og_price = '<meta property="product:price:amount" content="' . $get_sale_price_with_tax . '">';

                echo $seopress_social_og_price . "\n";
            }
        }
        add_action('wp_head', 'seopress_woocommerce_product_og_price_hook', 1);

        //OG Currency
        function seopress_woocommerce_product_og_currency_option() {
            $seopress_woocommerce_product_og_currency_option = get_option('seopress_pro_option_name');
            if ( ! empty($seopress_woocommerce_product_og_currency_option)) {
                foreach ($seopress_woocommerce_product_og_currency_option as $key => $seopress_woocommerce_product_og_currency_value) {
                    $options[$key] = $seopress_woocommerce_product_og_currency_value;
                }
                if (isset($seopress_woocommerce_product_og_currency_option['seopress_woocommerce_product_og_currency'])) {
                    return $seopress_woocommerce_product_og_currency_option['seopress_woocommerce_product_og_currency'];
                }
            }
        }

        function seopress_woocommerce_product_og_currency_hook() {
            if (seopress_woocommerce_product_og_currency_option() == '1') {
                $seopress_social_og_currency = '<meta property="product:price:currency" content="' . get_woocommerce_currency() . '">';

                echo $seopress_social_og_currency . "\n";
            }
        }
        add_action('wp_head', 'seopress_woocommerce_product_og_currency_hook', 1);
    }

    //WooCommerce Structured data
    function seopress_woocommerce_schema_output_option() {
        $seopress_woocommerce_schema_output_option = get_option('seopress_pro_option_name');
        if ( ! empty($seopress_woocommerce_schema_output_option)) {
            foreach ($seopress_woocommerce_schema_output_option as $key => $seopress_woocommerce_schema_output_value) {
                $options[$key] = $seopress_woocommerce_schema_output_value;
            }
            if (isset($seopress_woocommerce_schema_output_option['seopress_woocommerce_schema_output'])) {
                return $seopress_woocommerce_schema_output_option['seopress_woocommerce_schema_output'];
            }
        }
    }
    function seopress_woocommerce_schema_output_hook() {
        if (seopress_woocommerce_schema_output_option() == '1') {
            if (function_exists('WC')) {
                remove_action('wp_footer', [ WC()->structured_data, 'output_structured_data' ], 10);
                remove_action('woocommerce_email_order_details', [ WC()->structured_data, 'output_email_structured_data' ], 30);
            }
        }
    }
    add_action('wp_head', 'seopress_woocommerce_schema_output_hook');

    //WooCommerce Breadcrulbs Structured data
    function seopress_woocommerce_schema_breadcrumbs_output_option() {
        $seopress_woocommerce_schema_breadcrumbs_output_option = get_option('seopress_pro_option_name');
        if ( ! empty($seopress_woocommerce_schema_breadcrumbs_output_option)) {
            foreach ($seopress_woocommerce_schema_breadcrumbs_output_option as $key => $seopress_woocommerce_schema_breadcrumbs_output_value) {
                $options[$key] = $seopress_woocommerce_schema_breadcrumbs_output_value;
            }
            if (isset($seopress_woocommerce_schema_breadcrumbs_output_option['seopress_woocommerce_schema_breadcrumbs_output'])) {
                return $seopress_woocommerce_schema_breadcrumbs_output_option['seopress_woocommerce_schema_breadcrumbs_output'];
            }
        }
    }
    if (seopress_woocommerce_schema_breadcrumbs_output_option() == '1') {
        add_filter('woocommerce_structured_data_breadcrumblist', '__return_false');
    }

    //WooCommerce Meta tag generator
    function seopress_woocommerce_meta_generator_option() {
        $seopress_woocommerce_meta_generator_option = get_option('seopress_pro_option_name');
        if ( ! empty($seopress_woocommerce_meta_generator_option)) {
            foreach ($seopress_woocommerce_meta_generator_option as $key => $seopress_woocommerce_meta_generator_value) {
                $options[$key] = $seopress_woocommerce_meta_generator_value;
            }
            if (isset($seopress_woocommerce_meta_generator_option['seopress_woocommerce_meta_generator'])) {
                return $seopress_woocommerce_meta_generator_option['seopress_woocommerce_meta_generator'];
            }
        }
    }
    if (seopress_woocommerce_meta_generator_option() == '1') {
        remove_action('get_the_generator_html', 'wc_generator_tag', 10, 2);
        remove_action('get_the_generator_xhtml', 'wc_generator_tag', 10, 2);
    }
}
