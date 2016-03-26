<?php
//<!--This script logs out and destroys the session-->
        session_start();
        session_unset();   
        session_destroy();                
	echo json_encode(array(
                "success" => true
                  ));
        exit;
?>
