<?php

namespace Utils;

class View
{
    protected string $viewsBasePath;
    protected array $options;

    public function __construct(
        string $viewsBasePath,
        array $options = []
    ) {
        $this->viewsBasePath = $viewsBasePath;
        $this->options = $options;
    }

    /**
     * function renderView
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    public function renderView(string $view, array $data = []): string
    {
        $ds = \DIRECTORY_SEPARATOR;
        $viewPath = \str_replace('.', $ds, $view);

        $finalViewPath = "{$this->viewsBasePath}{$ds}{$viewPath}.view.php";

        if (!\file_exists($finalViewPath)) {
            \http_response_code(500);

            throw new \Exception(
                \implode(
                    \PHP_EOL,
                    [
                        'Error:',
                        "The view '{$view}' do note exists!",
                    ]
                ),
                100
            );
        }

        $render = function (array $data) use ($finalViewPath) {
            unset($data['__helpers']);

            \extract($data);
            $__helpers = [
                'view' => function (string $viewName, array $dataToView = []) {
                    return \App\Helpers\Helpers::view($viewName, $dataToView);
                },
            ];

            return require $finalViewPath;
        };

        return $render($data);
    }
}
