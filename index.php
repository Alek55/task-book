<?php
    mb_internal_encoding("UTF-8");

    set_include_path(get_include_path().PATH_SEPARATOR."controller".PATH_SEPARATOR."model".PATH_SEPARATOR."view".PATH_SEPARATOR."core");
    spl_autoload_extensions(".php");
    spl_autoload_register(function ($class) {
        if(file_exists(__DIR__.'/model/'.$class.'.php')) include __DIR__.'/model/'.$class.'.php';
        elseif(file_exists(__DIR__.'/core/'.$class.'.php')) include __DIR__.'/core/'.$class.'.php';
        elseif(file_exists(__DIR__.'/controller/'.$class.'.php')) include __DIR__.'/controller/'.$class.'.php';
        elseif(file_exists(__DIR__.'/view/'.$class.'.php')) include __DIR__.'/view/'.$class.'.php';
    });

    BaseModel::setDB();
    Route::parseUrl();
?>