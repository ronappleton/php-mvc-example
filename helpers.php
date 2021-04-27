<?php

if (!function_exists('view')) {
    /**
     * @param string $view
     * @param array $vars
     * @return false|string
     */
    function view(string $view, array $vars = []): bool|string
    {
        $viewPath = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);

        if (count($vars)) {
            extract($vars, EXTR_OVERWRITE);
        }

        ob_start();
        require $viewPath . $view . '.php';
        return ob_get_clean();
    }
}
