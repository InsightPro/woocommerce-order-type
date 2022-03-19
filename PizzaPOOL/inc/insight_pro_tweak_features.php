<?php 

/*
* Tweak Features
*/

global $insight_pro_guest_no;
global $insight_pro_guest_purpose;

function insight_pro_tweak_features_admin_form(){
?>
    <div class="wrap">
        <h1>Tweak Features</h1>
        <form method="post"  class="insight_pro_tweak_features_admin_form_settings" action="options.php" >
            <?php
			    settings_fields("tweakfeatures");  //Output nonce, action, and option_page fields for a settings page.
                do_settings_sections('insight_pro_free_tweak_features'); //Print out the settings fields for a particular settings section.
                submit_button();?>
        </form>
    </div>
<?php } 

    function insight_pro_tweak_features_guest_no_form(){
        $insight_pro_guest_no =  get_option('insight_pro_guest_no'); //Retrieves an option value based on an option name.
        
        if($insight_pro_guest_no == 'yes'){
            echo '<input type="checkbox" name="insight_pro_guest_no" id="insight_pro_guest_no" value="yes" checked>';  
        } else {
            echo '<input type="checkbox" name="insight_pro_guest_no" id="insight_pro_guest_no" value="yes">';
        }
        
    }

    function insight_pro_tweak_features_guest_purpose_form(){
        $insight_pro_guest_purpose =  get_option('insight_pro_guest_purpose'); //Retrieves an option value based on an option name.

        if($insight_pro_guest_purpose == 'yes'){
            echo '<input type="checkbox" name="insight_pro_guest_purpose" id="insight_pro_guest_purpose" value="yes" checked>';  
        } else {
            echo '<input type="checkbox" name="insight_pro_guest_purpose" id="insight_pro_guest_purpose" value="yes">';
            
        }
    }

    add_action("admin_init","insight_pro_tweak_features_setting_management");
    function insight_pro_tweak_features_setting_management(){

        add_settings_section("tweakfeatures","",null,"insight_pro_free_tweak_features");
        
        add_settings_field("insight_pro_tweak_features_guest_number", "Ask Guest Number", "insight_pro_tweak_features_guest_no_form", "insight_pro_free_tweak_features", "tweakfeatures" );
        add_settings_field("insight_pro_tweak_features_guest_purpose", "Ask Guest Purpose", "insight_pro_tweak_features_guest_purpose_form", "insight_pro_free_tweak_features", "tweakfeatures" );


        register_setting("tweakfeatures", "insight_pro_guest_no");
        register_setting("tweakfeatures", "insight_pro_guest_purpose");

    }
?>
