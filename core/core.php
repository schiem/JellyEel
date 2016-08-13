<?php
    require_once($site_info['core_dir'] . '/includes.php');
    require_once($site_info['core_dir'] . '/db.php');    
    require_once($site_info['core_dir'] . '/user.php');

    foreach($extensions_enabled as $extension) {
        require_once("{$site_info['extension_dir']}/$extension.php");
    }




?>
