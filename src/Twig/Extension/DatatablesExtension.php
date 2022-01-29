<?php

namespace Cluster28\TeamShareDocumentationUi\Twig\Extension;

use Cluster28\TeamShareDocumentation\Model\Collection\Annotations;
use Cluster28\TeamShareDocumentationUi\Configuration\Templates\DatatablejsBs5Configuration;
use ReflectionClass;
use ReflectionMethod;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DatatablesExtension extends AbstractExtension
{
    private DatatablejsBs5Configuration $datatablejsBs5Configuration;

    public function __construct(DatatablejsBs5Configuration $datatablejsBs5Configuration)
    {
        $this->datatablejsBs5Configuration = $datatablejsBs5Configuration;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_table_config', [$this, 'getTableConfig'], ['is_safe' => ['html']]),
            new TwigFunction('get_table_rows', [$this, 'getTableRows'], ['is_safe' => ['html']])
        ];
    }

    public function getTableConfig(): string
    {
        return json_encode($this->datatablejsBs5Configuration->getConfig());
    }

    public function getTableRows(Annotations $annotations): string
    {
        $rows = [];
        foreach ($annotations as $arrayAnnotation) {
            $rows[] = $this->getTableRow($arrayAnnotation);
        }
        return json_encode($rows);
    }

    private function getTableRow($arrayAnnotation): array
    {
        $class = $method = '';
        if ($arrayAnnotation[0] instanceof ReflectionClass) {
            $class = $arrayAnnotation[0]->getName();
        } elseif ($arrayAnnotation[0] instanceof ReflectionMethod) {
            $class = $arrayAnnotation[0]->class;
            $method = $arrayAnnotation[0]->getName();
        }

        return [
            $arrayAnnotation[1]->date,
            $class,
            $method,
            $arrayAnnotation[1]->description,
            $arrayAnnotation[1]->tags
        ];
    }
}
