<?php
    if(!session_id()) {
        session_start();
    }
    
    require_once "Facebook/autoload.php";
    
    $facebook = new \Facebook\Facebook([
        'app_id' => '217389435472767',
        'app_secret' => '702d1603ca4fb8bbf324452415d1aaf0',
        'default_graph_version' => 'v2.10'
    ]);
    
?>