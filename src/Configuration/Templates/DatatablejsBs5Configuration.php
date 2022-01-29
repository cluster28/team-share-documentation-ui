<?php

namespace Cluster28\TeamShareDocumentationUi\Configuration\Templates;

class DatatablejsBs5Configuration implements TemplateConfigurationInterface
{
    private array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return array_merge([
            "pageLength" => 25,
            "order" => [[0, "desc"]],
            "responsive" => true
        ], $this->config);
    }
}
