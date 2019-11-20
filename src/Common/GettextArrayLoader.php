<?php

declare(strict_types=1);

namespace Reformo\Common;

use Gettext\Loader\Loader;
use Gettext\Translations;
use Gettext\Translation;

final class GettextArrayLoader extends Loader
{
    public function loadArray(array $localeData, ?Translations $translations = null) : Translations
    {
        if (! $translations) {
            $translations = $this->createTranslations();
        }

        $messages = $localeData['messages'] ?? [];
        foreach ($messages as $messageId => $messageData) {
            $translation = Translation::create(null, $messageId);
            $translation->translate($messageData['translate']);
            if (array_key_exists('reference', $messageData) && $messageData['reference'] !== null) {
                $translation->getReferences()->add($messageData['reference'], $messageData['reference-line'] ?? null);
            }
            if (array_key_exists('comment', $messageData) && $messageData['comment'] !== null) {
                $translation->getComments()->add($messageData['comment']);
            }
            if (array_key_exists('translate-plural', $messageData) && $messageData['translate-plural'] !== null) {
                $translation->setPlural($messageId.'_PLURAL');
                $translation->translatePlural($messageData['translate-plural']);
            }
            $translations->add($translation);
        }

        if (! empty($array['domain'])) {
            $translations->setDomain($localeData['domain']);
        }
        if (! empty($array['locale'])) {
            $translations->setLanguage($localeData['locale']);
        }
        $translations->getHeaders()
            ->set('Content-Type', 'text/plain; charset=UTF-8')
            ->set('X-Generator', 'Reformo Zend Expressive App')
            ->set('Plural-Forms', $localeData['plural-forms'] ?? 'nplurals=2; plural=n != 1;');
        return $translations;
    }
}
