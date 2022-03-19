<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly /** 



/*



* Plugin Name: PizzaPOOL



* Plugin URI: https://github.com/InsightPro



* Description: Let your buyers to choose if they are ordering for delivery or pickup or dine in on chosen date and time (Need to have Woocommerce installed first). 



* Version: 1.0.0



* Author: InsightPro 



* Author URI: https://github.com/InsightPro 



* Text Domain: insightpro_restaurant



* Domain Path: /languages



* License: GPL2 



*/ 

/**
* Remove payment methods in woocommerce
*/
add_filter( 'woocommerce_available_payment_gateways' , 'insight_pro_change_payment_gateway', 20, 1);

function insight_pro_change_payment_gateway( $gateways ){	
	
    $stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);
	$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);

    if( $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein' ){
         // then unset the 'cod' key (cod is the unique id of COD Gateway)
         unset( $gateways['cod'] );
    }
    return $gateways;
}



//////////////////////////////////////////////////////////////////////////////////////////
 add_filter( 'woocommerce_get_price_html', 'cw_change_product_price_display', 10, 2 );
  //add_filter( 'woocommerce_cart_item_price', 'cw_change_product_price_display', 10, 2 );
function cw_change_product_price_display( $price, $product) {
	global $product, $woocommerce, $post;
	$currency = get_woocommerce_currency_symbol();
    $defferent_price = $product->get_meta( '_different_price_custom_field' );
    $dinein_price = number_format((float)$product->get_meta('_dinein_price_custom_field'), 2);
    $takeaway_price = number_format((float)$product->get_meta('_takeaway_price_custom_field'), 2); 
    $delivery_price = number_format((float)$product->get_meta('_delivery_price_custom_field'), 2);
    $price_arr = array($dinein_price, $takeaway_price, $delivery_price);
    sort($price_arr);

    if ($defferent_price == 'yes') {
    	
	    $price1 = $price_arr[0].$currency.' - '.$price_arr[2]. $currency .' Depending on order type';
	    return $price1;
    }else{
	    //$price .= '';
	    return $price;
    	
    }



  }



/**********************************************************************************/
add_action( 'woocommerce_before_add_to_cart_form', 'production_time', 11 ); 
function production_time() {
    global $product, $woocommerce, $post;

	$currency = get_woocommerce_currency_symbol();
    $defferent_price = $product->get_meta( '_different_price_custom_field' );
    $dinein_price = number_format($product->get_meta('_dinein_price_custom_field'), 2);
    $takeaway_price = number_format($product->get_meta('_takeaway_price_custom_field'), 2); 
    $delivery_price = number_format($product->get_meta('_delivery_price_custom_field'), 2); 

    if ($defferent_price == 'yes') {

    	echo '<p class="ri ri-clock"><strong>This Product has defferent order Prices</strong></p>';
	    if ( ! empty($dinein_price) ) {
	        echo '<h4 class="ri ri-clock">' . sprintf( __( ' Dine-in Price: %s', 'woocommerce' ), $dinein_price ) .$currency. '</h4>';
	    }

	    if ( ! empty($takeaway_price) ) {
	        echo '<h4 class="ri ri-clock">' . sprintf( __( ' Takeaway Price: %s', 'woocommerce' ), $takeaway_price ) .$currency. '</h4>';
	    }

	    if ( ! empty($delivery_price) ) {
	        echo '<h4 class="ri ri-clock">' . sprintf( __( ' On Delivery Price: %s', 'woocommerce' ), $delivery_price ) .$currency. '</h4>';
	    }
    }
}


/************************************************************************************/

// The code for displaying WooCommerce Product Custom Fields
add_action( 'woocommerce_product_options_general_product_data', 'woocommerce_product_defferent_price_fields' ); 
add_action( 'woocommerce_process_product_meta', 'woocommerce_product_defferent_price_fields' );

function woocommerce_product_defferent_price_fields () {
	global $woocommerce, $post;
	$currency = '('.get_woocommerce_currency_symbol().')';
	echo '<div class=" product_custom_field ">';
	// This function has the logic of creating custom field
	woocommerce_wp_checkbox(array(
    	'id' => '_different_price_custom_field', 
    	'label' => __('Set Different Price?', 'insightpro_restaurant'), 
    	'desc_tip' => true, 
    	'description' => __('If checked defferent Price will be active for this product', 'insightpro_restaurant'), 
    	'wrapper_class' => 'show_if_simple'
    ));


    woocommerce_wp_text_input(array(
    	'id' => '_dinein_price_custom_field', 
    	'wrapper_class' => 'show_if_simple',
    	'label' =>  __( 'Dine-in Price Field '.$currency, 'insightpro_restaurant' ), 
    	'placeholder' => '', 
    	'description' => __( 'Add Dine-in price for this product', 'insightpro_restaurant' ), 
    	'type' => 'text'
    ));

    woocommerce_wp_text_input(array(
    	'id' => '_takeaway_price_custom_field', 
    	'wrapper_class' => 'show_if_simple',
    	'label' =>  __( 'TakeaWay Price Field '.$currency, 'insightpro_restaurant' ), 
    	'placeholder' => '', 
    	'description' => __( 'Add takeaway price for this product', 'insightpro_restaurant' ), 
    	'type' => 'text'
    ));
    woocommerce_wp_text_input(array(
    	'id' => '_delivery_price_custom_field', 
    	'wrapper_class' => 'show_if_simple',
    	'label' =>  __( 'Delivery Price Field '.$currency, 'insightpro_restaurant' ), 
    	'placeholder' => '', 
    	'description' => __( 'Add delivery price for this product', 'insightpro_restaurant' ), 
    	'type' => 'text'
    ));
	echo '</div>';
}



/***************************************************************************************/

add_filter( 'woocommerce_product_data_tabs', 'product_dinein_price_tab' , 5 , 1 );
function product_dinein_price_tab( $product_data_tabs ) {
    $product_data_tabs['order-offer-custom-tab'] = array(
        'label' => __( 'Set Product Order Offers', 'insightpro_restaurant' ),
        'target' => 'order_offers_for_product_data',
    );
    return $product_data_tabs;
}

/*************************************************************************************/
add_action( 'woocommerce_product_data_panels', 'add_dinein_custom_product_data_fields' );
function add_dinein_custom_product_data_fields() {
    global $woocommerce, $post;
    $currency = '('.get_woocommerce_currency_symbol().')';
    ?>
    <div id="order_offers_for_product_data" class="panel woocommerce_options_panel">
        <?php

        woocommerce_wp_checkbox(array(
        	'id' => '_product_order_offers_custom_field', 
        	'label' => __('Set product order offers?', 'insightpro_restaurant'), 
        	'desc_tip' => true, 
        	'description' => __('If checked product order offers will be active for this product', 'insightpro_restaurant'), 
        	'wrapper_class' => 'show_if_simple'
        ));


        woocommerce_wp_text_input(array(
        	'id' => '_dinein_offer_price_custom_field', 
        	'wrapper_class' => 'show_if_simple',
        	'label' =>  __( 'Dine-in offer Price Field '.$currency, 'insightpro_restaurant' ), 
        	'placeholder' => '', 
        	'description' => __( 'Add Dine-in offer price for this product', 'insightpro_restaurant' ), 
        	'type' => 'text'
        ));


        ?>
    </div>
    <?php
}
/**********************************************************************************/

add_action( 'woocommerce_process_product_meta', 'dinein_price_fields_save' );
function dinein_price_fields_save( $post_id ){

    $dinein_price = isset( $_POST['_different_price_custom_field'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_different_price_custom_field', $dinein_price );

    $dinein_price = isset( $_POST['_dinein_price_custom_field'] ) ? $_POST['_dinein_price_custom_field'] : '';
    update_post_meta( $post_id, '_dinein_price_custom_field', $dinein_price );

    $takeaway_price = isset( $_POST['_takeaway_price_custom_field'] ) ? $_POST['_takeaway_price_custom_field'] : '';
    update_post_meta( $post_id, '_takeaway_price_custom_field', $takeaway_price );

    $delivery_price = isset( $_POST['_delivery_price_custom_field'] ) ? $_POST['_delivery_price_custom_field'] : '';
    update_post_meta( $post_id, '_delivery_price_custom_field', $delivery_price );
}


/*****************************************************************************/

// Set custom cart item price
add_action( 'woocommerce_before_calculate_totals', 'add_custom_price', 1000, 1);
function add_custom_price( $cart ) {
    // This is necessary for WC 3.0+
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Avoiding hook repetition (when using price calculations for example | optional)
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    $stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);

	$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);

	$selected_order_type = $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field'];
	//var_dump($selected_order_type);

    // Loop through cart items
    foreach ( $cart->get_cart() as $cart_item ) {

	    $different_price = get_post_meta( $cart_item["product_id"], '_different_price_custom_field', true );

		if($selected_order_type == 'dinein' && $different_price == 'yes'){
	    	$dinein_price = get_post_meta( $cart_item["product_id"], '_dinein_price_custom_field', true );
	        $cart_item['data']->set_price( $dinein_price );
    	}

    	if($selected_order_type == 'levering' && $different_price == 'yes'){
	    	$dinein_price = get_post_meta( $cart_item["product_id"], '_delivery_price_custom_field', true );
	        $cart_item['data']->set_price( $dinein_price );
    	}

    	if($selected_order_type == 'take_away' && $different_price == 'yes'){
	    	$dinein_price = get_post_meta( $cart_item["product_id"], '_takeaway_price_custom_field', true );
	        $cart_item['data']->set_price( $dinein_price );
    	}
	
	}///end foreach

}

/**************************************************************************************/

function has_bought( $value = 0 ) {
    if ( ! is_user_logged_in() && $value === 0 ) {
        return false;
    }

    global $wpdb;
    
    // Based on user ID (registered users)
    if ( is_numeric( $value) ) { 
        $meta_key   = '_customer_user';
        $meta_value = $value == 0 ? (int) get_current_user_id() : (int) $value;
    } 
    // Based on billing email (Guest users)
    else { 
        $meta_key   = '_billing_email';
        $meta_value = sanitize_email( $value );
    }
    
    $paid_order_statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );

    $count = $wpdb->get_var( $wpdb->prepare("
        SELECT COUNT(p.ID) FROM {$wpdb->prefix}posts AS p
        INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
        WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $paid_order_statuses ) . "' )
        AND p.post_type LIKE 'shop_order'
        AND pm.meta_key = '%s'
        AND pm.meta_value = %s
        LIMIT 1
    ", $meta_key, $meta_value ) );

    // Return a boolean value based on orders count
    return $count > 0;
}
/****************************************************************************************/

add_action( 'woocommerce_cart_calculate_fees','custom_applied_dinein_fee');
function custom_applied_dinein_fee() {
	global $woocommerce, $post;
	if ( is_admin() && ! defined( 'DOING_AJAX' ) )
	    return;

	$stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);

	$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);

	$selected_order_type = $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field'];


	if (get_current_user_id()) {
		$has_bought =has_bought();
	}else{
		$email = isset( $_POST['billing_email'] ) ? $_POST['billing_email'] : '';
		$email = sanitize_email( $email );
		$has_bought = has_bought( $email);
	}

	if ($has_bought != 'true') {
		$subtotal = WC()->cart->cart_contents_total;
		$percentageOfDiscount = get_option('insight_pro_userFirstOrderDiscount');
		$discountAmount = ($percentageOfDiscount / 100) * $subtotal;
		WC()->cart->add_fee( $percentageOfDiscount.'% discount for First Order', -$discountAmount, true , 'standard');
	}
	


	if($selected_order_type == 'dinein'){
		$cart_total = 0;
		// Iterating through each cart item
		foreach(WC()->cart->get_cart() as $cart_item){
			$dinein_price = get_post_meta( $cart_item["product_id"], '_dinein_price_custom_field', true );
			$item_total = $cart_item["line_total"];
		    $product = new WC_Product( $cart_item['product_id'] );
		    $quantiy = $cart_item['quantity']; //get quantity from cart
		    $cart_total += $item_total;
		}

		$percentage = get_option('insight_pro_dinein_service_charge');
		$fee = ($percentage / 100) * $cart_total;

		// Adding the fee
		if ( $fee != 0 ){
		    WC()->cart->add_fee( 'dine-in service charge', $fee, true , 'standard');
		}
	}

}





