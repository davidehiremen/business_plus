<?php
function url_for($script_path){
	if ($script_path[0] != '/') {
		$script_path = '/' . $script_path;
	}
	return WWW_ROOT . $script_path;
}

function u($string=""){
	return urlencode($string);
}

function h($string=""){
	return htmlspecialchars($string);
}

function error_404(){
	header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
}

function error_500(){
	header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
}

function redirect_to($location){
	header('Location: ' . $location);
}

function is_post_request(){
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function is_get_request(){
	return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function is_ajax_request() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
  
function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function get_and_clear_session_message() {
  if(isset($_SESSION['message']) && $_SESSION['message'] != '') {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']);
    return $msg;
  }
}

function display_session_message() {
  $msg = get_and_clear_session_message();
  if(!is_blank($msg)) {
    return '<h3>' . h($msg) . '</h3>';
  }
}

function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}
?>