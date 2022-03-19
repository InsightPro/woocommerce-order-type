<?php

// add mmenu


include('insight_pro_holiday_management.php');

include('insight_pro_modification_request_details.php');

include('insight_pro_tweak_features.php');

include('insight_pro_timeslot_setting.php');


add_action('admin_menu','insight_pro_add_plugin_menu');

function insight_pro_add_plugin_menu(){


global $insight_pro_admin_settings;
global $insight_pro_timeslot_settings;
global $insight_pro_admin_holiday_settings;

global $insight_pro_admin_modification_request;

global $insight_pro_tweak_features_settings;


$insight_pro_admin_settings = add_menu_page( 'PizzaPOOL', 'PizzaPOOL', 'manage_options', 'insight_pro_general_settings', 'insight_pro_admin_general_settings_form' );

$insight_pro_timeslot_settings = add_submenu_page('insight_pro_general_settings', 'Timeslot Setting','Timeslot Setting', 'manage_options', 'insight_pro_admin_timeslot_settings', 'insight_pro_free_admin_timeslot_form');

$insight_pro_admin_holiday_settings = add_submenu_page('insight_pro_general_settings', 'Holiday Management','Holiday Management', 'manage_options', 'insight_pro_admin_holiday_settings', 'insight_pro_free_admin_holiday_form');



$insight_pro_admin_modification_request = add_submenu_page('insight_pro_general_settings', 'Custom Modification Request','Custom Modification Request', 'manage_options', 'insight_pro_admin_modification_request_settings', 'insight_pro_admin_modification_request_form');

$insight_pro_tweak_features_settings = add_submenu_page('insight_pro_general_settings', 'Tweak Features', 'Tweak Features', 'manage_options', 'insight_pro_admin_tweak_features_settings', 'insight_pro_tweak_features_admin_form');
}





function insight_pro_admin_general_settings_form(){

?>

			<div class="wrap">

			<h1>PizzaPOOL Restaurant Pickup | Delivery | Dine in management settings panel</h1>



            <div class="" style="width:80%; float:left;">



			<form method="post" class="form_insight_pro_plugin_settings" action="options.php">



				<?php



					settings_fields("section");



					do_settings_sections("insight_pro_plugin_options");      



					submit_button(); 



				?>          



			</form>



			</div>



<?php 

}



