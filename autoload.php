<?php
function controllers_autoload($class) {
    $paths = ['controllers/', 'models/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            include $file;
            return;
        }
    }
}
spl_autoload_register('controllers_autoload');