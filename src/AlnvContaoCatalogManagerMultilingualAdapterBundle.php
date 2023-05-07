<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlnvContaoCatalogManagerMultilingualAdapterBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}