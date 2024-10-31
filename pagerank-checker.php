<?php
/*
Plugin Name: PageRank Checker
Plugin URI: http://www.websitechecker.info/plugins/pagerank-checker
Description: Show your blog page rank automatically. Lots of nice styles can be choose,you will find them on your <a href="widgets.php">widgets page</a>.
Version: 2.3.2
Author: Website Checker 
Author URI: http://www.websitechecker.info/
License: GPL2
*/

define( 'WCPCDIR', trailingslashit(plugin_basename(dirname(__FILE__))) );
define( 'WCPCURL', plugin_dir_url(dirname(__FILE__)) . WCPCDIR );

/**
*
* Class of PR Checker
* version 2.3
**/

$pc = new wc_pagerank_checker;
$pc->init();

class wc_pagerank_checker{

	function init(){
		add_action('init', array(&$this,'register_extenal'));
	}
	
	function register_extenal(){
		if(is_admin())
			wp_enqueue_style('style', WCPCURL . 'style.css');
	}

}


/**
 * PR Icon widget class
 *
 * @since 1.0
 */
class WP_Widget_WC_Pagerank_Checker extends WP_Widget {

	function WP_Widget_WC_Pagerank_Checker() {
		$widget_ops = array( 'description' => "Show your blog pagerank with an icon automatically" );
		$this->WP_Widget('wc_pagerank_checker', 'PageRank Checker', $widget_ops);
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['link_disabled'] = strip_tags($new_instance['link_disabled']);
		$instance['without_widget_title'] = strip_tags($new_instance['without_widget_title']);

		return $instance;
	}
	
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array() );
		$style = strip_tags($instance['style']);
		$title = strip_tags($instance['title']);
		$link_disabled = strip_tags($instance['link_disabled']);
		$without_widget_title = strip_tags($instance['without_widget_title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('link_disabled'); ?>"><?php _e('Disable credit link:'); ?></label>
			<input type="checkbox" name="<?php echo $this->get_field_name('link_disabled'); ?>" <?php if($link_disabled=="on") echo "checked";?> />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('without_widget_title'); ?>"><?php _e('Without Widget Title:'); ?></label>
			<input type="checkbox" name="<?php echo $this->get_field_name('without_widget_title'); ?>" <?php if($without_widget_title=="on") echo "checked";?> />
		</p>
		<p><label for="<?php echo $this->get_field_id('style'); ?>"><b><?php _e('Choose an icon style:'); ?></b></label>
			<table class="wcprt">
				<tr><td width="110">
				<input type="radio" <?php if($style==1||$style==null) echo 'checked' ?> value="1" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s1.gif" class="pr"></td><td>
				<input type="radio" <?php if($style==2) echo 'checked' ?> value="2" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s2.gif" class="pr"></td></tr><tr><td>
				<input type="radio" <?php if($style==3) echo 'checked' ?> value="3" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s3.gif" class="pr"></td><td>
				<input type="radio" <?php if($style==4) echo 'checked' ?> value="4" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s4.gif" class="pr"></td></tr><tr><td>
				<input type="radio" <?php if($style==5) echo 'checked' ?> value="5" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s5.gif" class="pr"></td><td>
				<input type="radio" <?php if($style==6) echo 'checked' ?> value="6" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s6.gif" class="pr"></td></tr><tr><td>
				<input type="radio" <?php if($style==7) echo 'checked' ?> value="7" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s7.gif" class="pr"></td><td>
				<input type="radio" <?php if($style==8) echo 'checked' ?> value="8" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s8.gif" class="pr"></td></tr><tr><td>
				<input type="radio" <?php if($style==9) echo 'checked' ?> value="9" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s9.gif" class="pr"></td><td>
				<input type="radio" <?php if($style==10) echo 'checked' ?> value="10" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s10.gif" class="pr"></td></tr><tr><td>
				<input type="radio" <?php if($style==11) echo 'checked' ?> value="11" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s11.gif" class="pr"></td><td>
				<input type="radio" <?php if($style==12) echo 'checked' ?> value="12" name="<?php echo $this->get_field_name('style'); ?>" class="pss"><img src="<?php echo WCPCURL?>images/icons/s12.gif" class="pr"></td></tr>
			</table>
			
		</p>
		<p><b>Note:</b> Above pr is just a demo,your real pagerank will appear on your blog once you saved this widget.</p>
		
<?php
		
	}
	
	function widget( $args, $instance ) {
		global $wpdb;
        global $pc;
		extract($args);
		$title = empty($instance['title'])?"":$instance['title'];
		$pc_style = get_option('wc_pr_icon_style');
		if($instance['without_widget_title']=="on"){
			if($instance['link_disabled']=="on")
			echo '<img src="http://www.websitechecker.info/getpr/v'.$instance['style'].'" title="PageRank Checker plugin" alt="PageRank Checker" style="border:0;" />';
			else
			echo '<a href="http://www.websitechecker.info/pr" title="PageRank Checker plugin" target="_blank"><img src="http://www.websitechecker.info/getpr/v'.$instance['style'].'" alt="PageRank Checker" style="border:0;" /></a>';
		}else
		{
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<div>';
			if($instance['link_disabled']=="on")
				echo '<img src="http://www.websitechecker.info/getpr/v'.$instance['style'].'" title="PageRank Checker plugin" alt="PageRank Checker" style="border:0;" />';
			else
				echo '<a href="http://www.websitechecker.info/pr" title="PageRank Checker plugin" target="_blank"><img src="http://www.websitechecker.info/getpr/v'.$instance['style'].'" alt="PageRank Checker" style="border:0;" /></a>';
			echo "</div>\n<div class='cl'></div>";
			echo $after_widget;
		}
	}

}


add_action('init', 'register_wc_pagerank_checker');

function register_wc_pagerank_checker(){
	register_widget('WP_Widget_WC_Pagerank_Checker');
	do_action('widgets_init');
}


?>