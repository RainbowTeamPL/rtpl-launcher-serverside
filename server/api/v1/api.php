<?php
	include_once ('functions.php');
    
    
    
    switch ((isset($_GET['r']) ? $_GET['r'] : '')) {
 
            case 'stats':
                printStats();
            break;
            case 'login':
                $login = $_GET['l'];
				$pw = $_GET['pw'];
				
				echo'ok|'.$login.'|'.$pw;
            break;
            case 'logout':
                
            break;
            case 'register':
                
            break;
            default:
                printStats();
            break;        
    }
?>