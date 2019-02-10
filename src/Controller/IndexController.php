<?php

declare(strict_types=1);

namespace Hoop\Controller;

use Symfony\Component\HttpFoundation\Response;
use Hoop\Templating\Template;
use Hoop\Repository\HighlightRepository;

final class IndexController
{
    private $template;
    private $highlightRepository;

    public function __construct(Template $template, HighlightRepository $highlightRepository)
    {
        $this->template = $template;
        $this->highlightRepository = $highlightRepository;
    }

    public function display()
    {
        $data = $this->highlightRepository->findAll();
        var_dump($data);
        $template = $this->template->render('index.twig', array('data' => $data));

        return new Response($template);
    }
}