function insight_pro_order_type(){

$ipsl_allowed_order_types=get_option('insight_pro_order_type');

?>

<label>

    <input type="checkbox" name="insight_pro_order_type[levering]" id="insight_pro_order_type" class="insight_pro_admin_element_field radio" value="yes" <?php if(is_array($ipsl_allowed_order_types) && array_key_exists('levering',$ipsl_allowed_order_types) && $ipsl_allowed_order_types['levering']=='yes'){?> checked="checked"<?php }?> />Delivery

</label>

  

<label>

  <input type="checkbox" name="insight_pro_order_type[take_away]" id="insight_pro_order_type" class="insight_pro_admin_element_field radio" value="yes" <?php if(is_array($ipsl_allowed_order_types) && array_key_exists('take_away',$ipsl_allowed_order_types) && $ipsl_allowed_order_types['take_away']=='yes'){?> checked="checked"<?php }?> />Pickup    

</label>



<label>

  <input type="checkbox" name="insight_pro_order_type[dinein]" id="insight_pro_order_type" class="insight_pro_admin_element_field radio" value="yes" <?php if(is_array($ipsl_allowed_order_types) && array_key_exists('dinein',$ipsl_allowed_order_types) &&  $ipsl_allowed_order_types['dinein']=='yes'){?> checked="checked"<?php }?> />Dine in    

</label>



<?php 

	} 



	function insight_pro_chekout_page_section_heading()

	{

?>



 <input type="text" name="insight_pro_chekout_page_section_heading" id="insight_pro_chekout_page_section_heading" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_chekout_page_section_heading')); ?>"/>



 <label><?php echo __('Texts to display on checkout page as section heading.','insightpro_restaurant');?></label><br />



 <span style="color:#a0a5aa">(Eg: Desired delivery date and time)</span>



<?php

	}



	function insight_pro_chekout_page_date_label()

	{

?>



 <input type="text" name="insight_pro_chekout_page_date_label" id="insight_pro_chekout_page_date_label" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_chekout_page_date_label')); ?>"/>



 <label><?php echo __('displayed as calendar label on checkout page.','insightpro_restaurant');?></label><br />



 <span style="color:#a0a5aa">(Eg: Select date)</span>

<?php

	}



	function insight_pro_chekout_page_time_label()

	{

?>



 <input type="text" name="insight_pro_chekout_page_time_label" id="insight_pro_chekout_page_time_label" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_chekout_page_time_label')); ?>"/>



 <label><?php echo __('displayed as time drop-down label on checkout page.','insightpro_restaurant');?></label><br />



<span style="color:#a0a5aa">(Eg: Select time)</span>

<?php

	}



	function insight_pro_chekout_page_order_type_label()

	{

?>



 <input type="text" name="insight_pro_chekout_page_order_type_label" id="insight_pro_chekout_page_order_type_label" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_chekout_page_order_type_label')); ?>"/>



 <label><?php echo __('displayed as time drop-down label on checkout page.','insightpro_restaurant');?></label><br />



 <span style="color:#a0a5aa">(Eg: Select order type)</span>



<?php

	}



	function insight_pro_hours_format()

	{                                        

?>



 <select id="insight_pro_hours_format" name="insight_pro_hours_format" style="width:35%;" >

<?php var_dump(get_option('insight_pro_hours_format')) ?>

 <option   value="H:i" <?php if( get_option('insight_pro_hours_format')=='H:i'){?> selected="selected"<?php }?> >24 hours</option>



 <option   value="h:i A"<?php if( get_option('insight_pro_hours_format')=='h:i A'){?> selected="selected"<?php }?> >12 hours</option>



 </select>



 <label><?php echo __('24 hours or 12 hours with AM / PM.','insightpro_restaurant');?> </label>



<?php

	}



	function insight_pro_preorder_days()

	{

?>

<input type="number" name="insight_pro_preorder_days" id="insight_pro_preorder_days" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_preorder_days')); ?>"/>



<label><?php echo __('Leave blank to not set and pre-order days, this is number of days customer can pre order in advance.','insightpro_restaurant');?></label><br />

<span style="color:#a0a5aa">(Eg: 10 Only number)</span>

<?php

	}



	function insight_pro_time_field_validation(){

		

		$insight_pro_time_field_validation = get_option('insight_pro_time_field_validation');

		if($insight_pro_time_field_validation == 'yes'){

			$checked = 'checked="checked"';

		}else{

			$checked = '';

		}

		?>

			<input type="checkbox" name="insight_pro_time_field_validation" id="insight_pro_time_field_validation" value="yes" <?php echo $checked;?>/>

            <label><?php echo __('Make time selection mendatory.','insightpro_restaurant');?></label>

		<?php

	}



	function insight_pro_pickup_hours()

	{

?>



<label><?php echo __('From','insightpro_restaurant');?></label>



<input type="time" name="insight_pro_pickup_hours_from" id="insight_pro_pickup_hours_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_pickup_hours_from')); ?>" />



<label><?php echo __('To','insightpro_restaurant');?></label>



<input type="time" name="insight_pro_pickup_hours_to" id="insight_pro_pickup_hours_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_pickup_hours_to')); ?>" />



<label><?php echo __('Allowable Pickup Time.','insightpro_restaurant');?></label>

<?php

	}



	function insight_pro_delivery_hours()

	{

?>

<label><?php echo __('From','insightpro_restaurant');?></label>



<input type="time" name="insight_pro_delivery_hours_from" id="insight_pro_delivery_hours_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_delivery_hours_from')); ?>" />



<label><?php echo __('To','insightpro_restaurant');?></label>



<input type="time" name="insight_pro_delivery_hours_to" id="insight_pro_delivery_hours_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_delivery_hours_to')); ?>" />



<label><?php echo __('Allowable Delivery Time.','insightpro_restaurant');?></label>



<?php

	}



	function insight_pro_dinein_hours()

	{

?>

<label><?php echo __('From','insightpro_restaurant');?></label>



<input type="time" name="insight_pro_dinein_hours_from" id="insight_pro_dinein_hours_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_dinein_hours_from')); ?>" />



<label><?php echo __('To','insightpro_restaurant');?></label>



<input type="time" name="insight_pro_dinein_hours_to" id="insight_pro_dinein_hours_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_dinein_hours_to')); ?>" />



<label><?php echo __('Allowable Dine in Time.','insightpro_restaurant');?></label>



<?php

	}



	function insight_pro_delivery_times()

	{

?>



<input type="text" name="insight_pro_delivery_times" id="insight_pro_delivery_times" style="width:30%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_delivery_times')); ?>" />



<label> <?php echo __('This is visible on widget front end if customer has chosen delivery.','insightpro_restaurant');?></label><br />



<span style="color:#a0a5aa">(Eg: Minimum Delivery time 30 minutes)</span>



<?php

	}

	function insight_pro_takeaway_lable()

	{

?>



<input type="text" name="insight_pro_takeaway_lable" id="insight_pro_takeaway_lable" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_takeaway_lable'); ?>" />



<label> <?php echo __('Take away label shown on checkout page and in widget.','insightpro_restaurant');?></label><br />

<?php		

	}



	function insight_pro_delivery_lable()

	{

?>



<input type="text" name="insight_pro_delivery_lable" id="insight_pro_delivery_lable" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_delivery_lable'); ?>" />



<label> <?php echo __('Delivery label shown on checkout page and in widget.','insightpro_restaurant');?></label><br />

<?php		



	}



	function insight_pro_dinein_lable(){

		?>
		<input type="text" name="insight_pro_dinein_lable" id="insight_pro_dinein_lable" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_dinein_lable'); ?>" />



		<label> <?php echo __('Dinein label shown on checkout page and in widget.','insightpro_restaurant');?></label><br />

		<?php
	}



	function insight_pro_dinein_service_charge(){

		?>
		<input type="text" name="insight_pro_dinein_service_charge" id="insight_pro_dinein_service_charge" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_dinein_service_charge'); ?>" />



		<label> <?php echo __('% of Dinein Service charge. ','insightpro_restaurant');?></label><br />

		<?php
	}	


	function insight_pro_userFirstOrderDiscount(){

		?>
		<input type="text" name="insight_pro_userFirstOrderDiscount" id="insight_pro_userFirstOrderDiscount" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_userFirstOrderDiscount'); ?>" />



		<label> <?php echo __('% Of User First Order Discount. ','insightpro_restaurant');?></label><br />

		<?php
	}


	function insight_pro_date_field_text()

	{

?>

<input type="text" name="insight_pro_date_field_text" id="insight_pro_date_field_text" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_date_field_text'); ?>" />



<label> <?php echo __('Placeholder text for date-picker calendar input box.','insightpro_restaurant');?></label><br />

<?php		

	}



	function insight_pro_time_field_text()

	{

?>

<input type="text" name="insight_pro_time_field_text" id="insight_pro_time_field_text" style="width:50%; padding:7px;" value="<?php echo get_option('insight_pro_time_field_text'); ?>" />



<label> <?php echo __('Placeholder text for time drop-down input box.','insightpro_restaurant');?></label><br />

<?php		

	}



	function insight_pro_orders_delivered()

	{

?>

<input type="text" name="insight_pro_orders_delivered" id="insight_pro_orders_delivered" style="width:50%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_orders_delivered')); ?>" />



<label> <?php echo __('This is the text is shown on Order details page of customer side.','insightpro_restaurant');?></label><br />



<span style="color:#a0a5aa">(<?php echo __('Eg: The order will be delivered on','insightpro_restaurant');?>  [bycrestro_delivery_date] <?php echo __('at','insightpro_restaurant');?>   [bycrestro_delivery_time])</span>

<?php

	}



	function insight_pro_orders_pick_up()

	{

?>

<input type="text" name="insight_pro_orders_pick_up" id="insight_pro_orders_pick_up" style="width:50%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_orders_pick_up')); ?>" />



<label> <?php echo __('This is the text is shown on Order details page of customer side.','insightpro_restaurant');?></label><br />



<span style="color:#a0a5aa">(<?php echo __('Eg: The order can be Pick Up on','insightpro_restaurant');?>  [bycrestro_pickup_date] <?php echo __('at','insightpro_restaurant');?>  [bycrestro_pickup_time])</span>

<?php

	}



	function insight_pro_orders_dinein()

	{

?>

<input type="text" name="insight_pro_orders_dinein" id="insight_pro_orders_dinein" style="width:50%; padding:7px;" value="<?php printf( __('%s','insightpro_restaurant'),get_option('insight_pro_orders_dinein')); ?>" />



<label> <?php echo __('This is the text is shown on Order details page of customer side.','insightpro_restaurant');?></label><br />



<span style="color:#a0a5aa">(<?php echo __('Eg: Please be appear on','insightpro_restaurant');?>  [bycrestro_dine_in_date] <?php echo __('at','insightpro_restaurant');?>  [bycrestro_dine_in_time] <?php echo __('to have a wonderful dining experience','insightpro_restaurant');?>)</span>

<?php

	}



	function insight_pro_widget_field_position()

	{                                        

?>

<select id="insight_pro_widget_field_position" name="insight_pro_widget_field_position" style="width:35%;" >


<option   value="" ><?php echo __('Do not show on order complete page','insightpro_restaurant');?> </option>

<option   value="top" <?php if( get_option('insight_pro_widget_field_position')=='top'){?> selected="selected"<?php }?> ><?php echo __('Show on top','insightpro_restaurant');?></option>

<option   value="bottom"<?php if( get_option('insight_pro_widget_field_position')=='bottom'){?> selected="selected"<?php }?> ><?php echo __('Show at bottom','insightpro_restaurant');?></option>



</select>



<label><?php echo __('Choose if date time text have to be shown on top (before order product list) or bottom (after product list).','insightpro_restaurant');?> </label>

<?php } 



