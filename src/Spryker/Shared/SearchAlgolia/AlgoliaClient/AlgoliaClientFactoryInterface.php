<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\SearchAlgolia\AlgoliaClient;

use Algolia\AlgoliaSearch\SearchClient;

interface AlgoliaClientFactoryInterface
{
    /**
     * @param array $clientConfig
     *
     * @return \Algolia\AlgoliaSearch\SearchClient
     */
    public function createClient(array $clientConfig): SearchClient;
}
