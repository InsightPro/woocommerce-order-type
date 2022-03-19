<?php function insight_pro_free_admin_timeslot_form(){?>
	<div class="wrap">
        <h1>Time slot setting</h1>
        <form method="post" class="form_insight_pro_free_plugin_settings" action="options.php">
				<?php
                settings_fields("timeslot");
                do_settings_sections("insight_pro_timeslot_options");  
                submit_button();
                ?> 
		</form>
    </div>

	<?php
}

function insight_pro_enable_timeslot(){
	
	$insight_pro_enable_timeslot = get_option('insight_pro_enable_timeslot');
	if($insight_pro_enable_timeslot == 'yes'){
		$checkedVal = 'checked';
	}else{
		$checkedVal = '';
	}
	echo '<input type="checkbox" name="insight_pro_enable_timeslot" id="insight_pro_enable_timeslot" value="yes" '.$checkedVal.'/>';
	
}

include('insight_pro_pickup_timeslot.php');

include('insight_pro_delivery_timeslot.php');

include('insight_pro_dinein_timeslot.php');





add_action('admin_init', 'insight_pro_timeslot_settings_fields');

function insight_pro_timeslot_settings_fields(){	

add_settings_section("timeslot", "", null, "insight_pro_timeslot_options");

add_settings_field("insight_pro_enable_timeslot", "Enable Timeslot", "insight_pro_enable_timeslot", "insight_pro_timeslot_options", "timeslot");

add_settings_field("insight_pro_pickup_timeslot", "Pickup Timeslot", "insight_pro_pickup_timeslot", "insight_pro_timeslot_options", "timeslot");

add_settings_field("insight_pro_delivery_timeslot", "Delivery Timeslot", "insight_pro_delivery_timeslot", "insight_pro_timeslot_options", "timeslot");

add_settings_field("insight_pro_dinein_timeslot", "Dinein Timeslot", "insight_pro_dinein_timeslot", "insight_pro_timeslot_options", "timeslot");


register_setting("timeslot", "insight_pro_enable_timeslot");

register_setting("timeslot", "insight_pro_pickup_timeslot");

register_setting("timeslot", "insight_pro_delivery_timeslot");

register_setting("timeslot", "insight_pro_dinein_timeslot");



}
?>