<?php

declare(strict_types=1);

namespace Reformo\FrontWeb\Handler;

use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Domain\User\Query\GetAllUsers;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var TemplateRendererInterface|null */
    private $template;
    private $config;
    private $commandBus;

    public function __construct(
        CommandBus $commandBus,
        TemplateRendererInterface $template,
        array $config
    ) {
        $this->template   = $template;
        $this->config     = $config;
        $this->commandBus = $commandBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $command               = new GetAllUsers(0, 25);
        $data                  = [];
        $data['containerName'] = 'Zend Servicemanager';
        $data['containerDocs'] = 'https://docs.zendframework.com/zend-servicemanager/';
        $data['routerName']    = 'FastRoute';
        $data['routerDocs']    = 'https://github.com/nikic/FastRoute';
        $data['templateName']  = 'Twig';
        $data['templateDocs']  = 'http://twig.sensiolabs.org/documentation';
        $data['users']         = $this->commandBus->handle($command);

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
