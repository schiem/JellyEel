<?php
    //Track users
    session_start();

    //Site variables now available
    require_once('config.php');

    //Core functions available
    require_once("{$site_info['core_dir']}/core.php");

    //Call the template
    $request_page = strtok($_SERVER["REQUEST_URI"],'?');
    if($request_page == '/') {
        $path = "/" . get_site_var('home_slug');
    } else {
        $path = trim($request_page, '/');
    }
    $file = get_site_var('page_dir') . '/' . $path . '.php';


    //Create our header and template globals
    $header_args = array();
    $template_args = array();
    global $header_args, $template_args;

    //Call our template
    include_once($file);

    ?>
