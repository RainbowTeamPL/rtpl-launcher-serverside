<?php
	include_once ('functions.php');
    
    
    
    switch ((isset($_GET['r']) ? $_GET['r'] : '')) {
 
            case 'stats':
                printStats();
            break;
            case 'login':
                
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