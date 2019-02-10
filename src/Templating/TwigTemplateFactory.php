<?php

declare(strict_types=1);

namespace Hoop\Templating;

use Twig_Loader_Filesystem;
use Twig_Environment;

final class TwigTemplateFactory
{
    private $templateDirectory;

    public function __construct(TemplateDirectory $templateDirectory)
    {
        $this->templateDirectory = $templateDirectory;
    }

    public function create(): TwigTemplate
    {
        $loader = new Twig_Loader_Filesystem($this->templateDirectory->toString());
        $twigEnvironment = new Twig_Environment($loader);

        return new TwigTemplate($twigEnvironment);
    }
}