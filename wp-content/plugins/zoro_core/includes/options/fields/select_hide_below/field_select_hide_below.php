<?php
class ZR_Options_select_hide_below extends ZR_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since ZR_Options 1.0.1
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since ZR_Options 1.0.1
	*/
	function render(){
		
		$class = (isset($this->field['class']))? esc_attr( $this->field['class'] ):'';
		
		echo '<select id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" class="'.$class.' zr-opts-select-hide-below" >';
			
			foreach($this->field['options'] as $k => $v){
				
				echo '<option value="'.esc_attr( $k ).'" '.selected($this->value, $k, false).' data-allow="'.$v['allow'].'">'.$v['name'].'</option>';
				
			}//foreach

		echo '</select>';

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.esc_html( $this->field['desc'] ).'</span>':'';
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since ZR_Options 1.0.1
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'zr-opts-select-hide-below-js', 
			ZR_Options_URL.'fields/select_hide_below/field_select_hide_below.js', 
			array('jquery'),
			time(),
			true
		);
		
	}//function
	
}//class
?>