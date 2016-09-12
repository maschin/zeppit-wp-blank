<?php
    $themename = "Blank";
    $shortname = "cus";
    $options = array (
        array(    "name" => "General options",
        "type" => "title"),
        array(    "type" => "open"),
        array(    "name" => "Option1",
            "desc" => "",
            "id" => $shortname."_option1",
            "std" => "",
            "type" => "text"),
        array(    "name" => "Phone",
            "desc" => "Phone.",
            "id" => $shortname."_phone",
            "std" => "",
            "type" => "text"),
        array(    "name" => "Facebook",
            "desc" => "Facebook link.",
            "id" => $shortname."_facebook",
            "std" => "",
            "type" => "text"),
        array(    "name" => "Google",
            "desc" => "Google link.",
            "id" => $shortname."_google",
            "std" => "",
            "type" => "text"),
        array(    "name" => "Twitter",
            "desc" => "Twitter link.",
            "id" => $shortname."_twitter",
            "std" => "",
            "type" => "text"),
        array(    "type" => "close"),
    );

    function cus_add_admin() {
        global $themename, $shortname, $options;
        if ( $_GET['page'] == basename(__FILE__) ) {
            if ( 'save' == $_REQUEST['action'] )     {
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                }
                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], Strip($_REQUEST[ $value['id'] ]  )); } else { delete_option( $value['id'] ); }
                }
                header("Location: themes.php?page=theme-options.php&saved=true");
                die;
            } else if( 'reset' == $_REQUEST['action'] ) {
                foreach ($options as $value) {
                    delete_option( $value['id'] );
                }
                header("Location: themes.php?page=theme-options.php&reset=true");
                die;
            }
        }   
        add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), $shortname.'_admin');
    }

    /**
     *Render settings page
     */
    function cus_admin() {
    
        global $themename, $shortname, $options;
    
        if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
        if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
    ?>
        <div class="wrap">
            <h2><?php echo $themename; ?> settings</h2>
            <form method="post">
    <?php   foreach ($options as $value) {
                switch ( $value['type'] ) {
                    case "open":?>
                        <table width="100%" border="0" style="-webkit-border-radius:0 0 7px 7px ;-khtml-border-radius:0 0 7px 7px ;-moz-border-radius:0 0 7px 7px; border-radius:0 0 7px 7px;background-color: #EFEFEF; padding:10px;">
                    <?php break;
                    case "close":?>
                        </table><br />
                    <?php break;
                    case "title":?>
                        <table width="100%" border="0" style="-webkit-border-radius:7px 7px 0 0;-khtml-border-radius:7px 7px 0 0;-moz-border-radius:7px 7px 0 0;border-radius:7px 7px 0 0;background-color:#777;background-image:-ms-linear-gradient(bottom,#6d6d6d,#808080);background-image:-moz-linear-gradient(bottom,#6d6d6d,#808080);background-image:-o-linear-gradient(bottom,#6d6d6d,#808080);background-image:-webkit-gradient(linear,left bottom,left top,from(#6d6d6d),to(#808080));background-image:-webkit-linear-gradient(bottom,#6d6d6d,#808080);background-image:linear-gradient(bottom,#6d6d6d,#808080);color:#FFF; padding:0 10px;">
                            <tr>
                                <td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif; margin:0.5em 0;"><?php echo $value['name']; ?></h3></td>
                            </tr>
                        </table>
                    <?php break;
                    case 'text':?>
                        <tr>
                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
                        </tr>
                        <tr>
                            <td><small><?php echo $value['desc']; ?></small></td>
                        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #999999;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                    <?php break;
                    case 'textarea':?>
                        <tr>
                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
                        
                        </tr>
                        
                        <tr>
                            <td><small><?php echo $value['desc']; ?></small></td>
                        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                    <?php break;
                    case 'select':?>
                        <tr>
                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
                        </tr>
                        
                        <tr>
                            <td><small><?php echo $value['desc']; ?></small></td>
                        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                    <?php break;
                    case "checkbox":?>
                        <tr>
                        <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                                    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                                    </td>
                        </tr>
                    
                        <tr>
                            <td><small><?php echo $value['desc']; ?></small></td>
                       </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                    
                    <?php break;
                }
            }
    ?>
        <p class="submit">
            <input name="save" type="submit" value="Save changes" />
            <input type="hidden" name="action" value="save" />
        </p>
    </form>
    </div><!--.wrap-->
    <form method="post"   onSubmit="if(confirm('Are you sure you want to reset all the theme settings?')) return true; else return false;" >
        <p class="submit" style="margin:5px;padding:0px;">
            <input name="reset" type="submit" value="Reset" />
            <input type="hidden" name="action" value="reset" />
        </p>
    </form>

    <?php
    }
    
    function cus_wp_head(){
        global $options;

	foreach ( $options as $value ) {
	    if ( get_option( $value['id'] ) === FALSE ) { 
			$$value['id'] = $value['std']; 
		} else { 
			$$value['id'] = get_option( $value['id'] ); 
		} 
	} 
    }

function Strip($value)
{
    if(get_magic_quotes_gpc() != 0)
    {
        if(is_array($value))
            if ( array_is_associative($value) )
            {
                foreach( $value as $k=>$v)
                    $tmp_val[$k] = stripslashes($v);
                $value = $tmp_val;
            }
            else
                for($j = 0; $j < sizeof($value); $j++)
                    $value[$j] = stripslashes($value[$j]);
        else
            $value = stripslashes($value);
    }
    return $value;
}
    //add_action('admin_head', $shortname.'_admin_head');
    add_action('wp_head', $shortname.'_wp_head');
    add_action('admin_menu', $shortname.'_add_admin');	
    