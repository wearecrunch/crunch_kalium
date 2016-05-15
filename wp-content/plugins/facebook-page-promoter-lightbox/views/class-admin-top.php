<?php
/*
 * This class enables configuration of all front-end options of
 * google analytics and specific back-end options.
 * @author Arevico
 */
class arvlbAdminTop extends arvlbAdminViewSimple{ 

	/*
 	* Initilizes a simple option view, with option arvlb-global
 	*/
	function __construct(){
		parent::__construct('arv_fb24_opt',arvlbSHARED::getDefaults() );
		
	}

	//* overwrite and process *//
	public function save(){
		if (isset($_POST['o']) && isset($_POST['o']['fb_id']))
			$_POST['o']['fb_id'] = preg_replace('/^.*?facebook\.com\\//i','',$_POST['o']['fb_id']);

		

		parent::save();
	}

	
	/*
	 * Renders a page
	 */
	public function render_page(){
		
	$opac_settings = array();
	
	for ($i=0; $i <= 100 ; $i=$i+5) { 
		$opac_settings[$i] = "{$i}%";
	}
	/* /PAID */

  $this->openWrapper();	
?>	

	
	<div class="arevico-updated">
	<div style="float:left;">
		Take a look at the <a href="http://arevico.com/sp-facebook-lightbox-premium/" target="_blank" style="text-decoration:underline;">Premium Version</a> for more options!&nbsp;&nbsp; check out the <a href="http://arevico.com/facebook-lightbox-plugin-f-a-q/" target="_blank">F.A.Q.</a> for questions.
	</div>

	<div style="clear:both;"></div>
	</div>
	

<?php
 if ($this->getState()) { ?>
	<div class="arevico-updated"> Saved Successfully ! </div>
<?php } 
		$this->getTabHeader(
			array(
				'tab-general' 		=> 'General'
				));

?>
<div class="onepcssgrid-1200">

	<!-- Start General Tab-->
	<div class="tab tab-active" id="tab-general">
		<div class="onerow">
			<div class="col3 label-center">Facebook Page Name</div>
			<div class="col6 last"><?php $this->getText('o[fb_id]', array('placeholder' => 'Arevico')); ?></div>
		</div>

		<?php $this->separator(); ?>
		<div class="onerow">
			<div class="col3 label-top">Show On</div>
			<div class="col3 ">
				<?php $this->getCheckbox('o[display_on_page]');  ?> Pages<br />&nbsp;<br />
				<?php $this->getCheckbox('o[display_on_post]'); ?> Posts<br />
			</div>
			<div class="col3 last">
				<?php $this->getCheckbox('o[display_on_homepage]');  ?> Homepage<br />&nbsp;<br />
				<?php $this->getCheckbox('o[display_on_archive]'); ?> Archives<br />
			</div>
		</div>

		<?php $this->separator(); 
			$this->row(3, 9, 'Delay','<p>Delay in ms for the lightbox to appear (e.g &gt; 4000)</p>');
			$this->row(3, 4, '&nbsp;', $this->getText('o[delay]', array('placeholder' => '1500'), false));
		?>

		<?php 
		$this->separator(); 
		$this->separator();
		$this->row(3, 9, 'Show Once Every', '<p>Show once in the defined amount of days per individual visitor. Enter zero to load on each pageload</p>');
		$this->row(3, 4, '&nbsp;', $this->getText('o[show_once]', array('placeholder' => '7'),false));

		$this->separator();
		$this->row(3, 9, 'Overlay Click', $this->getCheckbox('o[coc]', null, false) . 'Close on overlay click');

		$this->separator();
		$this->row(3, 9, 'Submenu', $this->getCheckbox('o[submenu]', null, false) . 'Show this menu under \'Settings\'');
		$this->row(3, 6, '&nbsp;', '<hr />');
		?>
		<div class="onerow">
			<div class="col3 label-center">Performance</div>	
			<div class="col3">
				<?php 
				// Read 14 characters starting from the 21st character
				$minify_options = array(0 => 'Minify Assets', 2 => 'Don\'t Minify');

				/* Lets just check if we can access files */
				if ( @file_get_contents( plugin_dir_path( __FILE__ ) . '../includes/launch/launch.js', NULL, NULL, 0, 1) !== false )
					$minify_options[1] = 'Minify and Inline';
				
				ksort($minify_options);		
				$this->getSelect('o[min]', $minify_options);
				 ?>
			</div>
			<div class="col4 last">
			<?php
				$api_options = array(
					0 => 'Load Facebook API Synchronous',
					1 => 'Load Facebook Asynchronous',
					2 => 'Don\'t load Facebook API' );
				$this->getSelect('o[performance]', $api_options)
			?>
			</div>
		</div>
		<div class="onerow">
			<div class="col3">&nbsp;</div>
			<div class="col6"><p>Only change performance options when you are familliar with them!</p></div>
		</div>
	</div>
	<!-- end general tab-->



</div><!-- End onepccgrid -->


<div class="onepcssgrid-1200">
<?php
	$this->separator(); 
	$this->row(3,3,'&nbsp','<input class="add-new-h2" style="width:100%;height:35px;" type="submit" value="  Save Settings!  "/>');
?>
</div>

<?php
	$this->closeWrapper();

} //end do_page


}
 ?>