/////////////////////////////////////////////////////////////////////////////////////////







add_action( 'wp_ajax_get_insight_pro_timeslot_by_selected_date', 'get_insight_pro_timeslot_by_selected_date' );


add_action( 'wp_ajax_nopriv_get_insight_pro_timeslot_by_selected_date', 'get_insight_pro_timeslot_by_selected_date' );


function get_insight_pro_timeslot_by_selected_date() {
	
	//ob_start();
	date_default_timezone_set("Asia/Dhaka");

	$selected_date = $_POST['selected_alternate_date_value'];
	$selected_order_type = $_POST['selected_order_type'];
	if($selected_order_type == 'take_away'){
		$timeslotArray = get_option('insight_pro_pickup_timeslot');
	}
	if($selected_order_type == 'levering'){
		$timeslotArray = get_option('insight_pro_delivery_timeslot');
	}
	if($selected_order_type == 'dinein'){
		$timeslotArray = get_option('insight_pro_dinein_timeslot');
	}
	
	$selectedDaynum = date("N", strtotime($selected_date));
	
	echo '<option value="">Select Times</option>';
		
	if(!empty($timeslotArray)){
		
		$wp_current_time_stamp = strtotime(current_time('H:i'));
		
		foreach($timeslotArray as $singleTimeSlotKey => $singleTimeSlotVal){

	
			$startTime = $singleTimeSlotVal['start_timeslot'];
			$stertStrftime = strtotime($startTime);
			$currenttime = date('H:i');
			$currentStrftime = strtotime($currenttime);
			$currentDate = date('m/d/Y');

			if ($currentDate == $selected_date) {
				$isPass = ($stertStrftime > $currentStrftime)? 1 : 0;
			}else{
				$isPass = 1;
			}
			
			$startTime_delayed_timestamp=strtotime($startTime." - 30 minutes");
			

			$endTime = $singleTimeSlotVal['end_timeslot'];

			$timeSlotVal = $startTime.' - '.$endTime;
			
			$timeslotDaysArray = $singleTimeSlotVal['time_slot_for_day'];

			if (in_array($selectedDaynum, $timeslotDaysArray) && $isPass == 1) {
				if(strtotime(current_time('m/d/y')) == strtotime($selected_date)){
				
					if($startTime_delayed_timestamp > $wp_current_time_stamp){	
						echo '<option value="'.$timeSlotVal.'">'.$timeSlotVal.'</option>';
					}
					
				}else{
					echo '<option value="'.$timeSlotVal.'">'.$timeSlotVal.'</option>';
				}	
			}
			
		}
		
	}
	
	wp_die(); // this is required to terminate immediately and return a proper response
	
}


// load plugin's text domaim

function insight_pro_free_plugin_activation() {

		

	global $wpdb;

	

	if(!get_option('insight_pro_free_plugin_activation_date')){		

		$currentActivatedDate = date("m/d/Y");

		update_option('insight_pro_free_plugin_activation_date',$currentActivatedDate);

	}
	
	if(!get_option('insight_pro_order_type') || get_option('insight_pro_order_type') == ''){
		
		$default_insight_pro_order_type = array(
			"take_away" => "yes",
			"dinein" => "yes",
			"levering" => "yes"
			);		

		update_option('insight_pro_order_type',$default_insight_pro_order_type);

	}
	
	if(!get_option('insight_pro_takeaway_lable') || get_option('insight_pro_takeaway_lable') == ''){		

		$default_insight_pro_takeaway_lable = 'Take away';
		
		update_option('insight_pro_takeaway_lable',$default_insight_pro_takeaway_lable);

	}
	if(!get_option('insight_pro_delivery_lable') || get_option('insight_pro_delivery_lable') == ''){		

		$default_insight_pro_delivery_lable = 'Delivery';

		update_option('insight_pro_delivery_lable',$default_insight_pro_delivery_lable);

	}
	if(!get_option('insight_pro_dinein_lable') || get_option('insight_pro_dinein_lable') == ''){		

		$default_insight_pro_dinein_lable = 'Dine in';

		update_option('insight_pro_dinein_lable',$default_insight_pro_dinein_lable);

	}
	if(!get_option('insight_pro_guest_no') || get_option('insight_pro_guest_no') == ''){		

		$default_insight_pro_guest_no = 'yes';

		update_option('insight_pro_guest_no',$default_insight_pro_guest_no);

	}
	if(!get_option('insight_pro_guest_purpose') || get_option('insight_pro_guest_purpose') == ''){		

		$default_insight_pro_guest_purpose = 'yes';

		update_option('insight_pro_guest_purpose',$default_insight_pro_guest_purpose);

	}
	if(!get_option('insight_pro_widget_field_position') || get_option('insight_pro_widget_field_position') == ''){		

		$default_insight_pro_widget_field_position = 'bottom';

		update_option('insight_pro_widget_field_position',$default_insight_pro_widget_field_position);

	}
	
	

}

register_activation_hook( __FILE__, 'insight_pro_free_plugin_activation' );





function insight_pro_free_plugin_activation_admin_notice_error() {

	

	$free_plugins_activated_date = get_option('insight_pro_free_plugin_activation_date');

	$free_plugins_activated_after_date = date('m/d/Y', strtotime($free_plugins_activated_date. ' + 16 days'));

	$currentDate = date("m/d/Y");

	

	if($free_plugins_activated_after_date <= $currentDate){	

		$message = 'It has been more than 15 days you are using <b>Restaurant Pickup | Delivery | Dine in</b> plugin. Will you mind put a 5 star review to grow up the plugin with more & more features! Please <a href="https://wordpress.org/support/plugin/insightpro_restaurant/reviews/?rate=5#new-post" target="_new">click here</a>';

    echo '<div class="notice notice-warning is-dismissible" style="padding: 10px;">'.$message.'</div>';	

	}

	

}



add_action( 'admin_notices', 'insight_pro_free_plugin_activation_admin_notice_error' );





function insight_pro_load_text_domain(){







$byc_lang_path=dirname( plugin_basename(__FILE__) ) . '/languages/';







if(load_plugin_textdomain( 'insight_pro', false, $byc_lang_path ));







}



add_action('plugins_loaded','insight_pro_load_text_domain');





include('inc/admin.php');







global $woocommerce;







// we need cookie so lets have a safe and confirm way







add_action('init', 'insight_proSetCookie', 1);







function insight_proSetCookie() {

// set default values if empty to avoid undefined index issue using cookies

if(empty($_COOKIE['insight_pro_delivery_widget_cookie'])){



$insight_pro_delivery_widget=array(



'insight_pro_widget_date_field'=>'',



'insight_pro_widget_time_field'=>'',



'insight_pro_widget_type_field'=>'levering',



'insight_pro_widget_guest_count_field'=>'',



'insight_pro_widget_guest_purpose_field'=>''

); 



$json_insight_pro_delivery_widget=json_encode($insight_pro_delivery_widget);



setcookie('insight_pro_delivery_widget_cookie',$json_insight_pro_delivery_widget,time() + 60 * 60 * 24 *1,'/');



if(empty($_COOKIE['insight_pro_delivery_widget_cookie']))

{

	$_COOKIE['insight_pro_delivery_widget_cookie']=json_encode($insight_pro_delivery_widget);

}

}

} 



// front-end widget 

class insight_pro_widget extends WP_Widget {



function __construct() {



parent::__construct(



// Base ID of our widget

'insight_pro_widget', 



// Widget name will appear in UI

__('Delivery|pickup|dinr in widget', 'insight_pro'), 



// Widget description

array( 'description' => __( 'Widget for users to choose date & time of delivery|pickup|dine in', 'insightpro_restaurant' ), ) 

);

}







// Creating widget front-end







// This is where the action happens







public function widget( $args, $instance ) {







echo $args['before_widget'];







if ( ! empty( $instance['insight_pro_widget_title'] ) ) {







echo $args['before_title'] . apply_filters( 'widget_title', esc_html($instance['insight_pro_widget_title']) ) . $args['after_title'];







}



echo $args['after_widget'];



$stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);



$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);



$insight_pro_delivery_date = !empty( $insight_pro_delivery_widget_cookie_array['insight_pro_widget_date_field'] ) ? $insight_pro_delivery_widget_cookie_array['insight_pro_widget_date_field'] : false;



$insight_pro_delivery_time = !empty( $insight_pro_delivery_widget_cookie_array['insight_pro_widget_time_field'] ) ? $insight_pro_delivery_widget_cookie_array['insight_pro_widget_time_field'] : false;



$insight_pro_order_type = !empty( $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field'] ) ? $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field'] : false;



$insight_pro_guest_count = !empty( $insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_count_field'] ) ? $insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_count_field'] : '';



$insight_pro_guest_purpose = !empty( $insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_purpose_field'] ) ? $insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_purpose_field'] : '';



//for translations

$insight_pro_takeaway_lable=get_option('insight_pro_takeaway_lable');



$insight_pro_delivery_lable=get_option('insight_pro_delivery_lable');



$insight_pro_date_field_text=get_option('insight_pro_date_field_text');



$insight_pro_time_field_text=get_option('insight_pro_time_field_text');



$insight_pro_guest_count_lable=get_option('insight_pro_guest_count_lable');



$insight_pro_guest_purpose_lable=get_option('insight_pro_guest_purpose_lable');



// get cookie as array

$stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);



$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);



if(!empty($insight_pro_takeaway_lable)) 

{ }

else 

{ 

$insight_pro_takeaway_lable = __('Take away','insightpro_restaurant');

}



if(!empty($insight_pro_delivery_lable)) 

{ }

else 

{ 

$insight_pro_delivery_lable = __('Delivery','insightpro_restaurant');

}



if(!empty($insight_pro_dinein_lable)) 

{ }

else 

{ 

$insight_pro_dinein_lable = __('Dine in','insightpro_restaurant');

}



if(!empty($insight_pro_date_field_text)) 

{ } 

else 

{ 

$insight_pro_date_field_text = __('Choose your date','insightpro_restaurant');

}



if(!empty($insight_pro_time_field_text)) 

{ } 

else 

{ 

$insight_pro_time_field_text = __('Choose your time','insightpro_restaurant');

}



if(!empty($insight_pro_guest_count_field_text)) 

{ } 

else 

{ 

$insight_pro_guest_count_field_text = __('How many guests are coming','insightpro_restaurant');

}



if(!empty($insight_pro_guest_purpose_field_text)) 

{ } 

else 

{ 

$insight_pro_guest_purpose_field_text = __('What accommodation we need to provide you','insightpro_restaurant');

}



?>



<form action="" method="post" class="insight_pro_order_type_for_widget">



<div class="insight_pro_order_type_for_widget">



<?php 

$insight_pro_allowed_order_types=get_option('insight_pro_order_type');



if(is_array($insight_pro_allowed_order_types) && array_key_exists('take_away',$insight_pro_allowed_order_types) && $insight_pro_allowed_order_types['take_away']=='yes'){

?>

<input type="radio" name="insight_pro_widget_type_field" value="take_away" <?php if($insight_pro_order_type=='take_away'){echo ' checked="checked"';}?>/>

<label for="insight_pro_order_type_take_away" class="radio "><?php echo esc_html($insight_pro_takeaway_lable);?></label>

<?php }

