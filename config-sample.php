<?php 
    //Database block
    $servername    = 'localhost';
    $username      = 'DB_USER';
    $password      = 'DB_PASS';
    $dbname        = 'DB_NAME'; 
    $salt          = 'DB_SALT';

    //Extensions Block
    $extensions_enabled = array('functions');

    //Site Info Block
    $site_dir      = getcwd();
    $site_info     = array(
                        'url'  => 'http://example.com',
                        'name' => 'Site Title',
                        'home_slug' => 'home',
                        'core_dir'      => $site_dir . '/core',
                        'template_dir'  => $site_dir . '/templates',
                        'page_dir'      => $site_dir . '/pages',
                        'extension_dir' => $site_dir . '/extensions',
                        'header_dir'    => $site_dir . '/header',
                        );
?>
