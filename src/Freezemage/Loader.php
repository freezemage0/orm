<?php


namespace Freezemage\Core\Internal;


class Loader
{
    public static function loadClass($fqn)
    {
        $fqn = ltrim($fqn, '\\');
        $fqn = str_replace('\\', DIRECTORY_SEPARATOR, $fqn);

        $absolute = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $fqn . '.php';
        if (file_exists($absolute) && is_file($absolute)) {
            /** @noinspection PhpIncludeInspection */
            include $absolute;
        }
    }
}

spl_autoload_register(array(Loader::class, 'loadClass'));