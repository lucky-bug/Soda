<?php

namespace Soda\View;

use Soda\Helpers\ArrayHelpers;
use Soda\View\Exception\EngineException;

class SimpleViewEngine extends ViewEngine
{
    public function render(string $viewName, $data = []): string
    {
        $viewPath = $this->resolveViewPath($viewName);

        if (!file_exists($viewPath)) {
            throw new EngineException("View {$viewName} not found!");
        }

        ob_start();
        extract($data);
        eval('?>' . file_get_contents($viewPath));
        $contents = ob_get_contents();
        ob_get_clean();

        return $contents;
    }

    protected function resolveViewPath($viewName): string
    {
        $nameParts = ArrayHelpers::clean(
            ArrayHelpers::trim(
                explode('.', $viewName)
            )
        );

        $viewPath = $this->viewsDir . implode(DIRECTORY_SEPARATOR, $nameParts) . '.php';

        return $viewPath;
    }
}
