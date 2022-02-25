<?php

namespace Cluster28\TeamShareDocumentationUi\Twig;

use Cluster28\TeamShareDocumentationUi\Configuration\Configuration;
use Cluster28\TeamShareDocumentationUi\Configuration\Templates\DatatablejsBs5Configuration;
use Cluster28\TeamShareDocumentationUi\Configuration\Templates\TemplateConfigurationInterface;
use Cluster28\TeamShareDocumentationUi\Twig\Extension\DatatablesExtension;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigFactory
{
    public static function getEnvironment(Configuration $configuration, TemplateConfigurationInterface $templateConfiguration): Environment
    {
        $loader = new FilesystemLoader();
        foreach ($configuration->getTemplatesPath() as $namespace => $path) {
            $loader->addPath($path, $namespace);
        }

        $twig = new Environment($loader);

        $twig->addExtension(new DebugExtension());
        if ($templateConfiguration instanceof DatatablejsBs5Configuration) {
            $twig->addExtension(new DatatablesExtension($templateConfiguration));
        }

        return $twig;
    }
}