if(is_array($insight_pro_allowed_order_types) && array_key_exists('levering',$insight_pro_allowed_order_types) && $insight_pro_allowed_order_types['levering']=='yes'){

?>

<input type="radio" name="insight_pro_widget_type_field" value="levering"<?php if($insight_pro_order_type=='levering'){echo ' checked="checked"';}?> />

<label for="insight_pro_order_type_levering" class="radio "><?php echo esc_html($insight_pro_delivery_lable);?></label>

<?php }

if(is_array($insight_pro_allowed_order_types) && array_key_exists('dinein',$insight_pro_allowed_order_types) && $insight_pro_allowed_order_types['dinein']=='yes'){

?>

<input type="radio" name="insight_pro_widget_type_field" value="dinein"<?php if($insight_pro_order_type=='dinein'){echo ' checked="checked"';}?> />



<label for="insight_pro_order_type_dinein" class="radio "><?php echo esc_html($insight_pro_dinein_lable);?></label>

<?php }?>



</div>



<br />



<input type="text" name="insight_pro_widget_date_field" class="insight_pro_widget_date_field"  placeholder="<?php echo esc_html($insight_pro_date_field_text);?>" readonly="readonly" value="<?php echo esc_attr($insight_pro_delivery_date);?>" />



<input type="text" name="insight_pro_delivery_date_alternate" class="insight_pro_widget_date_field_alternate" id="insight_pro_delivery_date_alternate_widget" readonly="readonly" value="<?php echo esc_html(!empty($insight_pro_delivery_date_alternate)?$insight_pro_delivery_date_alternate:'');?>" style="display:none;" />



<input type="text" name="insight_pro_widget_time_field" class="insight_pro_widget_time_field" placeholder="<?php echo esc_html($insight_pro_time_field_text);?>" value="<?php echo esc_html($insight_pro_delivery_time);?>" />

<br />



<p class="byc_service_time_closed"></p>



<p class="insight_pro_widget_guest_count_field"><?php echo $insight_pro_guest_count_field_text;?>(optional)</p>



<select name="insight_pro_widget_guest_count_field" class="insight_pro_widget_guest_count_field">

<option value="">Number of guest</option>

<option value="single"<?php if($insight_pro_guest_count=='single'){echo' selected="selected"';} ?>>Single <?php //esc_html($insight_pro_guest_count_single_lable);?></option>

<option value="couple"<?php if($insight_pro_guest_count=='couple'){echo' selected="selected"';} ?>>Couple<?php //esc_html($insight_pro_guest_count_couple_lable);?></option>

<option value="three"<?php if($insight_pro_guest_count=='three'){echo' selected="selected"';} ?>>3<?php //esc_html($insight_pro_guest_count_three_lable);?></option>

<option value="four"<?php if($insight_pro_guest_count=='four'){echo' selected="selected"';} ?>>4<?php //esc_html($insight_pro_guest_count_four_lable);?></option>

<option value="five"<?php if($insight_pro_guest_count=='five'){echo' selected="selected"';} ?>>5<?php //esc_html($insight_pro_guest_count_five_lable);?></option>

<option value="six"<?php if($insight_pro_guest_count=='six'){echo' selected="selected"';} ?>>6<?php //esc_html($insight_pro_guest_count_six_lable);?></option>

<option value="seven"<?php if($insight_pro_guest_count=='seven'){echo' selected="selected"';} ?>>7<?php //esc_html($insight_pro_guest_count_seven_lable);?></option>

<option value="party_mode"<?php if($insight_pro_guest_count=='party_mode'){echo' selected="selected"';} ?>>7+<?php //esc_html($insight_pro_guest_count_part_mode_lable);?></option>

</select>



<p class="insight_pro_widget_guest_purpose_field"><?php echo $insight_pro_guest_purpose_field_text;?> (optional)</p>

<select name="insight_pro_widget_guest_purpose_field" class="insight_pro_widget_guest_purpose_field">

<option value="">Any accommodation</option>

<option value="casual_lunch_or_dinner" <?php if($insight_pro_guest_purpose=='casual_lunch_or_dinner'){echo 'selected="selected"';} ?>>Casual Lunch/dinner<?php //esc_html($insight_pro_guest_purpose_casual_lable);?></option>



<option value="romantic_dinner" <?php if($insight_pro_guest_purpose=='romantic_dinner'){echo 'selected="selected"';} ?>>Romantic dinner<?php //esc_html($insight_pro_guest_purpose_romantic_dinner_lable);?></option>



<option value="family_lunch_or_dinner" <?php if($insight_pro_guest_purpose=='family_lunch_or_dinner'){echo 'selected="selected"';} ?>>Lunch/dinner with family<?php //esc_html($insight_pro_guest_purpose_family_lunch_dinner_lable);?></option>



<option value="client_meet_over_lunch" <?php if($insight_pro_guest_purpose=='client_meet_over_lunch'){echo 'selected="selected"';} ?>>Client meet over lunch<?php //esc_html($insight_pro_guest_purpose_client_meeting_lable);?></option>



<option value="party_celebration" <?php if($insight_pro_guest_purpose=='party_celebration'){echo 'selected="selected"';} ?>>Party celebration<?php //esc_html($insight_pro_guest_purpose_party_lable);?></option>

</select>



<?php 



if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering'){?>



<p class="min-shipping-time"><img src="<?php echo plugins_url('images/min-shipping-time.png', __FILE__)?>" alt="Minimum delivery time" /> &nbsp; <?php echo esc_html(get_option('insight_pro_delivery_times'));?></p>



<?php }?>



<input type="submit" name="insight_pro_widget_submit" value="Save" />



</form>



<?php



echo $args['after_widget'];



//pre-order settings



?>



<script>



jQuery(document).ready(function(){



delivery_opening_time="<?php echo esc_html(get_option('insight_pro_delivery_hours_from')); ?>";



pickup_opening_time="<?php echo esc_html(get_option('insight_pro_pickup_hours_from')); ?>";



dinein_opening_time="<?php echo esc_html(get_option('insight_pro_dinein_hours_from')); ?>";



delivery_ending_time="<?php echo esc_html(get_option('insight_pro_delivery_hours_to')); ?>";



pickup_ending_time="<?php echo esc_html(get_option('insight_pro_pickup_hours_to')); ?>";



dinein_ending_time="<?php echo esc_html(get_option('insight_pro_dinein_hours_to')); ?>";



<?php

if(get_option('insight_pro_preorder_days')==''){// if no pre-order date is not set in settings page

?>



jQuery(".insight_pro_widget_date_field").datepicker({



minDate: 0,



showAnim: "slideDown", 



beforeShowDay: function(date){ return checkHolidaysBycRestro( date ); },



altField: ".insight_pro_widget_date_field_alternate",



altFormat: "dd/m/yy",



onSelect: function(){jQuery(".insight_pro_widget_time_field").timepicker("remove"); jQuery(".insight_pro_widget_time_field").val(''); insight_proDeliveryWidgetTimePopulate(".insight_pro_widget_date_field",".insight_pro_widget_time_field");} // reset timepicker on date selection to get new time value depending date selected here AND THEN call call time population function



});



<?php

}else{//if no pre-order date is set in settings page do the date selection restriction

?>



jQuery( ".insight_pro_widget_date_field" ).datepicker({ 



minDate: 0, 



maxDate: "<?php echo esc_html(get_option('insight_pro_preorder_days'));?>+D", 



showOtherMonths: true,



selectOtherMonths: true,



showAnim: "slideDown",



beforeShowDay: function(date){ return checkHolidaysBycRestro( date ); },



altField: ".insight_pro_widget_date_field_alternate",



altFormat: "dd/m/yy",



onSelect: function(){jQuery(".insight_pro_widget_time_field").timepicker("remove"); jQuery(".insight_pro_widget_time_field").val(''); insight_proDeliveryWidgetTimePopulate(".insight_pro_widget_date_field",".insight_pro_widget_time_field");} // reset timepicker on date selection to get new time value depending date selected here AND THEN call call time population function



});

<?php }	



//synchornize all the order type radio button in widget and in checkout field in a simple way



if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering'){

?>



jQuery("#_insight_pro_order_type_levering").prop("checked", true);



<?php	}

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away'){

?>



jQuery("#_insight_pro_order_type_take_away").prop("checked", true);



<?php	}

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein'){

?>



jQuery("#_insight_pro_order_type_dinein").prop("checked", true);

<?php } ?>





jQuery("input#_insight_pro_delivery_date").val("<?php echo esc_html($insight_pro_delivery_widget_cookie_array['insight_pro_widget_date_field']);?>");



jQuery("input#_insight_pro_delivery_time").val("<?php echo esc_html(isset($insight_pro_delivery_widget_cookie_array['insight_pro_widget_time_field'])?$insight_pro_delivery_widget_cookie_array['insight_pro_widget_time_field']:'');?>");



jQuery("input#_insight_pro_guest_count").val("<?php echo esc_html(isset($insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_count_field'])?$insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_count_field']:'');?>");



jQuery("input#_insight_pro_guest_purpose").val("<?php echo esc_html(isset($insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_purpose_field'])?$insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_purpose_field']:'');?>");



})



</script>

<?php

}



// Widget Backend 



public function form( $instance ) {



if ( isset( $instance[ 'insight_pro_widget_title' ] ) ) {



$title = $instance[ 'insight_pro_widget_title' ];



}

else 

{



$title = __( 'New title', 'insightpro_restaurant' );



}

// Widget admin form

?>



<p>

<label for="<?php echo esc_html($this->get_field_id( 'insight_pro_widget_title' )); ?>"><?php __( 'Title:','insightpro_restaurant' ); ?></label> 



<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'insight_pro_widget_title' )); ?>" name="<?php echo $this->get_field_name( 'insight_pro_widget_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />



</p>



<?php 



}

// Updating widget replacing old instances with new



public function update( $new_instance, $old_instance ) {



$instance = array();



$instance['insight_pro_widget_title'] = ( ! empty( $new_instance['insight_pro_widget_title'] ) ) ? strip_tags( $new_instance['insight_pro_widget_title'] ) : '';



return $instance;



}

/*****************************************************/

} // Class insight_pro_widget ends here

// Register and load the widget



function insight_pro_load_widget() {



register_widget( 'insight_pro_widget' );



}



add_action( 'widgets_init', 'insight_pro_load_widget' );//save frontend widget data in cookie, so we need to do it before any output, hence hook it on init



function insight_pro_savefrontend_widget_data(){



// save thwe widget data in in cookie	



if(isset($_POST['insight_pro_widget_submit'])){



$insight_pro_delivery_widget_post_array = array(



'insight_pro_widget_date_field'   => sanitize_text_field(isset($_POST['insight_pro_widget_date_field'])?$_POST['insight_pro_widget_date_field']:''),



'insight_pro_widget_time_field'   => sanitize_text_field(isset($_POST['insight_pro_widget_time_field'])?$_POST['insight_pro_widget_time_field']:''),



'insight_pro_widget_type_field'   => sanitize_text_field(isset($_POST['insight_pro_widget_type_field'])?$_POST['insight_pro_widget_type_field']:''),



'insight_pro_widget_guest_count_field'   => sanitize_text_field(isset($_POST['insight_pro_widget_guest_count_field'])?$_POST['insight_pro_widget_guest_count_field']:''),



'insight_pro_widget_guest_purpose_field'   => sanitize_text_field(isset($_POST['insight_pro_widget_guest_purpose_field'])?$_POST['insight_pro_widget_guest_purpose_field']:'')

);



//set cookie

$json_insight_pro_delivery_widget_post_array=json_encode($insight_pro_delivery_widget_post_array);



setcookie('insight_pro_delivery_widget_cookie',$json_insight_pro_delivery_widget_post_array , time() + 60 * 60 * 24 * 1, '/');



$_COOKIE['insight_pro_delivery_widget_cookie'] = $json_insight_pro_delivery_widget_post_array;// for immediate access in widget



}



}// end of insight_pro_savefrontend_widget_data



