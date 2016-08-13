<?php 
    function get_header($header_file='header') {
        global $header_args;
        $path = get_site_var('header_dir') . '/' . $header_file . '.php';
        include($path);
    }

    function get_template($template) {
        global $template_args;
        $path = get_site_var('template_dir') . '/' . $template . '.php';
        include($path);
    }

    function get_site_var($var) {
        global $site_info;
        return isset($site_info[$var]) ? $site_info[$var] : false;
    }


    ?>
