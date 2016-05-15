<?php 
/**
 * An instantiation of an AdminView class gives a user the oportunity to configure
 * plugin settings and behaviour.
 * @author Arevico
 */
abstract class arvlbAdminView 
{
	abstract public function process_request();
	abstract public function save();

	const STATE_DEFAULT 	= 0;
    const STATE_SAVED 		= 1;
    const STATE_EDIT 		= 2;
 	
 	const OPT_TEXT 			= 'getText';
 	const OPT_SELECT 		= 'getSelect';
 	const OPT_CHECK 		= 'getCheck';

 	protected $error 		= null; //WP_Error Class //  Not Yet Implemented

	private $textbox 	= '<input type="text" name="%1$s" value="%2$s" %3$s/>';
	private $textarea 	= '<textarea name="%1$s" %3$s/>%2$s</textarea>';
	private $checkbox 	= '<input type="checkbox" name="%1$s" value="1" %2$s %3$s/>';
	private $hidden 	= '<input type="hidden" name="%1$s" value="%2$s" %3$s/>';
	
	private $select 	= '<select name="%1$s" %3$s>%2$s</select>';
	private $option 	= '<option value="%1$s"%3$s>%2$s</option>';

	private $openWrapper = '<div class="wrap arv-opt">%1$s';

	private $formOpen 	=  '<form method="POST">';
	
	private $closeWraper = '</form></div>';

	private $tab 		 = '';
	private $tabli 		 = '<a href="#" class="nav-tab a-%2$s nav-tab-%2$s tab-%3$s">%4$s</a>';
	private $tabHeader 	 = '<div class="tab-container"><div class="tab-header"><h2 class="nav-tab-wrapper">%1$s</h2></div>';

	private $col 		 = "\t<div class=\"col%1\$d %2\$s\">%3\$s</div>";
	private $onerow		 = '<div class="onerow">%1$s</div>';
	/** The current state of an admin view. States being, 0:default, 1: saved, 2: updated */
	protected $state		= self::STATE_DEFAULT;

	/**
	 * Get the current state of the admin view
	 * @return $this->state
	 */
	public function getState(){
		return $this->state;
	}

	/**
	 * Get hidden element from the database
	 * @param string $name the name of the option element. Always a subarray of o (e.g: o[option-1]) 
	 * @param array $attr Atribute value pairs
	 * @param boolean $echo Output the generate textbox
	 * @return type
	 */
	public function getHidden($name,$attr=null,$echo=true){
		return $this->getGeneric($this->hidden,$name,$attr,$echo);
	}

	/**
	 * Get option element from the database
	 * @param string $name the name of the option element. Always a subarray of o (e.g: o[option-1]) 
	 * @param array $attr Atribute value pairs
	 * @param boolean $echo Output the generate textbox
	 * @return type
	 */
	public function getText($name,$attr=null,$echo=true){
		return $this->getGeneric($this->textbox,$name,$attr,$echo);
	}

	/**
	 * Get option element from the database
	 * @param string $name the name of the option element. Always a subarray of o (e.g: o[option-1]) 
	 * @param array $attr Atribute value pairs
	 * @param boolean $echo Output the generate textbox
	 * @return type
	 */
	public function getTextArea($name,$attr=null,$echo=true){
		return $this->getGeneric($this->textarea,$name,$attr,$echo);
	}

	/**
	 * Get checkbox option element from the database
	 * @param string $name the name of the option element. Always a subarray of o (e.g: o[option-1]) 
	 * @param array $attr Atribute value pairs
	 * @param boolean $echo Output the generate textbox
	 * @return type HTML representation of the return checkbox with value and name included
	 */
	public function getCheckbox($name,$attr=null,$echo=true,$value=null){
		if ($value===null){
		$value 			= ArevicoSQA::val($name, $this->options, false, true);
		$value			= (empty($value)) ? '' : 'checked="checked" ';
	} 

		$attributes  	= is_array($attr) ? $this->attr_to_string($attr) : '';
		$html 			= sprintf($this->checkbox, $name, $value, $attributes);
		
		if ($echo)
			echo $html;

		return $html;
	}
	/**
	 * Get checkbox option element from the database
	 * @param string $name the name of the option element. Always a subarray of o (e.g: o[option-1]) 
	 * @param array $selects Keys are the option values matching the values as labels of the option element
	 * @param array $attr Atribute value pairs
	 * @param boolean $echo Output the generate textbox
	 * @return type HTML representation of the return select with value and name included
	 */
	public function getSelect($name,$selects,$attr=null,$echo=true,$value=null){
		$value 			= ($value===null) ? ArevicoSQA::val($name, $this->options, false, true) : $value;
		$html 			= $this->select;
		$options 		= '';
		$attributes  	= is_array($attr) ? $this->attr_to_string($attr) : '';
		foreach ($selects as $s_name => $s_label) {
			$selected= (strcasecmp($s_name, $value)===0) ? ' selected="selected"' : '';
			$options .= sprintf($this->option,$s_name,$s_label,$selected);
		}
		$html=  sprintf($html,$name,$options,$attributes);

		if ($echo)
			echo $html;

		return $html;

	}