add_action('init','insight_pro_savefrontend_widget_data');// Add the field to the checkout



//add_action( 'woocommerce_after_order_notes', 'insight_pro_checkout_field' );



add_action( 'woocommerce_checkout_before_customer_details', 'insight_pro_checkout_field' );



function insight_pro_checkout_field( $checkout ) {



global $woocommerce;// get cookie as array

$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
	if($insight_pro_enable_timeslot == 'yes'){
		echo '<div class="loading_image_contanier" style="display:none;"><img src="'.plugins_url().'/insightpro_restaurant/images/loading_image.gif" alt="" /></div>';
	}
$insight_pro_time_field_validation = get_option('insight_pro_time_field_validation');



$insight_pro_has_virtual_products = false;



$insight_pro_virtual_products = 0;



// Get all products in cart

$insight_pro_products = $woocommerce->cart->get_cart();



  // Loop through cart products

  foreach( $insight_pro_products as $insight_pro_product ) {



	  // Get product ID and '_virtual' post meta

	  $insight_pro_product_id = $insight_pro_product['product_id'];



	  $insight_pro_is_virtual = get_post_meta( $insight_pro_product_id, '_virtual', true );



	  // Update $has_virtual_product if product is virtual

	  if( $insight_pro_is_virtual == 'yes' )



  		$insight_pro_virtual_products += 1;



  }



  if( count($insight_pro_products) == $insight_pro_virtual_products )

  {

	  $insight_pro_both_product_count_val = 'same';

  }

  else

  {

	  $insight_pro_both_product_count_val = 'not_same';

  }



  //echo $bycwooodt_both_product_count_val;

  //$has_virtual_products = true;



if($insight_pro_both_product_count_val == 'not_same')

{

$insight_pro_takeaway_lable=get_option('insight_pro_takeaway_lable');



$insight_pro_delivery_lable=get_option('insight_pro_delivery_lable');



$insight_pro_dinein_lable = get_option('insight_pro_dinein_lable');

$insight_pro_dinein_service_charge = get_option('insight_pro_dinein_service_charge');



$insight_pro_date_field_text=get_option('insight_pro_date_field_text');



$insight_pro_time_field_text=get_option('insight_pro_time_field_text');



$insight_pro_guest_count_field_text=get_option('insight_pro_guest_count_field_text');



$insight_pro_guest_purpose_field_text=get_option('insight_pro_guest_purpose_field_text');



$insight_pro_allowed_order_types=get_option('insight_pro_order_type');



if(is_array($insight_pro_allowed_order_types) && array_key_exists('take_away',$insight_pro_allowed_order_types) && $insight_pro_allowed_order_types['take_away']=='yes'){

	$insight_pro_allowed_order_types_array['take_away']=esc_html($insight_pro_takeaway_lable);

	}



if(is_array($insight_pro_allowed_order_types) && array_key_exists('levering',$insight_pro_allowed_order_types) && $insight_pro_allowed_order_types['levering']=='yes'){

	$insight_pro_allowed_order_types_array['levering']=esc_html($insight_pro_delivery_lable);

	}



if(is_array($insight_pro_allowed_order_types) && array_key_exists('dinein',$insight_pro_allowed_order_types) && $insight_pro_allowed_order_types['dinein']=='yes'){

	$insight_pro_allowed_order_types_array['dinein']=esc_html($insight_pro_dinein_lable); 

	}



// get cookie as array

$stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);



$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);



if(!empty($insight_pro_takeaway_lable)) 

{ 

//$insight_pro_takeaway_lable =  get_option('insight_pro_takeaway_lable'); 

} 

else 

{ 

$insight_pro_takeaway_lable = __('Take away','insightpro_restaurant');

}



if(!empty($insight_pro_delivery_lable)) 

{ 

//$insight_pro_delivery_lable =  get_option('insight_pro_delivery_lable'); 

} 

else 

{ 

$insight_pro_delivery_lable = __('Delivery','insightpro_restaurant');

}



if(!empty($insight_pro_dinein_lable)) 

{ 

//$insight_pro_delivery_lable =  get_option('insight_pro_delivery_lable'); 

} 

else 

{ 

$insight_pro_dinein_lable = __('Dine in','insightpro_restaurant');

}



if(!empty($insight_pro_date_field_text)) 

{ 

//$insight_pro_date_field_text =  get_option('insight_pro_date_field_text'); 

} 

else 

{ 

$insight_pro_date_field_text = __('Choose your date','insightpro_restaurant');

}



if(!empty($insight_pro_time_field_text)) 

{ 

//$insight_pro_time_field_text =  get_option('insight_pro_time_field_text'); 

} 

else 

{ 

$insight_pro_time_field_text = __('Select time','insightpro_restaurant');

}



if(!empty($insight_pro_guest_count_field_text)) 

{ 

//$insight_pro_time_field_text =  get_option('insight_pro_time_field_text'); 

} 

else 

{ 

$insight_pro_guest_count_field_text = __('Number of guest','insightpro_restaurant');

}



if(!empty($insight_pro_guest_purpose_field_text)) 

{ 

//$insight_pro_time_field_text =  get_option('insight_pro_time_field_text'); 

} 

else 

{ 

$insight_pro_guest_purpose_field_text = __('What accommodation you need','insightpro_restaurant');

}





$get_option_insight_pro_chekout_page_order_type_label=get_option('insight_pro_chekout_page_order_type_label');



if(!empty($get_option_insight_pro_chekout_page_order_type_label)){

}else{

$get_option_insight_pro_chekout_page_order_type_label = __('Select order type','insightpro_restaurant');	

}



$get_option_insight_pro_chekout_page_date_label=get_option('insight_pro_chekout_page_date_label');



if(!empty($get_option_insight_pro_chekout_page_date_label)){

//$get_option_insight_pro_chekout_page_date_lebel=get_option('insight_pro_chekout_page_date_label');	

}else{

$get_option_insight_pro_chekout_page_date_label = __('Choose a date','insightpro_restaurant');		

}



$get_option_insight_pro_chekout_page_time_label=get_option('insight_pro_chekout_page_time_label');



if(!empty($get_option_insight_pro_chekout_page_time_label)){

}else{

$get_option_insight_pro_chekout_page_time_label=__('Choose a time','insightpro_restaurant');	

}



echo '<div id="insight_pro_checkout_field"><h3>'.esc_html(get_option('insight_pro_chekout_page_section_heading')) . '</h3>';



