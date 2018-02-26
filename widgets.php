<?php
$debug = false;
if ($debug) {
    echo "<pre>",print_r($_SERVER),"</pre>";
    exit();
}
header("Content-Type:application/json");
//Required The Database File
require "data.php";
//Initialize the Variabels
$widget_name = "";
$widget_hash = "";
//Check the name of the widget on URL
if(!empty($_GET['widget'])) {
  $widget_name = $_GET['widget'];
  //Check The Hash Code (We must work on this additional security)
  if (isset($_GET['hash'])) {
      $widget_hash = $_GET['hash'];
  }
  if (!isset($_SERVER["HTTP_REFERER"])) {
      $widget_url = 'localhost:8080';
  } else {
      $widget_url = $_SERVER["HTTP_REFERER"];
  }

	$show_widget = get_widget($widget_name, $widget_hash, $widget_url);
	if(empty($show_widget)) {
		  response(200,"Widget Not Found",NULL);
	} else {
		  response(200,"Widget Found",$show_widget);
	}

} else {
	 response(400,"Invalid Request",NULL);
}

function response($status,$status_message,$data) {
  	header("HTTP/1.1 ".$status);
    if (!isset($_SERVER["HTTP_REFERER"])) {
        $widget_referer = 'localhost:8080';
    } else {
        $widget_referer = $_SERVER["HTTP_REFERER"];
    }
  	$response['status']=$status;
  	$response['status_message']=$status_message;
  	$response['data']=$data;
    $response['referer']=$widget_referer;

  	$json_response = json_encode($response);
  	echo $json_response;
}
?>
