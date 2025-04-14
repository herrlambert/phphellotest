<?php
namespace App\Core;

/**
 * Base Controller
 */
abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $routeParams = [];

    /**
     * Render a view
     *
     * @param string $view  The view file
     * @param array  $data  Data for the view
     * @param bool   $useLayout Whether to use the layout
     *
     * @return void
     */
    protected function render($view, $data = [], $useLayout = true)
    {
        // Extract data to make it available to the view
        extract($data, EXTR_SKIP);

        // Start output buffering
        ob_start();

        // Include the view file
        $viewFile = dirname(__DIR__) . "/views/$view.php";
        if (is_readable($viewFile)) {
            require $viewFile;
        } else {
            throw new \Exception("$viewFile not found");
        }

        // Get the content of the view
        $content = ob_get_clean();

        // Use layout if specified
        if ($useLayout) {
            // Include the layout file
            $layoutFile = dirname(__DIR__) . "/views/layout.php";
            if (is_readable($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
}