woocommerce_form_field( '_insight_pro_order_type', array(



'type'          => 'radio',



'required'		=>	true,



'class'         => array('insight_pro_order_type', 'ABC'),



'label'         => $get_option_insight_pro_chekout_page_order_type_label,



'label_class'	=> 'insight_pro_ordertype_label',



'placeholder'   => __('Select order type','insightpro_restaurant'),



'default'		=> esc_html($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']),



'checked'		=> 'checked',



'options'		=> $insight_pro_allowed_order_types_array,

/*

'options'		=> array(



'take_away' => esc_html($insight_pro_takeaway_lable), 



'levering' => esc_html($insight_pro_delivery_lable), 



'dinein' => esc_html($insight_pro_dinein_lable), 

)

*/

));



//$get_option_insight_pro_chekout_page_date_lebel='CVBN';

woocommerce_form_field( '_insight_pro_delivery_date', array(



'type'          => 'text',



'required'		=>	true,



'class'         => array('insight_pro_delivery_date'),



'label'         => $get_option_insight_pro_chekout_page_date_label,



'placeholder'   => __(esc_html($insight_pro_date_field_text),'insightpro_restaurant'),



'default'		=> esc_html($insight_pro_delivery_widget_cookie_array['insight_pro_widget_date_field'])

));



woocommerce_form_field( '_insight_pro_delivery_date_alternate', array(



'type'          => 'text',



'class'         => array('insight_pro_delivery_date_alternate'),



'label'         => '',



'placeholder'   => '',



'default'		=> '',



));		



if($insight_pro_time_field_validation == 'yes'){

	$required = true;

}else{

	$required = false;

}


$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
if($insight_pro_enable_timeslot == 'yes'){
	
	$insight_pro_widget_time_val = array('0' => __('Select time','insightpro_restaurant'));
	
	woocommerce_form_field( '_insight_pro_delivery_time', array(
	'type'          => 'select',
	'class'         => array('insight_pro_delivery_time'),
	'label'         => $get_option_insight_pro_chekout_page_time_label,
	'placeholder'   => __(esc_html($insight_pro_time_field_text),'insightpro_restaurant'),
	'default'		=> '',	
	'options'		=> $insight_pro_widget_time_val,
	'required'		=>	$required,
	));
	
}else{

	woocommerce_form_field( '_insight_pro_delivery_time', array(
	'type'          => 'text',
	'required'		=>	$required,
	'class'         => array('insight_pro_delivery_time'),
	'label'         => $get_option_insight_pro_chekout_page_time_label,
	'placeholder'   => __(esc_html($insight_pro_time_field_text),'insightpro_restaurant'),
	'default'		=> esc_html($insight_pro_delivery_widget_cookie_array['insight_pro_widget_time_field'])
	));

 } 

echo '<p class="byc_service_time_closed"></p></div>';

/*****************************************************************/

$insight_pro_guest_no =  get_option('insight_pro_guest_no');

if($insight_pro_guest_no == "yes"){
	woocommerce_form_field( '_insight_pro_guest_count', array(
		
		
		
		'type'          => 'radio',
		
		
		
		'required'		=>	false,
		
		
		
		'class'         => array('insight_pro_guest_count', 'ABC'),
		
		
		
		'label'         => 'Tell us about number of guest(s)',//$get_option_insight_pro_chekout_page_order_type_label,
		
		
		
		'label_class'	=> 'insight_pro_guest_count_label',
		
		
		
		'placeholder'   => __('Tell us about number of guest(s)','insightpro_restaurant'),
		
		
		
		'default'		=> esc_html(isset($insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_count_field'])?$insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_count_field']:''),
		
		
		
		'checked'		=> 'checked',
		
		
		
		'options'		=> array(
		
		
		
		'single' => 1,//esc_html($insight_pro_guest_count_single_lable),
		
		
		
		'couple' => 2,//esc_html($insight_pro_guest_count_couple_lable),
		
		
		
		'three' => 3,//esc_html($insight_pro_guest_count_three_lable),
		
		
		
		'four' => 4,//esc_html($insight_pro_guest_count_four_lable),
		
		
		
		'five' => 5,//esc_html($insight_pro_guest_count_five_lable),
		
		
		
		'six' => 6,//esc_html($insight_pro_guest_count_six_lable),
		
		
		
		'seven' => 7,//esc_html($insight_pro_guest_count_seven_lable),
		
		
		
		'party_mode' => '7+'//esc_html($insight_pro_guest_count_part_mode_lable)
		
		)
	
	));
}


$insight_pro_guest_purpose =  get_option('insight_pro_guest_purpose');


if($insight_pro_guest_purpose == "yes"){
	
	woocommerce_form_field( '_insight_pro_guest_purpose', array(
		
		
		
		'type'          => 'radio',
		
		
		
		'required'		=>	false,
		
		
		
		'class'         => array('insight_pro_guest_purpose', 'ABC'),
		
		
		
		'label'         => 'Tell us what accommodation we need to provide you',//$get_option_insight_pro_chekout_page_order_type_label,
		
		
		
		'label_class'	=> 'insight_pro_guest_purpose_label',
		
		
		
		'placeholder'   => __('Tell us if you need any of these below accommodations','insightpro_restaurant'),
		
		
		
		'default'		=> esc_html(isset($insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_purpose_field'])?$insight_pro_delivery_widget_cookie_array['insight_pro_widget_guest_purpose_field']:''),
		
		
		
		'checked'		=> 'checked',
		
		
		
		'options'		=> array(
		
		
		
		'casual_lunch_or_dinner' => 'Casual Lunch/dinner',//esc_html($insight_pro_guest_purpose_casual_lable),
		
		
		
		'romantic_dinner' => 'Romantic dinner',//esc_html($insight_pro_guest_purpose_romantic_dinner_lable),
		
		
		
		'family_lunch_or_dinner' => 'Lunch/dinner with family',//esc_html($insight_pro_guest_purpose_family_lunch_dinner_lable),
		
		
		
		'client_meet_over_lunch' => 'Client meet over lunch',//esc_html($insight_pro_guest_purpose_client_meeting_lable),
		
		
		
		'party_celebration' => 'Party celebration',//esc_html($insight_pro_guest_purpose_party_lable)
		
		)
	
	));

}

/*****************************************************************/

	}

}



// Validate the custom field.

add_action('woocommerce_checkout_process', 'insight_pro_checkout_field_process');



function insight_pro_checkout_field_process() {



// Check if set, if its not set add an error.

global $woocommerce;// get cookie as array



 $insight_pro_has_virtual_products = false;



  // Default virtual products number

  $insight_pro_virtual_products = 0;



  // Get all products in cart

  $insight_pro_products = $woocommerce->cart->get_cart();



  // Loop through cart products

  foreach( $insight_pro_products as $insight_pro_product ) {

	  // Get product ID and '_virtual' post meta

	  $insight_pro_product_id = $insight_pro_product['product_id'];

	  $insight_pro_is_virtual = get_post_meta( $insight_pro_product_id, '_virtual', true );

	  // Update $has_virtual_product if product is virtual



	  if( $insight_pro_is_virtual == 'yes' )

  		$insight_pro_virtual_products += 1;

  }



  if( count($insight_pro_products) == $insight_pro_virtual_products )

  {

	  $insight_pro_both_product_count_val = 'same';

  }

  else

  {

	  $insight_pro_both_product_count_val = 'not_same';

  }



if($insight_pro_both_product_count_val == 'not_same')

{



if ( ! $_POST['_insight_pro_delivery_date'] )

wc_add_notice( '<b>'.__( 'Pickup / Delivery / Dine in date is a required field.','insightpro_restaurant' ).'</b>', 'error' );

$insight_pro_time_field_validation = get_option('insight_pro_time_field_validation');



if($insight_pro_time_field_validation == 'yes'){

if ( ! $_POST['_insight_pro_delivery_time'] )

wc_add_notice( '<b>'.__( 'Time is a required field.','insightpro_restaurant' ).'</b>', 'error' );

}



 }



}



//Save the order meta with field value

add_action( 'woocommerce_checkout_update_order_meta', 'insight_pro_checkout_field_update_order_meta' );



function insight_pro_checkout_field_update_order_meta( $order_id ) {



global $woocommerce;// get cookie as array



 $insight_pro_has_virtual_products = false;



  // Default virtual products number

  $insight_pro_virtual_products = 0;



  // Get all products in cart

  $insight_pro_products = $woocommerce->cart->get_cart();



  // Loop through cart products

  foreach( $insight_pro_products as $insight_pro_product ) {



	  // Get product ID and '_virtual' post meta

	  $insight_pro_product_id = $insight_pro_product['product_id'];



	  $insight_pro_is_virtual = get_post_meta( $insight_pro_product_id, '_virtual', true );



	  // Update $has_virtual_product if product is virtual

	  if( $insight_pro_is_virtual == 'yes' )

  		$insight_pro_virtual_products += 1;

  }



  if( count($insight_pro_products) == $insight_pro_virtual_products )

  {

	  $insight_pro_both_product_count_val = 'same';

  }

  else

  {

	  $insight_pro_both_product_count_val = 'not_same';

  }





if($insight_pro_both_product_count_val == 'not_same')

{

	

if ( ! empty( $_POST['_insight_pro_delivery_date'] ) ) {



update_post_meta( $order_id, '_insight_pro_delivery_date', sanitize_text_field( $_POST['_insight_pro_delivery_date'] ) );

}



if ( ! empty( $_POST['_insight_pro_delivery_time'] ) ) {

update_post_meta( $order_id, '_insight_pro_delivery_time', sanitize_text_field( $_POST['_insight_pro_delivery_time'] ) );

}



if ( ! empty( $_POST['_insight_pro_order_type'] ) ) {

update_post_meta( $order_id, '_insight_pro_order_type', sanitize_text_field($_POST['_insight_pro_order_type'] ));



if($_POST['_insight_pro_order_type']=='dinein'){

	if ( ! empty( $_POST['_insight_pro_guest_count'] ) ) {

		update_post_meta( $order_id, '_insight_pro_guest_count', sanitize_text_field($_POST['_insight_pro_guest_count'] ));

	}

	if ( ! empty( $_POST['_insight_pro_guest_purpose'] ) ) {

		update_post_meta( $order_id, '_insight_pro_guest_purpose', sanitize_text_field($_POST['_insight_pro_guest_purpose'] ));

	}



	

	}

}



}



}



//Display field value on the order edit page

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'insight_pro_checkout_field_display_admin_order_meta', 10, 1 );



function insight_pro_checkout_field_display_admin_order_meta($order){



$order_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->id : $order->get_id();



$insight_pro_takeaway_lable=get_option('insight_pro_takeaway_lable');



$insight_pro_delivery_lable=get_option('insight_pro_delivery_lable');



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='take_away'){

if(!empty($insight_pro_takeaway_lable)) 

{ 

$order_order_type =  $insight_pro_takeaway_lable; 

} 

else 

{ 

$order_order_type = __('Take away','insightpro_restaurant');

}

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='levering'){

if(!empty($insight_pro_delivery_lable)) 

{ 

$order_order_type =  $insight_pro_delivery_lable; 

} 

else 

{ 

$order_order_type = __('Delivery','insightpro_restaurant');

}

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='dinein'){

if(!empty($insight_pro_dinein_lable)) 

{ 

$order_order_type =  $insight_pro_dinein_lable; 

} 

else 

{ 

$order_order_type = __('Dine in','insightpro_restaurant');

}

$order_dinein_guest_count=ucfirst(get_post_meta( $order_id, '_insight_pro_guest_count', true ));

$order_dinein_guest_purpose=ucfirst(get_post_meta( $order_id, '_insight_pro_guest_purpose', true ));

}



//type

if(!empty(get_post_meta( $order_id, '_insight_pro_order_type', true )) )

{

echo '<p><strong>'.__('Order type','insightpro_restaurant').':</strong> ' . esc_html($order_order_type) . '</p>';

}



//date

if(!empty(get_post_meta( $order_id, '_insight_pro_delivery_date', true )) )

{

echo '<p><strong>'.__('Delivery|Pickup|dine in date','insightpro_restaurant').':</strong> ' . esc_html(get_post_meta( $order_id, '_insight_pro_delivery_date', true )) . '</p>';

}



//time

if(!empty(get_post_meta( $order_id, '_insight_pro_delivery_time', true )) )

{

echo '<p><strong>'.__('Delivery|Pickup|dine in time','insightpro_restaurant').':</strong> ' . esc_html(get_post_meta( $order_id, '_insight_pro_delivery_time', true )) . '</p>';

}



//dine in

if(get_post_meta( $order_id, '_insight_pro_order_type', true ) == 'dinein' )

{

echo '<p><strong>'.__('Number of guest','insightpro_restaurant').':</strong> ' . esc_html($order_dinein_guest_count). '</p>';

echo '<p><strong>'.__('Accomodation requested ','insightpro_restaurant').':</strong> ' . esc_html(str_replace('_',' ',$order_dinein_guest_purpose)) . '</p>';

}



}



// Display order meta in order details section

if(get_option('insight_pro_widget_field_position')=='top'){ //hook here if it is set to show on top in admin settings page



//add_action( 'woocommerce_view_order', 'insight_pro_checkout_field_display_user_order_meta', 10, 1 );

add_action( 'woocommerce_order_details_after_order_table_items', 'insight_pro_checkout_field_display_user_order_meta', 10, 1 );

}



if(get_option('insight_pro_widget_field_position')=='bottom'){  //hook here if it is set to show on bottom in admin settings page



add_action( 'woocommerce_order_details_after_order_table', 'insight_pro_checkout_field_display_user_order_meta', 10, 1 );



}



function insight_pro_checkout_field_display_user_order_meta($order){



$order_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->id : $order->get_id();



$insight_pro_takeaway_lable=get_option('insight_pro_takeaway_lable');



$insight_pro_delivery_lable=get_option('insight_pro_delivery_lable');



$insight_pro_dinein_lable=get_option('insight_pro_dinein_lable');



$insight_pro_dinein_guest_number_lable=get_option('insight_pro_dinein_guest_number_lable');



$insight_pro_dinein_guest_accommodation_lable=get_option('insight_pro_dinein_guest_purpose_lable');



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='dinein'){

if(!empty($insight_pro_dinein_lable)) 

{ 

$order_order_type_text =  $insight_pro_dinein_lable; 

} 

else 

{ 

$order_order_type_text = __('This order is for','insightpro_restaurant');

}

$order_dinein_guest_count=get_post_meta( $order_id, '_insight_pro_guest_count', true );

$order_dinein_guest_purpose=get_post_meta( $order_id, '_insight_pro_guest_purpose', true );

}





if(get_post_meta( $order_id , '_insight_pro_order_type', true )=='take_away'){



if(!empty($insight_pro_takeaway_lable)) 

{ 

$order_order_type =  $insight_pro_takeaway_lable; 

} 

else 

{ 

$order_order_type = __('Pickup','insightpro_restaurant');

}

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='levering'){

if(!empty($insight_pro_delivery_lable)) 

{ 

$order_order_type =  $insight_pro_delivery_lable; 

} 

else 

{ 

$order_order_type = __('Delivery','insightpro_restaurant');

}

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='dinein'){

if(!empty($insight_pro_dinein_lable)) 

{ 

$order_order_type =  $insight_pro_dinein_lable; 

} 

else 

{ 

$order_order_type = __('Dine in','insightpro_restaurant');

}

if(!empty($insight_pro_dinein_guest_number_lable)){

$order_dinein_guest_number_text=$insight_pro_dinein_guest_number_lable;	

}else{

$order_dinein_guest_number_text=__('Number of guest(s)','insightpro_restaurant');	

}

if(!empty($insight_pro_dinein_guest_accommodation_lable)){

$order_dinein_guest_accommodation_text = $insight_pro_dinein_guest_accommodation_lable;	

}else{

$order_dinein_guest_accommodation_text = __('Accommodation requested','insightpro_restaurant');	

}

$order_dinein_guest_count=get_post_meta( $order_id, '_insight_pro_guest_count', true );

$order_dinein_guest_purpose=ucfirst(get_post_meta( $order_id, '_insight_pro_guest_purpose', true ));

}



//type

if(!empty(get_post_meta( $order_id, '_insight_pro_order_type', true )) )

{

echo '<p><strong>'.__('This order is for','insightpro_restaurant').':</strong> ' . esc_html($order_order_type) . '</p>';

}



