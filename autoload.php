<?php


function tf_autoload($classname)
{
    $file = __DIR__ . '/classes/'.str_replace('\\','/',$classname).'.php';


    if(file_exists($file))
    {
        require_once($file);
    }
}

\spl_autoload_register('tf_autoload');