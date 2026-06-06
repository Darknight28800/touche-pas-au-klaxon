<?php

namespace App\Controllers;

class CoreController
{
    protected $router;

    public function __construct()
    {
        if (!isset($GLOBALS['router'])) {
            throw new \Exception("Router non initialisé.");
        }

        $this->router = $GLOBALS['router'];
    }

    protected function render(string $view, array $params = []): void
    {
        extract($params);

        // Injection automatique du router dans la vue
        $router = $this->router;

        require __DIR__ . '/../Views/' . $view . '.php';
    }
}