//date

if( !empty(get_post_meta( $order_id, '_insight_pro_delivery_date', true )) )

{

echo '<p><strong>'.__($order_order_type.' date','insightpro_restaurant').':</strong> ' . esc_html(get_post_meta( $order_id, '_insight_pro_delivery_date', true )) . '</p>';

}



//time

if(!empty(get_post_meta( $order_id, '_insight_pro_delivery_time', true )) )

{

echo '<p><strong>'.__($order_order_type.' time','insightpro_restaurant').':</strong> ' . esc_html(get_post_meta( $order_id, '_insight_pro_delivery_time', true )) . '</p>';

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='levering'){

$prepare_shipping_text= str_replace('[bycrestro_delivery_date]','<b>'.esc_html(get_post_meta( $order_id, '_insight_pro_delivery_date', true )).'</b>',esc_html(get_option('insight_pro_orders_delivered')));



echo '<p>'.str_replace('[bycrestro_delivery_time]','<b>'.esc_html(get_post_meta( $order_id, '_insight_pro_delivery_time', true )).'</b>',$prepare_shipping_text).'</p>';

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='take_away'){

$prepare_shipping_text= str_replace('[bycrestro_pickup_date]','<b>'.esc_html(get_post_meta( $order_id, '_insight_pro_delivery_date', true )).'</b>',esc_html(get_option('insight_pro_orders_pick_up')));



echo '<p>'.str_replace('[bycrestro_pickup_time]','<b>'.esc_html(get_post_meta( $order_id, '_insight_pro_delivery_time', true )).'</b>',$prepare_shipping_text).'</p>';	

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='dinein'){

$prepare_shipping_text= str_replace('[bycrestro_dine_in_date]','<b>'.esc_html(get_post_meta( $order_id, '_insight_pro_delivery_date', true )).'</b>',esc_html(get_option('insight_pro_orders_dinein')));

$insight_pro_guest_no =  get_option('insight_pro_guest_no'); 
	
if( $insight_pro_guest_no == 'yes'){
		
	echo '<p><strong>'.$order_dinein_guest_number_text.':</strong> ' . esc_html(ucfirst($order_dinein_guest_count)) . '</p>';
	
}

$insight_pro_guest_purpose = get_option('insight_pro_guest_purpose');

if( $insight_pro_guest_purpose == 'yes'){

	echo '<p><strong>'.$order_dinein_guest_accommodation_text.':</strong> ' . esc_html(str_replace('_',' ',$order_dinein_guest_purpose)) . '</p>';

}


echo '<p>'.str_replace('[bycrestro_dine_in_time]','<b>'.esc_html(get_post_meta( $order_id, '_insight_pro_delivery_time', true )).'</b>',$prepare_shipping_text).'</p>';	

}

}



//include the custom order meta to woocommerce mail

//add_action( "woocommerce_email_after_order_table", "insight_pro_woocommerce_email_after_order_table", 10, 1);

add_action( "woocommerce_email_after_order_table", "insight_pro_checkout_field_display_user_order_meta", 10, 1);



function insight_pro_woocommerce_email_after_order_table( $order ) {



$insight_pro_takeaway_lable=get_option('insight_pro_takeaway_lable');



$insight_pro_delivery_lable=get_option('insight_pro_delivery_lable');



$order_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $order->id : $order->get_id();



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='take_away'){

if(!empty($insight_pro_takeaway_lable)) 

{ 

$order_order_type =  $insight_pro_takeaway_lable; 

} 

else 

{ 

$order_order_type = __('Take away','insightpro_restaurant');

}

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='levering'){

if(!empty($insight_pro_delivery_lable)) 

{ 

$order_order_type =  $insight_pro_delivery_lable; 

} 

else 

{ 

$order_order_type = __('Delivery','insightpro_restaurant');

}

}



if(get_post_meta( $order_id, '_insight_pro_order_type', true )=='dinein'){

if(!empty($insight_pro_delivery_lable)) 

{ 

$order_order_type =  $insight_pro_delivery_lable; 

} 

else 

{ 

$order_order_type = __('Dine in','insightpro_restaurant');

}

}



if(!empty(get_post_meta( $order_id, '_insight_pro_delivery_time', true )) && !empty(get_post_meta( $order_id, '_insight_pro_delivery_date', true )) )

{



echo '<p></p><p><strong>'.__('Delivery|Pickup|dine in date','insight_pro').':</strong> ' . esc_html(get_post_meta( $order_id, '_insight_pro_delivery_date', true )) . '</p>';



echo '<p><strong>'.__('Delivery|Pickup|Dine in time','insight_pro').':</strong> ' . esc_html(get_post_meta( $order_id, '_insight_pro_delivery_time', true )) . '</p>';



echo '<p><strong>'.__('Order type','insightpro_restaurant').':</strong> ' . esc_html($order_order_type) . '</p>';

}

}



// add our styles and js

function insight_pro_add_scripts() {



wp_enqueue_script('jquery-ui-datepicker');



wp_register_script('insight_pro_timepicker', plugins_url('js/jquery.timepicker.min.js', __FILE__), array('jquery'),'1.12', true);



wp_register_script('insight_pro_main', plugins_url('js/insight_pro.js', __FILE__), array('jquery'),'1.12', true);



wp_enqueue_script('insight_pro_timepicker');



wp_enqueue_script('insight_pro_main');



}



add_action( 'wp_enqueue_scripts', 'insight_pro_add_scripts' ); 

//add styles

function insight_pro_add_styles() {

wp_enqueue_style('insight_pro_stylesheet', plugins_url('css/style.css', __FILE__));



wp_enqueue_style('insight_pro_stylesheet_ui', plugins_url('css/jquery-ui.min.css', __FILE__));



wp_enqueue_style('insight_pro_stylesheet_ui_theme', plugins_url('css/jquery-ui.theme.min.css', __FILE__));



wp_enqueue_style('insight_pro_stylesheet_ui_structure', plugins_url('css/jquery-ui.structure.min.css', __FILE__));



wp_enqueue_style('insight_pro_stylesheet_time_picker', plugins_url('css/jquery.timepicker.css', __FILE__));

}



add_action( 'wp_enqueue_scripts', 'insight_pro_add_styles' ); 




function insight_pro_admin_script($hook) {


	global $insight_pro_timeslot_settings;


	if($hook == $insight_pro_timeslot_settings){	

		$plugins_url_path = plugins_url();
		
		wp_register_script( 'insight_pro-admin-script', plugins_url( 'js/insight_pro-admin-script.js' , __FILE__ ),array('jquery'),'1.12', true );
		
		wp_enqueue_script( 'insight_pro-admin-script');

		wp_enqueue_style('insight_pro_admin_stylesheet', plugins_url('css/insight_pro-admin-style.css', __FILE__));


	}
	else
	{
		return;
	}


}


add_action('admin_enqueue_scripts', 'insight_pro_admin_script');



// refreshing the cart on page load

/** Break html5 cart caching */

add_action('wp_enqueue_scripts', 'insight_pro_cartcache_enqueue_scripts', 100);



function insight_pro_cartcache_enqueue_scripts()

{

wp_deregister_script('wc-cart-fragments');



wp_enqueue_script( 'wc-cart-fragments', plugins_url( 'js/cart-fragments.js', __FILE__ ), array( 'jquery', 'jquery-cookie' ), '1.12', true );



}



// show only store pickup when take_away is selected	

add_filter('woocommerce_package_rates', 'insight_pro_shipping_according_widget_input', 10, 2);

//add_filter('woocommerce_package_rates', 'insight_pro_shipping_according_widget_input', 100);



function insight_pro_shipping_according_widget_input($rates, $package)

{

// get cookie as array

$stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);



$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);



global $woocommerce;



$version = "2.6";



if (version_compare($woocommerce->version, $version, ">=")) {



$new_rates = array();



/*echo '<hr />';



print_r($rates);*/



if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away'){

foreach($rates as $key => $rate) {

if ('local_pickup' === $rate->method_id || 'legacy_local_pickup' === $rate->method_id) {

$new_rates[$key] = $rates[$key];

}

}



/*print_r($new_rates);

print_r($rates);*/

}elseif($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering'){

foreach($rates as $key => $rate) {

/*print_r($rate);

echo '<hr />';*/

if ('local_pickup' != $rate->method_id && 'legacy_local_pickup' != $rate->method_id ) {

$new_rates[$key] = $rates[$key];

//unset($rates['local_pickup']);

}

}

}elseif($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein'){

foreach($rates as $key => $rate) {

if ('local_pickup' === $rate->method_id || 'legacy_local_pickup' === $rate->method_id) {

$new_rates[$key] = $rates[$key];

}

}

/*print_r($new_rates);

print_r($rates);*/

}else{

//

}



return empty($new_rates) ? $rates : $new_rates;

/*echo '<hr />';

print_r($new_rates);*/

}

else {

if ($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away') {

$predefined_shipping          = $rates['local_pickup'];

$rates                  = array();

$rates['local_pickup'] = $predefined_shipping;

}



if ($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering') {

$predefined_shipping          = $rates['flat_rate'];

$rates                  = array();

$rates['flat_rate'] = $predefined_shipping;

}



if ($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein') {

$predefined_shipping          = $rates['local_pickup'];

$rates                  = array();

$rates['local_pickup'] = $predefined_shipping;

}

return $rates;

}

}



// check if checkout page

// do the JS to populate date and time field paqrameter

