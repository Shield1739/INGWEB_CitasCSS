<?php

namespace Shield1739\UTP\CitasCss\core;

use Shield1739\UTP\CitasCss\core\exception\NotFoundException;

/**
 *  Renders the specified layout & view and transforms the $params into usable properties within the view
 */
class ViewRenderer
{
    /**
     * Renders the view inside the layout
     *
     * @param array $layout
     * @param array $view
     * @param array $params
     *
     * @return string
     * @throws \Shield1739\UTP\CitasCss\core\exception\NotFoundException
     */
    public function renderView(array $layout, array $view, array $params = []): string
    {
        $layoutContent = $this->getLayoutContent($layout[0], $layout[1], $params);
        $viewContent = $this->getViewContent($view[0], $view[1], $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Renders only a view
     *
     * @param array $view
     * @param array $params
     *
     * @return string
     * @throws \Shield1739\UTP\CitasCss\core\exception\NotFoundException
     */
    public function renderOnlyView(array $view, array $params = []): string
    {
        return $this->getViewContent($view[0], $view[1], $params);
    }

    /**
     * Returns the layout contents
     *
     * @param string $module
     * @param string $layout
     * @param array $params
     *
     * @return string
     * @throws \Shield1739\UTP\CitasCss\core\exception\NotFoundException
     */
    private function getLayoutContent(string $module, string $layout, array $params = []): string
    {
        return $this->getContent("$module/views/layouts", $layout, $params);
    }

    /**
     * Return the views contents
     *
     * @param string $module
     * @param string $view
     * @param array $params
     *
     * @return string
     * @throws \Shield1739\UTP\CitasCss\core\exception\NotFoundException
     */
    private function getViewContent(string $module, string $view, array $params = []): string
    {
        return $this->getContent("$module/views", $view, $params);
    }

    /**
     * Transform the $params into usable properties and returns the contents of the specified view/layout file
     *
     * @param string $path
     * @param string $file
     * @param array $params
     *
     * @return string
     * @throws \Shield1739\UTP\CitasCss\core\exception\NotFoundException
     */
    private function getContent(string $path, string $file, array $params = []): string
    {
        foreach ($params as $key => $value)
        {
            $$key = $value;
        }

        $fullPath = Application::$ROOT_DIR."/app/$path/$file.php";

        if (file_exists($fullPath) && is_readable($fullPath))
        {
            ob_start();
            include_once $fullPath;
            return ob_get_clean();
        }
        else
        {
            throw new NotFoundException();
        }
    }
}