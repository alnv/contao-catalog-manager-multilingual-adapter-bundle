<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\DataContainer;

use Contao\Database;

class Page
{

    public function getLanguages(): array
    {

        $languages = ['languages' => [], 'fallback' => '', 'fallbacks' => []];
        $objPages = Database::getInstance()
            ->prepare('SELECT fallback,`language`,dns FROM tl_page WHERE `type`=?')
            ->execute('root');

        if (!$objPages->numRows) {
            return $languages;
        }

        while ($objPages->next()) {
            if ($objPages->fallback && !\in_array($objPages->language, $languages['fallbacks'])) {
                $languages['fallbacks'][] = $objPages->language;
            }

            if ($objPages->language && !\in_array($objPages->language, $languages['languages'])) {
                $languages['languages'][] = $objPages->language;
            }
        }

        if (!empty($languages['fallbacks']) && \count($languages['fallbacks']) < 2) {
            $languages['fallback'] = $languages['fallbacks'][0] ?? '';
        }

        return $languages;
    }
}