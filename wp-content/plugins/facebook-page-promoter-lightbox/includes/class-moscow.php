<?php 

if (!class_exists('ArevicoSQA')){
/**
 * This class provides some auxiliary functions to aid database processing and HTML output
 */
class ArevicoSQA
{
	/**
	 * Retrieve the first element of an array
	 * @param array &$arr The array of which the first element is to be retrieved
	 * @return mixed the first element of an array
	 */
	public static function firstKey(&$arr){
		reset($arr);
		return key($arr);
	}

		/**
	 * Retrieve the first element of an array
	 * @param array &$arr The array of which the first element is to be retrieved
	 * @return mixed the first element of an array
	 */
	public static function lastKey(&$arr){
		end($arr);
		return key($arr);
	}
	/**
	 * Check if a value is available in the post array And 	
	 * return or output it encoded
	 * @param string $name the name and subname
	 * @param array $arr the array to fetch
	 * @param boolean $echo wether or not to output the current variable
	 * @param boolean $escape wether or not escaping the output is wished
	 * @example val::('option[subarray][value]')
	 * @return string the value						
	 */
	public static function val($name,$arr,$echo=false,$escape=true){
		$str_ret 	= 	self::str_arr_val($name, $arr);

		if ($escape)
			$str_ret 	= htmlentities($str_ret);

		if ($echo)
			echo $str_ret;

		return $str_ret;
	}


	/**
	 * Cache a specific piece of data
	 * @param mixed $callback If it's callable the return value from the function gets cached,otherwise, the content passed
	 * @param array $parameters 	The parameters to be passed to the callback functio
	 * @param int $id 			(optional) The id of the caching reference.
	 * @param int $expire 		How long does the cache entry persists
	 * 
	 */

	public static function cache($callback, $parameters=array(), $id = null, $expire = 24){
		$content 	= get_transient( 'arvlb' . $id ); 

		if (!$id)
			$id = self::cacheGetId($parameters);

		if (!$content){
			$content = (is_callable($callback)) ? call_user_func_array($callback, $parameters) : $callback;
			set_transient( 'arvlb' . $id , serialize($content), $expire );	

		} else{
			$content = unserialize($content);
		}

		return $content;
	}

	/**
	 * Generate an unique identifier to store the cache entry. Asumed is that a call to a function
	 * with the same parameters results in the same output. If any other conditions change, the cache
	 * Needs to be cleared manually.
	 * @param array $argument_list all the parameters
	 */
	public static function cacheGetId($argument_list = array() ){
		$id 			= serialize($argument_list);
		return substr($id, 5);
	}

	/**
	 * Fill an array with an default value if the specified keys don't exists. Especially usefull when
	 * receives a number of checkboxes from a form submit
	 * @param $arr1 array with all the submitted settings
	 * @param $arr2 array with all the default options
	 * @requires $arr1 $arr1 does not contain items not in $arr2 (will not be included) &&
	 *			 $arr1.length<=$arr2.length
	 */
	public static function arr_def_merge($arr1, $arr2, $def_val = '0'){

		$a_ret = array();

		foreach ($arr2 as $key => $value) {	
			if (isset($arr1[$key])){
				$a_ret[$key] = $arr1[$key];
			} else {
				$a_ret[$key]=$def_val;
			}

		}
		return $a_ret;
	}

	/**
	* Remove all elements execpt those specified in $art
	* @param array $art the values of this array are the keys to keep in $arp
	* @param array $arp the initial array to apply the filter function too
	*/
	public static function get_ins_inc($arp, $art, $multiple=false){
		if (!is_array($arp))
			return array(); //return empty array since shit is not valid to begin with

		if ($multiple){ //apply $arp to all elements and then return it
			foreach ($arp as $k => &$v) {
				$v = self::get_ins_inc($v,$art,false);
			}
			return $arp;

		} else {
			return array_intersect_key($arp,array_flip($art));
		}
	}

	/**
	* Remove all elements specified in $art
	* @param array $art the values of this array to remove
	* @param array $arp the initial array to apply the filter function too
	*/
	public static function get_ins_ex($arp, $arr_to_rem, $multiple = false){

		if ($multiple){ //apply $arp to all elements and then return it
			foreach ($arp as $k => &$v) {
				$v = self::get_ins_ex($v,$arr_to_rem,false);
			}
			return $arp;

		} else {
			return array_diff_key($arp, array_flip($arr_to_rem));
		}
	}


	/**
	 * Return a value of a subarray by supplying
	 * @param path the subarray e.g(option[subarray][value])
	 * @param arr the array to 
	 */
	public static function str_arr_val($name, $arr=null){
		$parts	 	= array();
		$base 		= '';

		if ($arr===null)
			$arr = $_POST;

		preg_match('/(.*?)(?:\[|$)/', $name, $base);

		if (empty($base))
			return '';

		$arr 		= $arr[$base[1]];


		preg_match_all('/\[(.*?)\]/',$name, $parts,  PREG_SET_ORDER );
		
		//traverse the main array based on the parts
		foreach ($parts as $val) {

			if ( isset($arr[$val[1]]) ){
				$arr 	= $arr[$val[1]];
			} else {
				$arr 	= '';
				break;
			}
		}

		return $arr;
	}

	/**
	 * This function converts an associative array to a single string with all elements
	 * delimited
	 * @param array $assoc the associated array
	 * @param string $delim the delimiter to seperate the values
	 * @return string A string in the format [key="value" ]
	 */
	public static function assocToString($assoc ,$delim, $escape=true){
		global $wpdb;
		$arr_ret = array();
		foreach ($assoc as $key => $value) {

			if ($escape)
				$value=$wpdb->escape($value);
			$arr_ret[]="{$key}=\"{$value}\" ";
		}
		return implode($delim,$arr_ret);
	}


	/**
	 * Return wether or not the current request is a post one
	 * @return bool true if the request is a post
	 */
	public static function isPost(){
		return 	$_SERVER['REQUEST_METHOD']==="POST";
	}

	/**
	 * Rename Array keys
	 * @param array $array the array to be renamed
	 * @param array $keys the keys to be renamed array(old => new)
	 * @param bool $subarray, apply this method on all subarrays
	 * @return array The new array
	 */
	public static function arrayRenameKey($array, $keys, $subarray = false){
		if ($subarray){
			foreach ($array as $k => &$v) {
				$v=self::array_rename_key($v,$keys,false);
			}
			return $array;
		} else {
		
		foreach ($keys as $old => $new) {
			if (isset($array[$old])){
				$array[$new]=$array[$old];
				unset($array[$old]);
			}
		}

		return $array;
		}
	}

	/**
	 * Repeat a pattern and fill in Classes
	 * @param string toRep the string to be repeated. use {$variable} to indicate variable spot.
	 * 		  predefined classes {i}, {$odd} can also be used
	 * @param args an array of parameter arrays. The keys need to be sorted the same for each array
	 * @return string all variables replaced
	 * 
	 */
	public static function arrValMap($toRep, $args, $echo=true, $escape=true){
		foreach ($args as $argument) {
			$i=0;
			
			// Set some default classes
			$argument['i'] 			= $i;
			$argument['even']		= ($i % 2 == 0);
			$argument['parity']		= ($i % 2 == 0) ? 'even' : 'odd';

			foreach ($argument as $key => $value) {
			
				if ($escape)
					$value 		= htmlentities($value);
					$toRep 		= str_replace('{$' . $key . '}', $value);
			}
			$i++;
		}
		if ($echo)
			echo $toRep;
		return $toRep;
	}
	
	/**
	 * Returns the full current url being displayed
	 * @return string the current URL including method and querystring
	 */
	public static function getCurrentURL(){
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];
		 
		$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
		 
		return $currentUrl;
	}

	/** 
	 * Group an sorted SQL result set into sub arrays
	 * @param array $set a array sorted on the main group
	 * @param array $fds[table_name] => {column_1,...,column_n}
	 * @return array An array containing the main set and all specified FDs in a sub array
	 */
	public static function groupBy($set, $fds){
		$new_array 	= array();
		$fd_columns	= array();
		$last_row 	= null;

		foreach ($fds as $table_name => $fd_col)
			$fd_columns = array_merge($fd_columns, $fd_col);

		foreach ($set as $row) {
			//reduce row to a form which we can compare
			$reduced  = self::get_ins_ex($row, $fd_columns);

			if ( $last_row === null || $last_row !== $reduced){
				$last_row = $reduced;
				$new_array[] = $reduced;
			}

			$lastKey = self::lastKey($new_array);

			/** Extract all functional dependencies */
			foreach ($fds as $table_name => $columns){
				$dep 	= self::get_ins_inc($row, $columns);

				/** We employ a neat little trick to check if all values in an array are NULL*/
				if (!is_null(max($dep)))
					$new_array[$lastKey][$table_name][] = $dep;
			}
		}

		return $new_array;
	}
	


  /**
   * Check if a plugin is active. If no parameters are given,
   * get a list of all active plugins.
   * @param string $find the slug of the plugin to find (equals the folder name)
   */
  public static function pluginActive($find = null){

    // option has an autoload flag, so performance should not be impacted  
    $active_plugins = get_option( 'active_plugins', array() );

    $slug_arr     = array();  

    foreach ($active_plugins as $plugin) {
      $slug = str_replace('\\','/',$plugin);
      $slug = substr($slug, 0 , strpos($slug, '/'));
      $slug_arr[$slug] = $plugin;
    }
    if (is_string($find))
        return isset($slug_arr[$find]);
      
    return $slug_arr;
  }



	/**
	* Convert a hexa decimal color code to its RGB equivalent
	*
	* @param string $hexStr (hexadecimal color value)
	* @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
	* @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
	* @return array or string (depending on second parameter. Returns False if invalid hex color value)
	*/                                                                                                
	public static function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    	$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    	$rgbArray = array();
    
    	if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        	$colorVal = hexdec($hexStr);
        	$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        	$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        	$rgbArray['blue'] = 0xFF & $colorVal;
    	} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
       		$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        	$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        	$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	    } else {
    	    return false; //Invalid hex color code
	    }
    	return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	} 

} // end class
} // end conditional
?>