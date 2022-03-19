function insight_pro_pickup_timeslot_add_another(){
	var byc_pickup_count_hidden_val = jQuery("#insight_pro_pickup_timeslot_count_hidden_field").val();
	var incrementVal = parseInt(byc_pickup_count_hidden_val)+1;
	jQuery("#insight_pro_pickup_timeslot_count_hidden_field").val(incrementVal);
	
	jQuery('.insight_pro_pickup_timeslot_more_options').append('<li class="pickup_timeslot_container_'+incrementVal+'" style="margin-bottom: 20px;"><div class="pickup_timeslot_container_'+incrementVal+'" style="width: 100%;"><div class="starttime_body"><input type="time" name="insight_pro_pickup_timeslot['+incrementVal+'][start_timeslot]" id="insight_pro_pickup_timeslot" value="" /></div><div  class="endtime_body"><input type="time" name="insight_pro_pickup_timeslot['+incrementVal+'][end_timeslot]" id="insight_pro_pickup_timeslot" value="" /></div><div class="days_body"><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="0" />Sun</span><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="1" />Mon</span><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="2" />Tue</span><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="3" />Wed</span><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="4" />Thu</span><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="5" />Fri</span><span><input type="checkbox" name="insight_pro_pickup_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_pickup_timeslot" value="6" />Sat</span></div><span id="del_pickup_timeslot" class="" style="" >X</span></div></li>');
}



function insight_pro_delivery_timeslot_add_another(){
	var byc_delivery_count_hidden_val = jQuery("#insight_pro_delivery_timeslot_count_hidden_field").val();
	var incrementVal = parseInt(byc_delivery_count_hidden_val)+1;
	jQuery("#insight_pro_delivery_timeslot_count_hidden_field").val(incrementVal);
	
	jQuery('.insight_pro_delivery_timeslot_more_options').append('<li class="delivery_timeslot_container_'+incrementVal+'" style="margin-bottom: 20px;"><div class="delivery_timeslot_container_'+incrementVal+'" style="width: 100%;"><div class="starttime_body"><input type="time" name="insight_pro_delivery_timeslot['+incrementVal+'][start_timeslot]" id="insight_pro_delivery_timeslot" value="" /></div><div  class="endtime_body"><input type="time" name="insight_pro_delivery_timeslot['+incrementVal+'][end_timeslot]" id="insight_pro_delivery_timeslot" value="" /></div><div class="days_body"><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="0" />Sun</span><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="1" />Mon</span><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="2" />Tue</span><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="3" />Wed</span><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="4" />Thu</span><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="5" />Fri</span><span><input type="checkbox" name="insight_pro_delivery_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_delivery_timeslot" value="6" />Sat</span></div><span id="del_delivery_timeslot" class="" style="" >X</span></div></li>');
}


function insight_pro_dinein_timeslot_add_another(){
	var byc_dinein_count_hidden_val = jQuery("#insight_pro_dinein_timeslot_count_hidden_field").val();
	var incrementVal = parseInt(byc_dinein_count_hidden_val)+1;
	jQuery("#insight_pro_dinein_timeslot_count_hidden_field").val(incrementVal);
	
	jQuery('.insight_pro_dinein_timeslot_more_options').append('<li class="dinein_timeslot_container_'+incrementVal+'" style="margin-bottom: 20px;"><div class="dinein_timeslot_container_'+incrementVal+'" style="width: 100%;"><div class="starttime_body"><input type="time" name="insight_pro_dinein_timeslot['+incrementVal+'][start_timeslot]" id="insight_pro_dinein_timeslot" value="" /></div><div  class="endtime_body"><input type="time" name="insight_pro_dinein_timeslot['+incrementVal+'][end_timeslot]" id="insight_pro_dinein_timeslot" value="" /></div><div class="days_body"><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="0" />Sun</span><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="1" />Mon</span><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="2" />Tue</span><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="3" />Wed</span><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="4" />Thu</span><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="5" />Fri</span><span><input type="checkbox" name="insight_pro_dinein_timeslot['+incrementVal+'][time_slot_for_day][]" id="insight_pro_dinein_timeslot" value="6" />Sat</span></div><span id="del_dinein_timeslot" class="" style="" >X</span></div></li>');
}

jQuery(document).on('click','#del_pickup_timeslot',function(e){

 var alert_confirmation = confirm("Do you want to remove it.");
	if (alert_confirmation == true) {
		var custom_slot_to_remove=jQuery(this).parent().prop('className');
		jQuery("div."+custom_slot_to_remove).remove();
	} else {

	}
});


jQuery(document).on('click','#del_delivery_timeslot',function(e){

 var alert_confirmation = confirm("Do you want to remove it.");
	if (alert_confirmation == true) {
		var custom_slot_to_remove=jQuery(this).parent().prop('className');
		jQuery("div."+custom_slot_to_remove).remove();
	} else {

	}
});


jQuery(document).on('click','#del_dinein_timeslot',function(e){

 var alert_confirmation = confirm("Do you want to remove it.");
	if (alert_confirmation == true) {
		var custom_slot_to_remove=jQuery(this).parent().prop('className');
		jQuery("div."+custom_slot_to_remove).remove();
	} else {

	}
});