	/**
	 * Construct a header for the tab
	 * @param array items, an array of items in the kvp form  id => Label
	 * @param bool echo wether or not to output the resulting html
	 */
	public function getTabHeader($items, $echo = true){
		$lis 	= '';
		$i  	= 0;

		foreach ($items as $slug => $label) {
			$first  = ($i==0) ? 'first ' : '';
			$active = ($i==0) ? 'active ' : 'inactive';

			$lis .= sprintf($this->tabli, $first, $active, $slug, $label);
			$i++;
		}

		$sret = sprintf($this->tabHeader, $lis);
		if ($echo)
			echo $sret;

		return $sret;
	}

	public function closeTab(){
		echo '</div>';
	}
	/**
	 * Render an update message if applicable
	 */
	public function updateMessage(){
		 if ($this->getState()) 
		 	echo '<div class="updated"> Saved Successfully !</div>';
	}

	/**
	 * Render a form and nonce-token
	 */
	public function openWrapper($message = ''){
		$nonce = wp_nonce_field(-1,'arvlb-update-forms',true, false);
		echo sprintf($this->openWrapper, $this->formOpen . $nonce);
	}

	/**
	 * Render a row consisting of two columns, variable size
	 */
	public function row($labelsize, $valuesize, $label, $value){
		$label 	= sprintf($this->col, $labelsize, 'label', $label) . "\r\n";
		$value 	= sprintf($this->col, $valuesize, 'last', $value) . "\r\n";
		printf($this->onerow, $label . $value);
	}

	/**
	 * A alias function to easily build a row<3,6> base on an option type
	 * @param enum cb the callback function. e.g self::OPT_TEXT
	 * @param string label The label for col<3>
	 * @param string the path to the option value to calculate current settings
	 * @param string prefix prefix the col<6> with a specified string
	 * @param string suffix suffix the col<6> with a specified string
	 * @param array selects when CB=OPT_SELECT, the option fields should be included
	 */
	public function rowVal($cb, $label, $value, $attr=null, $selects=null ,$prefix = '', $suffix = ''){
		if ($cb === self::OPT_SELECT){
			$parameters = array($value, $selects, $attr, null, false);	
		} else{
			$parameters = array($value, $attr, null, false);	
		}
		$label 		= sprintf($this->col,3,'label',$label);
		$value 		= call_user_func_array( array($this, $cb), $parameters);
		$value 		= $prefix . $value .  $suffix;
		$value 		= sprintf($this->col,6,'last',$value);
		printf($this->onerow,$label . $value);
	}


	/**
	 * Render a row 12 long (separator)
	 */
	public function separator($label = '&nbsp;'){
		$col = sprintf($this->col, 12,'', $label);
		printf($this->onerow, $col);
	}

	/**
	 * Render closing form wrapper and closing div for the tab-container
	 */
	public function closeWrapper(){
		echo $this->closeWraper;
	}

	/**
	 * Get a generic template to be filled in
	 * @param string $template The template to be filled in 
	 * @param string $name The name of the associated option
	 * @param array $attr 
	 * @param type $echo
	 * @param value custom value
	 * @return type
	 */
	private function getGeneric($template, $name,$attr=null,$echo=true,$value=null){
		$value 	= ($value===null) ? ArevicoSQA::val($name, $this->options, false, true): $value;
		$attributes  = is_array($attr) ? $this->attr_to_string($attr) : '';
		$html 		= sprintf($template, $name, $value, $attributes);
		
		if ($echo)
			echo $html;

		return $html;

	}

