<?php
/*
Plugin Name: Slide Div
Plugin URI: http://wordpress.org/extend/plugins/slide-div/
Description: The best way for slide each of your content div like a "lift" very simply!.
Author: Cavimaster
Version: 1.2
Author URI: http://www.devsector.ch/cavimaster/category/developpement/wordpress-plugins-widgets/
*/

//**********************************add admin option
function slide_div_options_page() {
add_options_page('Slide Div Options', 'Slide Div', 'manage_options', 'slide-div.php', 'slide_div_options');
}
add_action('admin_menu', 'slide_div_options_page');

//*********************************Admin options function
function slide_div_options(){ 

$slidediv_options_page = get_option('siteurl') . '/wp-admin/options-general.php?page=slide-div.php';

$event_type = get_option( 'event_type' ) ? get_option( 'event_type' ) : 'click';
$relation_type = get_option( 'relation_type' ) ? get_option( 'relation_type' ) : 'parent';
$click = get_option( 'dom_click' ) ? get_option( 'dom_click' ) : 'h1.entry-title';
$div = get_option( 'dom_div' ) ? get_option( 'dom_div' ) : '.entry-content';

if('update_options' == $_POST['stage']){
update_option('event_type', $_POST['event_type']);
$event_type = get_option('event_type');

update_option('relation_type', $_POST['relation_type']);
$relation_type = get_option('relation_type');

update_option('dom_click', $_POST['dom_click']);
$click = get_option('dom_click');

update_option('dom_div', $_POST['dom_div']);
$div = get_option('dom_div');
}
  
?>
  <div class="wrap">
	<h2><?php _e('Slide Div Options', 'slidediv') ?></h2>
      <FIELDSET><LEGEND>Here set the Slide Div options</legend>
	  <form name="form1" method="post" action="<?php echo $slidediv_options_page; ?>&amp;updated=true">
	  <input type="hidden" name="stage" value="update_options" />
	  <!-- Sur quel événement  -->
	  <h3>Slide toggle on:</h3>
	 <p>
	  <input type="radio" name="event_type" id="event_type" value="click"  <?php if ( $event_type =='click' ) echo 'checked="checked" '; ?> /><label>Click</label><br>  
	  <input type="radio" name="event_type" id="event_type" value="mouseover"  <?php if ( $event_type =='mouseover' ) echo 'checked="checked" '; ?> /><label>Mouse over</label>
	 </p>
	 
	 <h3>Actors:</h3>
	  <table width="55%">
	  <tr><td><label>Element.Class for click or over</label></td>
	  <td><input type="text" size="20" name="dom_click" id="dom_click" value="<?php  echo $click; ?>" /></td> 
	  <td><em>by default: [h1.entry-title]</em></td>
	  </tr>
	  <tr>
	  <td><label>Element.Class for toogle slide</label></td>
	  <td><input type="text" size="20" name="dom_div" id="dom_div" value="<?php  echo $div; ?>" /> </td>
	  <td><em>by default: [div.entry-content]</em></td>
	  </tr>
	  <tr>
	  <td>
	  <h3>Actors are:</h3>
	 <p>
	  <input type="radio" name="relation_type" id="relation_type" value="parent"  <?php if ( $relation_type =='parent' ) echo 'checked="checked" '; ?> /><label>Parent <em>(in the same div)</em></label><br>
	  <input type="radio" name="relation_type" id="relation_type" value="dont_parent"  <?php if ( $relation_type =='dont_parent' ) echo 'checked="checked" '; ?> /><label>Dont parent <em>(not in the same div. Unique toggle div)</em></label>
	 </p>
	  </td><td></td><td></td>
	  </tr>
	  </table>
	  <p><input type="submit" class="button-primary" name="Submit" value="<?php _e('Update settings', 'slidediv') ?>" /></p>
	  </form>
	  </fieldset>
</div>
<h3>Thank you!</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="2T8RL9F6EW5L6">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>

<?php }


function slide_div() { 
$event_type = get_option( 'event_type' ) ? get_option( 'event_type' ) : 'click';
$relation_type = get_option( 'relation_type' ) ? get_option( 'relation_type' ) : 'parent';
$click = get_option( 'dom_click' ) ? get_option( 'dom_click' ) : 'h1.entry-title';
$div = get_option( 'dom_div' ) ? get_option( 'dom_div' ) : '.entry-content';

if($relation_type == 'parent'){$parent ='.parent()';} else $parent = '';

?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("<?php echo $div; ?>").hide();
	$("<?php echo $click; ?>").<?php echo $event_type; ?>(function(){
		$(this).addClass("active")<?php echo $parent; ?>.next("<?php echo $div; ?>").slideToggle("slow");
		return false;
	});
});
</script>

<?php } 
add_action('wp_enqueue_scripts', 'slide_div'); //enqueue on frontend

//plugin uninstall options
function slidediv_uninstall(){
delete_option('event_type');
delete_option('relation_type');
delete_option('dom_click');
delete_option('dom_div');
}
register_deactivation_hook(__FILE__,'slidediv_uninstall');

?>
