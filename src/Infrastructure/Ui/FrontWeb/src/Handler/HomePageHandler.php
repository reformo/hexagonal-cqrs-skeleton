<?php

declare(strict_types=1);

namespace Reformo\FrontWeb\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Services\MessageBus\Interfaces\QueryBus;
use Reformo\Domain\User\Query\GetAllUsers;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var TemplateRendererInterface|null */
    private $template;
    private $config;
    private $queryBus;

    public function __construct(
        QueryBus $queryBus,
        TemplateRendererInterface $template,
        array $config
    ) {
        $this->template = $template;
        $this->config   = $config;
        $this->queryBus = $queryBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $guard                 = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        $token                 = $guard->generateToken();
        $query                 = new GetAllUsers(0, 25);
        $data                  = [];
        $data['containerName'] = 'Zend Servicemanager';
        $data['containerDocs'] = 'https://docs.zendframework.com/zend-servicemanager/';
        $data['routerName']    = 'FastRoute';
        $data['routerDocs']    = 'https://github.com/nikic/FastRoute';
        $data['templateName']  = 'Twig';
        $data['templateDocs']  = 'http://twig.sensiolabs.org/documentation';
        $data['users']         = $this->queryBus->handle($query);
        $data['queryParams']   = $request->getQueryParams();
        $data['__csrf']        = $token;

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
