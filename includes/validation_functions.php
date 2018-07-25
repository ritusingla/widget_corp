<?php 
	$errors=array();
	function fieldname_as_text($fieldname) {
  $fieldname = str_replace("_", " ", $fieldname);

  $fieldname = ucfirst($fieldname);
  // echo $fieldname;
  return $fieldname;
}
	function has_presence($value)
	{
		return isset($value) && $value!=="";
	}

	// function fieldname_as_text(){

	// }

	function validate_has_presence($value_array)
	{
		global $errors;
		//print_r($value_array);
		foreach ($value_array as $field ) {
			$value=trim($_POST[$field]);
			//echo "hiii";
			if(!has_presence($value))
			{
				//echo $field;
				$errors[$field]=fieldname_as_text($field). "can't be blank";
			}
		}
	}

	// function has_length($len)
	// {
	// 	$max=10;
	// 	$min=2;
	// 	if(strlen($len)>=$min && strlen($len)<=$max)
	// 		return true;
	// 	else
	// 		return false;
	// }
	function max_length($value,$max)
	{
		return strlen($value) <= $max;
	}

	function has_inclusion_in($value,$set){
		return in_array($value,$set);
	}

	function validate_max_lengths($fields_with_max_lengths){
		global $errors;
		foreach($fields_with_max_lengths as $field => $max){
			$value=trim($_POST[$field]);
			if(!max_length($value,$max)){
				$errors[$field]= fieldname_as_text($field) . "is too long";
			}
		}
	}
?>