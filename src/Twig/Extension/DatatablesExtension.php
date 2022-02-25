<?php

namespace Cluster28\TeamShareDocumentationUi\Twig\Extension;

use Cluster28\TeamShareDocumentation\Annotation\ShareAnnotation;
use Cluster28\TeamShareDocumentation\Model\Annotation;
use Cluster28\TeamShareDocumentation\Model\AnnotationData;
use Cluster28\TeamShareDocumentation\Model\ExtractionResult;
use Cluster28\TeamShareDocumentation\Model\ClassInfo;
use Cluster28\TeamShareDocumentationUi\Configuration\Templates\DatatablejsBs5Configuration;
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

    public function getTableRows(ExtractionResult $extractionResult): string
    {
        $rows = [];
        foreach ($extractionResult->getResults() as $classInfo) {
            /** @var ClassInfo $classInfo */
            /** @var ShareAnnotation $annotation */
            foreach ($classInfo->getAllAnnotations() as $annotation) {
                $rows[] = $this->getTableRow($annotation);
            }
        }
        return json_encode($rows);
    }

    private function getTableRow(AnnotationData $annotationData): array
    {
        /** @var ShareAnnotation $annotation */
        $annotation = $annotationData->getAnnotation();
        return [
            $annotation->getDate(),
            $annotationData->getClassName(),
            $annotationData->isInMethod() ? $annotationData->getMethodName() : "",
            $annotation->getDescription(),
            $annotation->getTags()
        ];
    }
}
