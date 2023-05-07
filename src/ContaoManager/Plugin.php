<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\ContaoManager;

use Alnv\ContaoCatalogManagerBundle\AlnvContaoCatalogManagerBundle;
use Alnv\ContaoCatalogManagerMultilingualAdapterBundle\AlnvContaoCatalogManagerMultilingualAdapterBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Terminal42\DcMultilingualBundle\Terminal42DcMultilingualBundle;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser)
    {

        return [
            BundleConfig::create(AlnvContaoCatalogManagerMultilingualAdapterBundle::class)
                ->setReplace(['contao-catalog-manager-multilingual-adapter-bundle'])
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    AlnvContaoCatalogManagerBundle::class,
                    Terminal42DcMultilingualBundle::class])
        ];
    }
}