	/**
	 * Generate an html representation of attribute value pairs
	 * @param array $arr_attr an array of attributeswith key containing the attribute name and the value a string of the attribute value 
	 * @return string a HTML representation of a value attribute pair.
	 */
	private function attr_to_string($arr_attr){
		$html = '';
	
		foreach ($arr_attr as $a_name => $a_val) {
			$html .= " {$a_name}=\"{$a_val}\" ";
		}

		return $html;
	}
}

/**
 * An AdminViewSimple class is often used to represent option tables not requiring
 * relational data, or simple relations which can be defined in an array 
 * @author Arevico
 */
abstract class arvlbAdminViewSimple  extends arvlbAdminView{

	/** An error object containing various methods to generate messages and check input*/	
	protected $error 		= null; //TODO: Implement WP_Error Object

	protected $options 	 	= array();
	protected $option_name  = '';
	protected $default 		= array();
	protected $process 		= true;

	public function process_request(){
		if (ArevicoSQA::isPost()){
			$this->options = $_POST;

		} elseif (!ArevicoSQA::isPost()){
			$this->options = $this->fetch();
		}
	}

	/** 
 	* Fetch the option froms the database and store them
	*/
	public function fetch(){
		if ($this->process && (!empty($this->option_name)))
		return array('o'=>get_option($this->option_name,$this->default));
	}

	/**
	 * Process and save options to the database
	 */
	public function save(){
		if (isset($_POST['o']) && (!empty($this->option_name))  && wp_verify_nonce($_POST['arvlb-update-forms']) ){
			update_option($this->option_name,$_POST['o']);	
			$this->state = self::STATE_SAVED;

		}else if(wp_verify_nonce($_POST['arvlb-update-forms']) && ArevicoSQA::isPost() ){
			$this->state = self::STATE_SAVED;
		}
	}

	function __construct($option_name='',$default=array()){
		if (empty($option_name))
			$this->process = false;
		
		$this->option_name 	= $option_name;
		$this->default 		= $default;
	}

}


/**
 * An more complex representation of relational data.
 * Instantiations must implement both process_save and process_edit
 * @author Arevico
 */
abstract class  arvlbAdminViewDB extends arvlbAdminView{

	protected $err 		= null;
	protected $options 	= array();
	protected $edit_id 	= null;

	/* if disabled, fetching and saving wont be automatically*/
	private $process 	= true;

	public function save(){
		if (isset($_POST['o'])
			&& (wp_verify_nonce($_POST['arvlb-update-forms'])!==false)){
			$save = $this->is_edit() ? $this->process_edit : $this->process_save;
			$this->state = 2;
		}
	}

	/**
	 * Get's called when a form is saved to the database
	 *@return void 
	 */
	public abstract function process_save();

	/**
	 * Custom Method to get option data
	 *@return array the array of options 
	 */
	public abstract function fetch($id=null);

	/**
	 * Get's called when a form is edited
	 *@return void 
	 */
	public abstract function process_edit();

	/**
	 * Get the current ID
	 * @return this->state == 2 ? this->edit_id : null
	 */
	public function get_id(){
		return $this->edit_id;
	}

	/**
	 * Set the current ID of the item being edited
	 * @return void
	 */
	public function set_edit($id){
		$this->edit_id = $id;
	}

	protected function is_edit(){
		return (!is_null($this->edit_id));
	}

	public function render_id_field(){
		if ($this->is_edit() ){
			$e_id = $this->get_id();
			echo "<input type=\"hidden\" name=\"id\" value=\"{$e_id}\" />";
		}
	}

	public function render_id_action(){
		if ($this->is_edit() ){
			$e_id = $this->get_id();
			echo "&id={$e_id}";
		}
	}

	function __construct($process=true){

	}

	public function process_request(){
		if (isset($_REQUEST['id'])){
			$this->is_edit 	= $_REQUEST['id'];
			$this->state 	= self::STATE_EDIT;
		}

		if (ArevicoSQA::is_post()){
			$data 			= (isset($_POST['o'])) ? $_POST['o'] : array();
			$this->options 	= array("o"=> $data);

		} elseif (!ArevicoSQA::is_post()){
			$this->options = array("o" => $this->fetch($this->get_id()) );
		}
	}


}
 ?>