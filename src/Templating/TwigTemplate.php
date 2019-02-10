<?php

declare(strict_types=1);

namespace Hoop\Templating;

use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Syntax;
use Twig_Error_Runtime;

class TwigTemplate implements Template
{
    private $twigEnvironment;

    public function __construct(Twig_Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function render(string $template, array $data = []): string
    {
        try {
            $template = $this->twigEnvironment->render($template, $data);
        } catch (Twig_Error_Loader $e) {
            echo 'Caught exception: ' . $e;
        } catch (Twig_Error_Syntax $e) {
            echo 'Caught exception: ' . $e;
        } catch (Twig_Error_Runtime $e) {
            echo 'Caught exception: ' . $e;
        }

        return $template;
    }
}