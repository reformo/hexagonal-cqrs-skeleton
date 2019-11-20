<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware;

use Locale;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use const LC_ALL;
use function bind_textdomain_codeset;
use function bindtextdomain;
use function copy;
use function file_exists;
use function filemtime;
use function glob;
use function putenv;
use function setlocale;
use function textdomain;
use function unlink;

class LocalizationMiddleware implements MiddlewareInterface
{
    public const LOCALIZATION_ATTRIBUTE = 'locale';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // Get locale from route, fallback to the user's browser preference
        $locale = $request->getAttribute(
            'locale',
            Locale::acceptFromHttp(
                $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? 'en_US'
            )
        );
        $this->setLocale($locale, $request->getAttribute('moduleName'));

        return $handler->handle($request->withAttribute(self::LOCALIZATION_ATTRIBUTE, $locale));
    }

    private function setLocale(string $locale, string $domain) : void
    {
        $localeFile        = 'data/cache/locale/' . $locale . '/LC_MESSAGES/' . $domain . '.mo';
        $modifiedTime      = filemtime($localeFile);
        $localeFileRuntime = 'data/cache/locale/' . $locale . '/LC_MESSAGES/' . $domain . '_' . $modifiedTime . '.mo';
        if (! file_exists($localeFileRuntime)) {
            $dir = glob('data/cache/locale/' . $locale . '/LC_MESSAGES/' . $domain . '_*.mo');
            foreach ($dir as $file) {
                unlink($file);
            }
            copy($localeFile, $localeFileRuntime);
        }
        $domain .='_' . $modifiedTime;
        $lang    = $locale . '.UTF8';
        putenv("LANG={$lang}");
        putenv("LANGUAGE={$lang}");
        setlocale(LC_ALL, $lang);
        Locale::setDefault($locale . '.UTF-8');
        bindtextdomain($domain, 'data/cache/locale');
        bind_textdomain_codeset($domain, 'UTF-8');
        textdomain($domain);
    }
}