function insight_pro_wp_head() {

?>



	<style>

		#_insight_pro_delivery_date_alternate_field{display:none;}
		.loading_image_contanier{background-color: #ececec47;width: 80%;position: absolute;}
		.loading_image_contanier img{margin: 0 auto;display: block;margin-top: 15%;}

	</style>



<?php

}

add_action('wp_head', 'insight_pro_wp_head', 1);



function insight_pro_footer_script(){



// get cookie as array

if(!empty($_COOKIE['insight_pro_delivery_widget_cookie'])){



$stripped_out_insight_pro_delivery_widget_cookie=stripslashes($_COOKIE['insight_pro_delivery_widget_cookie']);



$insight_pro_delivery_widget_cookie_array=json_decode($stripped_out_insight_pro_delivery_widget_cookie,true);

}

?>

<script>

function insight_proStartTimeByInterval(cur_hour,cur_minute){

if(cur_minute > 0 && cur_minute < 15){



var start_minute=15;



}else if(cur_minute >= 15 && cur_minute < 30){



var start_minute=30;



}else if(cur_minute >= 30 && cur_minute < 45){



var start_minute=45;



}else if(cur_minute >= 45 && cur_minute < 59){



var start_minute=59;



}else{}



if(start_minute==59){



var next_hour=parseInt(cur_hour)+1;



var start_time_updated=next_hour+":"+"00";



}else{



var start_time_updated=cur_hour+":"+start_minute;



}



return start_time_updated;



} // end of byinsightprotimeInterval



function insight_proDeliveryWidgetTimePopulate(date_field_identifier,time_field_identifier){ 

// lock the time selection based on admin settings for delivery time

//echo 'var curtime_to_compare=new Date().toLocaleTimeString();';

service_status="open";



var current_date= new Date();



var curtime= new Date().toLocaleTimeString("en-US", { hour12: false, hour: "numeric", minute: "numeric"});

// get local minute

//var cur_minute= new Date().toLocaleTimeString("en-US", { hour12: false, minute: "numeric"});



var cur_minute=current_date.getMinutes();



// get local hour

//var cur_hour= new Date().toLocaleTimeString("en-US", { hour12: false, hour: "numeric"});											



var cur_hour=current_date.getHours();



var curtime=cur_hour+':'+cur_minute;



insight_proStartTimeByInterval(cur_hour,cur_minute); // check this function in wp-footer

//populate time field based on date selection (call this function onSelect event of datepicker)

/*var selected_date=jQuery(".insight_pro_widget_date_field").datepicker( "getDate" );*/

selected_date=jQuery(date_field_identifier).datepicker('option', 'dateFormat', 'dd M yy').val();



//var byc_delivery_date_alternate = jQuery("#insight_pro_delivery_date_alternate").val().split("/");

var byc_delivery_date_alternate = jQuery(date_field_identifier+"_alternate").val().split("/");

if(byc_delivery_date_alternate[1]==1){

byc_delivery_date_alternate_month='Jan';

}else if(byc_delivery_date_alternate[1]==2){

byc_delivery_date_alternate_month='Feb';

}else if(byc_delivery_date_alternate[1]==3){

byc_delivery_date_alternate_month='Mar';

}else if(byc_delivery_date_alternate[1]==4){

byc_delivery_date_alternate_month='Apr';

}else if(byc_delivery_date_alternate[1]==5){

byc_delivery_date_alternate_month='May';

}else if(byc_delivery_date_alternate[1]==6){

byc_delivery_date_alternate_month='Jun';

}else if(byc_delivery_date_alternate[1]==7){

byc_delivery_date_alternate_month='Jul';

}else if(byc_delivery_date_alternate[1]==8){

byc_delivery_date_alternate_month='Aug';

}else if(byc_delivery_date_alternate[1]==9){

byc_delivery_date_alternate_month='Sep';

}else if(byc_delivery_date_alternate[1]==10){

byc_delivery_date_alternate_month='Oct';

}else if(byc_delivery_date_alternate[1]==11){

byc_delivery_date_alternate_month='Nov';

}else if(byc_delivery_date_alternate[1]==12){

byc_delivery_date_alternate_month='Dec';

}else{

byc_delivery_date_alternate_month='';

}



selected_date = byc_delivery_date_alternate[0] + " " + byc_delivery_date_alternate_month + " " + byc_delivery_date_alternate[2];



todays_date=new Date();

todays_date_month=(todays_date.getMonth()+1);

todays_date_date=todays_date.getDate();

todays_date_year=todays_date.getFullYear();



if( todays_date_month < 10){

todays_date_month='0' + todays_date_month;

}



if(todays_date_date < 10){

todays_date_date='0' + todays_date_date;

}



if(todays_date_month==1){

todays_date_month='Jan';

}else if(todays_date_month==2){

todays_date_month='Feb';

}else if(todays_date_month==3){

todays_date_month='Mar';

}else if(todays_date_month==4){

todays_date_month='Apr';

}else if(todays_date_month==5){

todays_date_month='May';

}else if(todays_date_month==6){

todays_date_month='Jun';

}else if(todays_date_month==7){

todays_date_month='Jul';

}else if(todays_date_month==8){

todays_date_month='Aug';

}else if(todays_date_month==9){

todays_date_month='Sep';

}else if(todays_date_month==10){

todays_date_month='Oct';

}else if(todays_date_month==11){

todays_date_month='Nov';

}else if(todays_date_month==12){

todays_date_month='Dec';

}else{

todays_date_month='';

}

todays_formated_date = todays_date_date + " " + todays_date_month + " " + todays_date_year;



if( Date.parse(selected_date) != Date.parse(todays_formated_date) ){

<?php if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away'){?>

start_time_updated_as_per_selected_date = pickup_opening_time;

<?php }

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering'){?>

start_time_updated_as_per_selected_date = delivery_opening_time;

<?php }

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein'){?>

start_time_updated_as_per_selected_date = dinein_opening_time;

<?php }?>



//alert('Different date, so starting time is store openning time '+delivery_opening_time + pickup_opening_time);

}else if( Date.parse(selected_date) == Date.parse(todays_formated_date) ){

//if current time is grater than openning time then show current time

<?php if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away'){?>

//alert(curtime +"||"+ pickup_opening_time);

if(Date.parse('22 Sep 2017 '+curtime) <= Date.parse('22 Sep 2017 '+pickup_opening_time)){

start_time_updated_as_per_selected_date = pickup_opening_time;

}



if(Date.parse('22 Sep 2017 '+curtime) > Date.parse('22 Sep 2017 '+pickup_opening_time)){

start_time_updated_as_per_selected_date = insight_proStartTimeByInterval(cur_hour,cur_minute); // check this function in wp_footer



if(Date.parse('11 Jan 2018 '+start_time_updated_as_per_selected_date) >= Date.parse('11 Jan 2018 <?php echo esc_html(get_option('insight_pro_pickup_hours_to'));?>')){

	service_status="closed";

	}

}



<?php }



if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein'){?>

//alert(curtime +"||"+ pickup_opening_time);

if(Date.parse('11 Sep 2019 '+curtime) <= Date.parse('11 Sep 2019 '+dinein_opening_time)){

start_time_updated_as_per_selected_date = dinein_opening_time;

}



if(Date.parse('11 Sep 2019 '+curtime) > Date.parse('11 Sep 2019 '+dinein_opening_time)){

start_time_updated_as_per_selected_date = insight_proStartTimeByInterval(cur_hour,cur_minute); // check this function in wp_footer



if(Date.parse('11 Sep 2019 '+start_time_updated_as_per_selected_date) >= Date.parse('11 Sep 2018 <?php echo esc_html(get_option('insight_pro_dinein_hours_to'));?>')){

	service_status="closed";

	}

}



<?php }



if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering'){?>



if(Date.parse('22 Sep 2017 '+curtime) <= Date.parse('22 Sep 2017 '+delivery_opening_time)){

start_time_updated_as_per_selected_date = delivery_opening_time;

}



if(Date.parse('22 Sep 2017 '+curtime) > Date.parse('22 Sep 2017 '+delivery_opening_time)){

start_time_updated_as_per_selected_date = insight_proStartTimeByInterval(cur_hour,cur_minute); // check this function in wp_footer

//alert('start_time_updated_as_per_selected_date : '+start_time_updated_as_per_selected_date);



if(Date.parse('11 Jan 2018 '+start_time_updated_as_per_selected_date) >= Date.parse('11 Jan 2018 <?php echo esc_html(get_option('insight_pro_delivery_hours_to'));?>')){

	service_status="closed";

	}

}

<?php }?>

//alert('equal date, so starting time is current time '+start_time_updated_as_per_selected_date)

}else{

alert('You have bug in this version of plugin, please update the plugin');

}



<?php

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering'){

?>



if(service_status=='closed'){



	jQuery('p.byc_service_time_closed').html('<?php echo __("We are closed now, please select another day","insightpro_restaurant");?>');



	//alert('time_field_identifier : '+time_field_identifier);



	jQuery(time_field_identifier).css("dispaly:none");



	jQuery(time_field_identifier).addClass("byc_closed_now");



	}else{



jQuery(time_field_identifier).css("dispaly:block");



jQuery(time_field_identifier).removeClass("byc_closed_now");



jQuery('p.byc_service_time_closed').html('');



jQuery(time_field_identifier).timepicker({



//if it is not today's date selected in dateicker then do not do the past time resriction 

//if(jQuery(".insight_pro_widget_date_field").datepicker( "getDate" )!= new Date();

"minTime": start_time_updated_as_per_selected_date,



"maxTime": "<?php echo get_option('insight_pro_delivery_hours_to');?>",



"disableTextInput": "true",



"disableTouchKeyboard": "true",



"scrollDefault": "now",



"step": "15",



"selectOnBlur": "true",



"timeFormat": "<?php echo get_option('insight_pro_hours_format');?>"

});		

		}

<?php

}



// lock the time selection based on admin settings for pickup time

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away'){

?>

//alert("service_status : "+service_status);

if(service_status=='closed'){

	jQuery('p.byc_service_time_closed').html('<?php echo __("We are closed now, please select another day","insightpro_restaurant");?>');



	jQuery(time_field_identifier).css("dispaly:none");

	//alert('time_field_identifier : '+time_field_identifier);

	jQuery(time_field_identifier).css("dispaly:none");



	jQuery(time_field_identifier).addClass("byc_closed_now");



	}else{



jQuery(time_field_identifier).css("dispaly:block");



jQuery(time_field_identifier).removeClass("byc_closed_now");



jQuery('p.byc_service_time_closed').html('');



jQuery(time_field_identifier).timepicker({



"minTime": start_time_updated_as_per_selected_date,



"maxTime": "<?php echo get_option('insight_pro_pickup_hours_to');?>",



"disableTextInput": "true",



"disableTouchKeyboard": "true",



"scrollDefault": "now",



"step": "15",



"selectOnBlur": "true",



"timeFormat": "<?php echo get_option('insight_pro_hours_format');?>"

});

	}

<?php

}



// lock the time selection based on admin settings for dine in time

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein'){

?>

//alert("service_status : "+service_status);

if(service_status=='closed'){

	jQuery('p.byc_service_time_closed').html('<?php echo __("We are closed now, please select another day","insightpro_restaurant");?>');



	jQuery(time_field_identifier).css("dispaly:none");

	//alert('time_field_identifier : '+time_field_identifier);

	jQuery(time_field_identifier).css("dispaly:none");



	jQuery(time_field_identifier).addClass("byc_closed_now");



	}else{



jQuery(time_field_identifier).css("dispaly:block");



jQuery(time_field_identifier).removeClass("byc_closed_now");



jQuery('p.byc_service_time_closed').html('');



jQuery(time_field_identifier).timepicker({



"minTime": start_time_updated_as_per_selected_date,



"maxTime": "<?php echo get_option('insight_pro_dinein_hours_to');?>",



"disableTextInput": "true",



"disableTouchKeyboard": "true",



"scrollDefault": "now",



"step": "15",



"selectOnBlur": "true",



"timeFormat": "<?php echo get_option('insight_pro_hours_format');?>"

});

	}

<?php

}





// if no delivery type is not selected then show all times

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']==''){

?>

jQuery(time_field_identifier).timepicker({



"disableTextInput": "true",



"disableTouchKeyboard": "true",



"scrollDefault": "now",



"step": "15",



"selectOnBlur": "true",



"timeFormat": "<?php echo get_option('insight_pro_hours_format');?>"

});

<?php

}	

?>

} // End of function insight_proDeliveryWidgetTimePopulate



<?php

$insight_pro_pickup_closingdays=get_option('insight_pro_pickup_holidays');

$insight_pro_delivery_closingdays=get_option('insight_pro_delivery_holidays');

$insight_pro_dinein_closingdays=get_option('insight_pro_dinein_holidays');

?>

$insight_pro_delivery_closingdays = [

<?php

$stat_i=1;

if(!empty($insight_pro_delivery_closingdays)){

$day_i=count($insight_pro_delivery_closingdays);

foreach($insight_pro_delivery_closingdays as $insight_pro_delivery_closingdays_single)

{

echo trim($insight_pro_delivery_closingdays_single);

//handle the last comma(,)

if($stat_i<$day_i){

echo ',';

}

$stat_i++;

}

}

?>

];



$insight_pro_pickup_closingdays = [

<?php

$stat_i=1;

if(!empty($insight_pro_pickup_closingdays)){

$day_i=count($insight_pro_pickup_closingdays);

foreach($insight_pro_pickup_closingdays as $insight_pro_pickup_closingdays_single)

{

echo trim($insight_pro_pickup_closingdays_single);

//handle the last comma(,)

if($stat_i<$day_i){

echo ',';

}

$stat_i++;

}

}

?>

];