add_action('admin_init', 'insight_pro_plugin_settings_fields');



function insight_pro_plugin_settings_fields()

	{



	add_settings_section("section", "All Settings", null, "insight_pro_plugin_options");

	

	add_settings_field("insight_pro_order_type", __('Allow order for:','insight_pro'), "insight_pro_order_type", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_preorder_days", __('Preorder Days:','insight_pro'), "insight_pro_preorder_days", "insight_pro_plugin_options", "section");

	

	add_settings_field("insight_pro_time_field_validation", __('Time field is required:','insight_pro'), "insight_pro_time_field_validation", "insight_pro_plugin_options", "section");

	

	add_settings_field("insight_pro_pickup_hours", __('Pickup Hours:','insight_pro'), "insight_pro_pickup_hours", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_delivery_hours", __('Delivery Hours:','insight_pro'), "insight_pro_delivery_hours", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_dinein_hours", __('Dine in Hours:','insight_pro'), "insight_pro_dinein_hours", "insight_pro_plugin_options", "section");



	add_settings_field("byinsightpro_minimum_delivery_times", __('Minimum delivery Times:','insight_pro'), "byinsightpro_delivery_times", "byinsightpro_plugin_options", "section");



	add_settings_field("insight_pro_takeaway_lable", __('Pickup label text:','insight_pro'), "insight_pro_takeaway_lable", "insight_pro_plugin_options", "section");	



	add_settings_field("insight_pro_delivery_lable", __('Delivery label text:','insight_pro'), "insight_pro_delivery_lable", "insight_pro_plugin_options", "section");

	

	add_settings_field("insight_pro_dinein_lable", __('Dine in label text:','insight_pro'), "insight_pro_dinein_lable", "insight_pro_plugin_options", "section");

	add_settings_field("insight_pro_dinein_service_charge", __('Dine in Service Charge:','insight_pro'), "insight_pro_dinein_service_charge", "insight_pro_plugin_options", "section");

	add_settings_field("insight_pro_userFirstOrderDiscount", __('User first order Discount:','insight_pro'), "insight_pro_userFirstOrderDiscount", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_date_field_text", __('Date field text:','insight_pro'), "insight_pro_date_field_text", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_time_field_text", __('Time field text:','insight_pro'), "insight_pro_time_field_text", "insight_pro_plugin_options", "section");	



	add_settings_field("insight_pro_orders_delivered", __('The order will be delivered:','insight_pro'), "insight_pro_orders_delivered", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_orders_pick_up", __('The order can be Pickup:','insight_pro'), "insight_pro_orders_pick_up", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_orders_dinein", __('Dine in schedule:','insight_pro'), "insight_pro_orders_dinein", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_widget_field_position", __('Position of the text in the orders page:','insight_pro'), "insight_pro_widget_field_position", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_chekout_page_section_heading", __('Checkout page section heading','insight_pro'), "insight_pro_chekout_page_section_heading", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_chekout_page_order_type_label", __('Order type label on checkout page:','insight_pro'), "insight_pro_chekout_page_order_type_label", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_chekout_page_date_label", __('Calendar label on checkout page:','insight_pro'), "insight_pro_chekout_page_date_label", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_chekout_page_time_label", __('Time field label on checkout page:','insight_pro'), "insight_pro_chekout_page_time_label", "insight_pro_plugin_options", "section");



	add_settings_field("insight_pro_hours_format", __('Time format:','insight_pro'), "insight_pro_hours_format", "insight_pro_plugin_options", "section");

	

	

	register_setting("section", "insight_pro_order_type");



	register_setting("section", "insight_pro_preorder_days");

		

	register_setting("section", "insight_pro_time_field_validation");



	register_setting("section", "insight_pro_pickup_hours_from");



	register_setting("section", "insight_pro_pickup_hours_to");



	register_setting("section", "insight_pro_delivery_hours_from");



	register_setting("section", "insight_pro_delivery_hours_to");



	register_setting("section", "insight_pro_dinein_hours_from");



	register_setting("section", "insight_pro_dinein_hours_to");



	register_setting("section", "insight_pro_delivery_times");



	register_setting("section", "insight_pro_takeaway_lable");



	register_setting("section", "insight_pro_delivery_lable");

	

	register_setting("section", "insight_pro_dinein_lable");

	register_setting("section", "insight_pro_dinein_service_charge");
	register_setting("section", "insight_pro_userFirstOrderDiscount");



	register_setting("section", "insight_pro_date_field_text");



	register_setting("section", "insight_pro_time_field_text");	



	register_setting("section", "insight_pro_orders_delivered");



	register_setting("section", "insight_pro_orders_pick_up");

	

	register_setting("section", "insight_pro_orders_dinein");



	register_setting("section", "insight_pro_widget_field_position");



	register_setting("section", "insight_pro_chekout_page_section_heading");



	register_setting("section", "insight_pro_chekout_page_order_type_label");



	register_setting("section", "insight_pro_chekout_page_date_label");



	register_setting("section", "insight_pro_chekout_page_time_label");



	register_setting("section", "insight_pro_hours_format");



	}

?>