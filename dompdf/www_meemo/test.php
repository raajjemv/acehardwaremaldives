<?php

require_once("../dompdf_config.inc.php");

// We check wether the user is accessing the demo locally
$local = array("::1", "127.0.0.1");
$is_local = in_array($_SERVER['REMOTE_ADDR'], $local);

//if ( isset( $_POST["html"] ) && $is_local ) {

  //if ( get_magic_quotes_gpc() )
    //$_POST["html"] = stripslashes($_POST["html"]);
  
  $dompdf = new DOMPDF();
  $dompdf->load_html_file("test/css_float.html");
  $dompdf->set_paper("a4", "portrait");
  $dompdf->render();

  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

  exit(0);
//}

?>