$insight_pro_dinein_closingdays = [

<?php

$stat_i=1;

if(!empty($insight_pro_dinein_closingdays)){

$day_i=count($insight_pro_dinein_closingdays);

foreach($insight_pro_dinein_closingdays as $insight_pro_dinein_closingdays_single)

{

echo trim($insight_pro_dinein_closingdays_single);

//handle the last comma(,)

if($stat_i<$day_i){

echo ',';

}

$stat_i++;

}

}

?>

];



</script>

<?php



if(is_checkout()){// execute on woocommerce check out page only

//date and time fields population by plugin settings page

?>



<script>

jQuery(document).ready(function(){

<?php

if(get_option('insight_pro_preorder_days')==''){// if no pre-order date is not set in settings page

?>

jQuery("#_insight_pro_delivery_date").datepicker({



minDate: 0,



showAnim: "slideDown",



beforeShowDay: function(date){ return checkHolidaysBycRestro( date ); },



altField: "#_insight_pro_delivery_date_alternate",



//altFormat: "dd/m/yy",
altFormat: "mm/dd/yy",


onSelect: function(){jQuery("#_insight_pro_delivery_time").timepicker("remove"); jQuery("#_insight_pro_delivery_time").val(''); insight_proDeliveryWidgetTimePopulate("#_insight_pro_delivery_date","#_insight_pro_delivery_time");
	
	<?php 
		$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
		if($insight_pro_enable_timeslot == 'yes'){
	?>
	
	var alternate_selecteddate = jQuery("#_insight_pro_delivery_date_alternate").val();
	<?php
	$byinsightpro_hours_format = get_option('insight_pro_hours_format');

	if($byinsightpro_hours_format == 'H:i'){
		$hourformate = '12';
	}
	if($byinsightpro_hours_format == 'h:i A'){
		$hourformate = '24';
	}
	?>

	var curtime= new Date().toLocaleTimeString("en-US", { hour<?php echo $hourformate;?>: false, hour: "numeric", minute: "numeric"});
	var current_system_time= curtime.split(' ');
	var current_system_time_without_comma = curtime.replace(","," "); 

	jQuery(".loading_image_contanier").css("display","block");
	var selected_data = {	
	'action': 'get_insight_pro_timeslot_by_selected_date',
	'selected_alternate_date_value' : alternate_selecteddate,
	'current_system_time' : current_system_time_without_comma,
	'selected_order_type' : '<?php echo $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field'];?>',
	};
	
	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	jQuery.post( ajaxurl, selected_data, function( response)  {
		//alert( 'Got this from the server: ' + response );
		//console.log('response: ' + response);
		jQuery("#_insight_pro_delivery_time").timepicker("remove");
		jQuery("#_insight_pro_delivery_time").empty();	
		jQuery("#_insight_pro_delivery_time").append(response);
		var insight_pro_delivery_time_count = jQuery('#_insight_pro_delivery_time option').length;
		jQuery(".loading_image_contanier").css("display","none");
		//console.log(insight_pro_delivery_time_count);
		if(insight_pro_delivery_time_count>1){
			//jQuery("#byinsightpro_delivery_time_field").css("display","block");
			//jQuery("#byc_time_field_service_closed_notice").css("display","none");
			jQuery("#_insight_pro_delivery_time").css({background:"",color:""});
			jQuery("#_insight_pro_delivery_date").css({border:""});
			jQuery(".loading_image_contanier").css("display","none");
		}else{
			jQuery("#_insight_pro_delivery_time").html('<option value="">We are closed for today! Please select another date</option>');
			var closed_today_style={background: "#c92b00", color: "#ff0"};
			jQuery("#_insight_pro_delivery_time").css({background:"#c92b00",color:"#ff0"});
			jQuery("#_insight_pro_delivery_date").css({border:"1px solid #ff0"}).animate({borderWidth: 4}, 500);
			//jQuery("#byc_time_field_service_closed_notice").css("display","block");	
			jQuery(".loading_image_contanier").css("display","none");
		}

	});
	
	<?php } ?>

} // reset timepicker on date selection to get new time value depending date selected here AND THEN call call time population function



});



<?php

}else{//if no pre-order date is set in settings page do the date selection restriction

?>



jQuery( "#_insight_pro_delivery_date" ).datepicker({ 



minDate: 0,



maxDate: "<?php echo get_option('insight_pro_preorder_days');?>D",



showOtherMonths: true,



selectOtherMonths: true,



showAnim: "slideDown",



beforeShowDay: function(date){ return checkHolidaysBycRestro( date ); },



altField: "#_insight_pro_delivery_date_alternate",



//altFormat: "dd/m/yy",

altFormat: "mm/dd/yy",

onSelect: function(){jQuery("#_insight_pro_delivery_time").timepicker("remove"); jQuery("#_insight_pro_delivery_time").val(''); insight_proDeliveryWidgetTimePopulate("#_insight_pro_delivery_date","#_insight_pro_delivery_time");
	
	<?php 
		$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
		if($insight_pro_enable_timeslot == 'yes'){
	?>
	var alternate_selecteddate = jQuery("#_insight_pro_delivery_date_alternate").val();
	<?php
	$byinsightpro_hours_format = get_option('insight_pro_hours_format');

	if($byinsightpro_hours_format == 'H:i'){
		$hourformate = '12';
	}
	if($byinsightpro_hours_format == 'h:i A'){
		$hourformate = '24';
	}
	?>

	var curtime= new Date().toLocaleTimeString("en-US", { hour<?php echo $hourformate;?>: false, hour: "numeric", minute: "numeric"});
	var current_system_time= curtime.split(' ');
	var current_system_time_without_comma = curtime.replace(","," "); 

	jQuery(".loading_image_contanier").css("display","block");
	var selected_data = {	
	'action': 'get_insight_pro_timeslot_by_selected_date',
	'selected_alternate_date_value' : alternate_selecteddate,
	'current_system_time' : current_system_time_without_comma,
	'selected_order_type' : '<?php echo $insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field'];?>',
	};
	
	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	jQuery.post( ajaxurl, selected_data, function( response)  {
		//alert( 'Got this from the server: ' + response );
		//console.log('response: ' + response);
		jQuery("#_insight_pro_delivery_time").timepicker("remove");
		jQuery("#_insight_pro_delivery_time").empty();	
		jQuery("#_insight_pro_delivery_time").append(response);
		var insight_pro_delivery_time_count = jQuery('#_insight_pro_delivery_time option').length;
		jQuery(".loading_image_contanier").css("display","none");
		//console.log(insight_pro_delivery_time_count);
		if(insight_pro_delivery_time_count>1){
			//jQuery("#byinsightpro_delivery_time_field").css("display","block");
			//jQuery("#byc_time_field_service_closed_notice").css("display","none");
			jQuery("#_insight_pro_delivery_time").css({background:"",color:""});
			jQuery("#_insight_pro_delivery_date").css({border:""});
			jQuery(".loading_image_contanier").css("display","none");
		}else{
			jQuery("#_insight_pro_delivery_time").html('<option value="">We are closed for today! Please select another date. </option>');
			var closed_today_style={background: "#c92b00", color: "#ff0"};
			jQuery("#_insight_pro_delivery_time").css({background:"#c92b00",color:"#ff0"});
			jQuery("#_insight_pro_delivery_date").css({border:"1px solid #ff0"}).animate({borderWidth: 4}, 500);
			//jQuery("#byc_time_field_service_closed_notice").css("display","block");	
			jQuery(".loading_image_contanier").css("display","none");
		}

	});
	<?php } ?>


} // reset timepicker on date selection to get new time value depending date selected here AND THEN call call time population function



});



<?php	}	?>



})



jQuery(document).ready(function(){

//jQuery("#insight_pro_delivery_date_alternate").css("display","none");



jQuery(".insight_pro_widget_date_field").val("");



jQuery(".insight_pro_widget_time_field").val("");



});



</script>



<?php

// refresh the page once delivery type is changed and if the checkout page dont have the widget present (if it has widget present it will be refresh by widget itself)

//check if it is checkout page

//check if widget is present on checkout page

//if widget is not present create it and make it hide

echo '<div style="display:none;">';

the_widget( 'insight_pro_widget' );

echo '</div>';

?>



<script>

//alertboxes to translate

jQuery(document).ready(function() {
	<?php
	$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
	if($insight_pro_enable_timeslot == ''){
	?>
	jQuery('#_insight_pro_delivery_time').on('click',function(){

		if(! jQuery('#_insight_pro_delivery_time').hasClass('ui-timepicker-input')){

			//alert("checkout");

			alert("<?php echo __("Please select date again","insightpro_restaurant");?>");

			}

	});
	<?php } ?>


jQuery('#_insight_pro_delivery_time').attr("readonly");



jQuery("#_insight_pro_delivery_date").prop("readonly",true);

});

</script>



<?php

}// is_checkout

else

{

?>

<script>

//alertboxes to translate

jQuery(document).ready(function() {
	
	<?php
	$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
	if($insight_pro_enable_timeslot == ''){
	?>
	jQuery('.insight_pro_widget_time_field').on('click',function(){
		if(! jQuery('.insight_pro_widget_time_field').hasClass('ui-timepicker-input')){

		//alert("widget");

		alert("<?php echo __("Please select date again","insightpro_restaurant");?>");

		}

	});
	<?php } ?>


});



</script>

<?php

	} // !is_checkout

	

?>



<script>

function checkHolidaysBycRestro( date ){

var $return=true;

var $returnclass ="available";

//alert(date);



$checkdate = jQuery.datepicker.formatDate("mm/dd/yy", date);

$checkday	= jQuery.datepicker.formatDate("D", date);

//alert($checkday+' | '+date.getDay());

//alert(date.getDay());

$checkdaynum=date.getDay();

//alert($checkdaynum);

//var day = date.getDay();



//console.log($checkdaynum);



<?php

// do selection disable on closing days as per allowable pickup days settings

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='take_away' && !empty($insight_pro_pickup_closingdays)){

?>

if(jQuery.inArray($checkdaynum,$insight_pro_pickup_closingdays)!=-1){

$return = false;

$returnclass= "unavailable insight_pro_pickup_weekly_closing_day";

//alert($checkday+'||<?php //echo $allowable_pickup_days_js_array;?>');

//alert('in condition 1');

}

/***************************to_include************************/

/***************************to_include************************/

<?php

}

// do selection disable on closing days as per allowable delivery days settings

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='levering' && !empty($insight_pro_delivery_closingdays))

{

?>

if(jQuery.inArray($checkdaynum,$insight_pro_delivery_closingdays)!=-1){

$return = false;

$returnclass= "unavailable insight_pro_delivery_weekly_closing_day";

//alert('in condition 2');

}

/***************************to_include************************/

/***************************to_include************************/

<?php 

}



// do selection disable on closing days as per allowable dinein days settings

if($insight_pro_delivery_widget_cookie_array['insight_pro_widget_type_field']=='dinein' && !empty($insight_pro_dinein_closingdays))

{

?>

if(jQuery.inArray($checkdaynum,$insight_pro_dinein_closingdays)!=-1){

$return = false;

$returnclass= "unavailable insight_pro_dinein_weekly_closing_day";

//alert('in condition 2');

}

/***************************to_include************************/

/***************************to_include************************/

<?php 

}

?>





//function return value



return [$return,$returnclass];

}// Selectd  Holiday Diasable End

</script>

<?php

	

} //insight_pro_footer_script



add_action('wp_footer','insight_pro_footer_script');

//add_action('wp_footer','woocommerce_package_rates',999);

add_action('wp_footer','insight_pro_recalculate_shipping');



function insight_pro_recalculate_shipping(){

foreach (WC()->cart->get_cart() as $key => $value) {



    WC()->cart->set_quantity($key, $value['quantity']+1);



    WC()->cart->set_quantity($key, $value['quantity']);



    break;

}

}



?>