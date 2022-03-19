<?php function insight_pro_free_admin_holiday_form(){?>


	<style>


		.insight_pro_pickup_holidays span{padding-right: 15px;}


		.insight_pro_delivery_holidays span{padding-right: 15px;}
		
		.insight_pro_dinein_holidays span{padding-right: 15px;}


	</style>


	


	<div class="wrap">


        <h1>Holiday management</h1>


        <form method="post" class="form_insight_pro_free_plugin_settings" action="options.php">


				<?php


                settings_fields("holidaymanagement");


                do_settings_sections("insight_pro_free_holidaymanagement_options");  


                submit_button();


                ?> 


		</form>


    </div>


	<?php


}








function insight_pro_free_pickup_holiday_management(){


	$insight_pro_pickup_holidays = get_option('insight_pro_pickup_holidays');


	if(empty($insight_pro_pickup_holidays)){


		$insight_pro_pickup_holidays=array();


		}		


	


	


	echo '<div class="insight_pro_pickup_holidays">';


	if(in_array('0',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="0" checked><span>Sunday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="0"><span>Sunday</span>';


		}


		


	if(in_array('1',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="1" checked><span>Monday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="1"><span>Monday</span>';


		}


		


	if(in_array('2',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="2" checked><span>Tuesday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="2"><span>Tuesday</span>';


		}


		


	if(in_array('3',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="3" checked><span>Wednesday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="3"><span>Wednesday</span>';


		}


		


	if(in_array('4',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="4" checked><span>Thursday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="4"><span>Thuurday</span>';


		}


		


	if(in_array('5',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="5" checked><span>Friday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="5"><span>Friday</span>';


		}


		


	if(in_array('6',$insight_pro_pickup_holidays)){


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="6" checked><span>Saturday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_pickup_holidays[]" id="insight_pro_pickup_holidays" value="6"><span>Saturday</span>';


		}


	     


   echo '</div>';


	


}








function insight_pro_free_delivery_holiday_management(){


	


	$insight_pro_delivery_holidays = get_option('insight_pro_delivery_holidays');


	if(empty($insight_pro_delivery_holidays)){


		$insight_pro_delivery_holidays=array();


		}


	


	echo '<div class="insight_pro_delivery_holidays">';


	if(in_array('0',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="0" checked><span>Sunday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="0"><span>Sunday</span>';


		}


		


	if(in_array('1',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="1" checked><span>Monday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="1"><span>Monday</span>';


		}


		


	if(in_array('2',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="2" checked><span>Tuesday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="2"><span>Tuesday</span>';


		}


		


	if(in_array('3',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="3" checked><span>Wednesday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="3"><span>Wednesday</span>';


		}


		


	if(in_array('4',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="4" checked><span>Thursday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="4"><span>Thuurday</span>';


		}


		


	if(in_array('5',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="5" checked><span>Friday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="5"><span>Friday</span>';


		}


		


	if(in_array('6',$insight_pro_delivery_holidays)){


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="6" checked><span>Saturday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_delivery_holidays[]" id="insight_pro_delivery_holidays" value="6"><span>Saturday</span>';


		}


	     


   echo '</div>';


}



function insight_pro_free_dinein_holiday_management(){


	$insight_pro_dinein_holidays = get_option('insight_pro_dinein_holidays');
	


	if(empty($insight_pro_dinein_holidays)){


		$insight_pro_dinein_holidays=array();


		}		


	


	


	echo '<div class="insight_pro_dinein_holidays">';


	if(in_array('0',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="0" checked><span>Sunday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="0"><span>Sunday</span>';


		}


		


	if(in_array('1',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="1" checked><span>Monday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="1"><span>Monday</span>';


		}


		


	if(in_array('2',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="2" checked><span>Tuesday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="2"><span>Tuesday</span>';


		}


		


	if(in_array('3',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="3" checked><span>Wednesday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="3"><span>Wednesday</span>';


		}


		


	if(in_array('4',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="4" checked><span>Thursday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="4"><span>Thuurday</span>';


		}


		


	if(in_array('5',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="5" checked><span>Friday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="5"><span>Friday</span>';


		}


		


	if(in_array('6',$insight_pro_dinein_holidays)){


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="6" checked><span>Saturday</span>';	}else{


		echo '<input type="checkbox" name="insight_pro_dinein_holidays[]" id="insight_pro_dinein_holidays" value="6"><span>Saturday</span>';


		}


	     


   echo '</div>';


	


}













add_action('admin_init', 'insight_pro_free_plugin_holiday_manage_settings_fields');





function insight_pro_free_plugin_holiday_manage_settings_fields(){





	add_settings_section("holidaymanagement", "", null, "insight_pro_free_holidaymanagement_options");





	add_settings_field("insight_pro_pickup_holidays", __('Pickup Holidays:','byinsightpro-woo-order-delivery-time'), "insight_pro_free_pickup_holiday_management", "insight_pro_free_holidaymanagement_options", "holidaymanagement");





	add_settings_field("insight_pro_delivery_holidays", __('Delivery Holidays:','byinsightpro-woo-order-delivery-time'), "insight_pro_free_delivery_holiday_management", "insight_pro_free_holidaymanagement_options", "holidaymanagement");
	
	
	
	add_settings_field("insight_pro_dinein_holidays", __('Dine in Holidays:','byinsightpro-woo-order-delivery-time'), "insight_pro_free_dinein_holiday_management", "insight_pro_free_holidaymanagement_options", "holidaymanagement");





	register_setting("holidaymanagement", "insight_pro_pickup_holidays");


	register_setting("holidaymanagement", "insight_pro_delivery_holidays");
	
	
	register_setting("holidaymanagement", "insight_pro_dinein_holidays");





	}


?>