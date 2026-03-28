<?php

namespace Core;

use App\Shared\Web\Responses\ViewResponse;

class ViewRender
{
    /**
     * Render a specified view 
     * @param string $view
     * @param array $data
     * @return mixed
     */
    public function render(string $view, array $data = []): mixed
    {
        extract($data);

        return require dirname(__DIR__) . "/app/{$view}.php";
    }

    /**
     * Render a view with a layout
     * 
     * @param string $view
     * @param string $layout_view
     * @param string $title
     * @param array $data
     * @return mixed
     */
    public function view(ViewResponse $response): mixed
    {
        ob_start();

        $path = "Modules/{$response->module}/Presentation/Views/{$response->view}";

        $this->render($path, $response->data);

        $view_data = [
            'title' => $response->data['title'] ?? 'Document',
            'content' => ob_get_clean(),
        ];

        return $this->render('Shared/Views/layouts/main-layouts/' . $response->layout, $view_data);
    }
}