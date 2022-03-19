<?php



function insight_pro_admin_modification_request_form(){



	?>



	<div class="wrap">



        <h1>PizzaPOOL plugins custom modification request</h1>



				<?php



                settings_fields("modificationrequest");



                do_settings_sections("insight_pro_modificationrequest_options");  



                //submit_button();



                ?> 



    </div>



	<?php



}







function insight_pro_custom_modification_request_form(){



	



	$admin_email = get_option( 'admin_email' );



	



	if(isset($_REQUEST['insight_pro_new_customer_details_send'])){



		



		



		$insight_pro_current_website_url = esc_url_raw($_REQUEST['insight_pro_current_website_url']);



		$insight_pro_new_customer_name = sanitize_text_field($_REQUEST['insight_pro_new_customer_name']);



		$insight_pro_new_customer_email = sanitize_email($_REQUEST['insight_pro_new_customer_email']);



		$insight_pro_new_customer_details = sanitize_text_field($_REQUEST['insight_pro_new_customer_details']);



		



		$headers  = "MIME-Version: 1.0\r\n";



		$headers .= "Content-Type: text/html; charset=UTF-8";



		$headers .= "From: {$insight_pro_new_customer_name} <{$insight_pro_new_customer_email}>\r\n";



		$headers .= "Cc: Developer <developer.insightprobd@gmail.com>";



		



		



		$to = 'insightprobd@gmail.com';



		



		$message = '<b>Site Url:</b>&nbsp;'.$insight_pro_current_website_url.'<br />';



		$message .= '<b>Name:</b>&nbsp;'.$insight_pro_new_customer_name.'<br />';



		$message .= '<b>Email:</b>&nbsp;'.$insight_pro_new_customer_email.'<br />';



		$message .= '<b>Details:</b>&nbsp;'.$insight_pro_new_customer_details;



		



		



		if(wp_mail( $to, 'This mail for a new customization request - Dine In.', $message, $headers )){



			echo '<p class="success_mail_send">'.__('We will get back to you soon regarding your request. Alternatively you can query about your request by emailing to insightprobd@gmail.com', 'insightpro_restaurant').'</p><br />';



		}else{



		echo '<p>Unable to send support request email, please send emial manually to insightprobd@gmail.com</p>';



			}	



		



	}



	?>



    <style>



		#form_url



		{



			width:85%;



			height:40px;



			border:1px #ffa500 solid;



			background:transparent;



			font-size:14px;



			padding:0 5px;



			float:none;



		}



		#form_name



		{



			width:85%;



			height:40px;



			border:1px #ffa500 solid;



			background:transparent;



			font-size:14px;



			padding:0 5px;



			float:none;



		}



		



		#form_mail



		{



			width:85%;



			height:40px;



			border:1px #ffa500 solid;



			background:transparent;



			font-size:14px;



			padding:0 5px;



			float:none;



		}



		



		#form_txt



		{



			width:85%;



			height:200px;



			border:1px #ffa500 solid;



			background:transparent;



			font-size:14px;



		}



		



		#form_submit



		{



			width:25%;



			height:40px;



			background:#ffa500;



			font-size:16px;



			border:0;



			color:#fff;



			float:right;



			margin-right: 10px;



			cursor:pointer;



		}	



		.form-group {



			margin-bottom: 1rem;



		}



		.form-group label[for=customer_name]{margin-right: 12px;}



		.form-group label[for=site_url]{margin-right: 4px;}



		.form-group label[for=customer_email]{margin-right: 16px;}



		.form-group label[for=customer_details]{vertical-align: top;margin-right: 10px;}



		.customer_details_form_container{width:50%;}



		.success_mail_send{background-color: #ffa500;width: 50%;padding: 10px;text-align: center;color: #000;}



	</style>



    



    <script type="text/javascript" language="javascript">



	



jQuery(document).ready(function(){



	



	jQuery('#insight_pro_current_user_form_validation').submit(function () {



		



		var bycwooodt_form_name = jQuery.trim(jQuery('#form_name').val());



		var bycwooodt_form_mail = jQuery.trim(jQuery('#form_mail').val());



		var bycwooodt_form_txt = jQuery.trim(jQuery('#form_txt').val());



		



	//alert(locationId+'--'+deliveryDate+'--'+deliveryTime);



		// Check if empty of not



		



		if (bycwooodt_form_name  === '') {



			alert('<?php echo __('Please enter your name', 'insightpro_restaurant');?>');



			jQuery('#form_name').focus();



			return false;



		}



		if (bycwooodt_form_mail  === '') {



			alert('<?php echo __('Please enter your email', 'insightpro_restaurant');?>');	



			jQuery('#form_mail').focus();		



			return false;



		}



		if (bycwooodt_form_txt  === '') {



			alert('<?php echo __('Please enter modification details', 'insightpro_restaurant');?>');



			jQuery('#form_txt').focus();



			return false;



		}



		



		if(jQuery("#insight_pro_customer_agree").prop("checked") == true){



                //alert("Checkbox is checked.");



            }



        else if(jQuery("#insight_pro_customer_agree").prop("checked") == false){



			alert("<?php echo __('Please check the checkbox before sending your information', 'insightpro_restaurant');?>");



			return false;



        }



	});



	



});



	



	</script>



    <div class="customer_details_form_container">



	<form name="frm" method="post" id="insight_pro_current_user_form_validation" >



    <div class="form-group">



      <label for="site_url"><?php echo __('Site Url', 'insightpro_restaurant');?>:</label>



      <input type="text" class="form-control" name="insight_pro_current_website_url" id="form_url" readonly="readonly" value="<?php echo get_site_url();?>"/>



    </div>



    



    <div class="form-group">



    <label for="customer_name"><?php echo __('Name', 'insightpro_restaurant');?>:</label>



      <input type="text" class="form-control" name="insight_pro_new_customer_name" id="form_name" value=""/>



    </div>



    



    <div class="form-group">



      <label for="customer_email"><?php echo __('Email', 'insightpro_restaurant');?>:</label>



      <input type="email" class="form-control" name="insight_pro_new_customer_email" id="form_mail" value="<?php echo $admin_email;?>"/>



    </div>



    



    <div class="form-group">



   	  <label for="customer_details"><?php echo __('Details', 'insightpro_restaurant');?>:</label>



      <textarea class="form-control" name="insight_pro_new_customer_details" rows="5" id="form_txt"></textarea>



    </div>



    <div class="form-group">



   	  <input type="checkbox" class="form-control" name="insight_pro_customer_agree" id="insight_pro_customer_agree" value="yes" />



      <label for="customer_details"><b><?php echo __('I agree to send above informations to InsightPro Support Team', 'insightpro_restaurant');?>.</b></label>



    </div>



    



    <input type="submit" class="insight_pro_new_customer_details_send" name="insight_pro_new_customer_details_send" id="form_submit" value="<?php echo __('Send', 'insightpro_restaurant');?>">



    </form>



	</div>



		



	<?php	



}







add_action('admin_init', 'insight_pro_custom_modification_request_settings_fields');







function insight_pro_custom_modification_request_settings_fields(){



	



	add_settings_section("modificationrequest", "", null, "insight_pro_modificationrequest_options");



	add_settings_field("insight_pro_current_website_url", "Send your details:", "insight_pro_custom_modification_request_form", "insight_pro_modificationrequest_options", "modificationrequest");







}



?>