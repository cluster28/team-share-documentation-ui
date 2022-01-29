<?php

namespace Cluster28\TeamShareDocumentationUi\Configuration;

use Twig\Loader\FilesystemLoader;

class Configuration
{
    private array $templatesPath = [];

    public function __construct(array $config = [])
    {
        $this->templatesPath = $config['templatesPath'] ?? [
            FilesystemLoader::MAIN_NAMESPACE => __DIR__ . '/../Templates/',
            'datatablesjs-1.11.4' => __DIR__ . '/../Templates/datatablesjs-1.11.4',
            'bootstrap5' => __DIR__ . '/../Templates/datatablesjs-1.11.4/bootstrap5',
        ];
    }

    public function getTemplatesPath(): array
    {
        return $this->templatesPath;
    }
}
