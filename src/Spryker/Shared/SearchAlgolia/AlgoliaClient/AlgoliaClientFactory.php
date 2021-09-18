<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\SearchAlgolia\AlgoliaClient;

use Algolia\AlgoliaSearch\SearchClient;

class AlgoliaClientFactory implements ElasticaClientFactoryInterface
{
    /**
     * @var \Elastica\Client
     */
    protected static $client;

    /**
     * @param array $clientConfig
     *
     * @return \Algolia\AlgoliaSearch\SearchClient
     */
    public function createClient(array $clientConfig): SearchClient
    {
        if (!static::$client) {
            static::$client = (new SearchClient($clientConfig));
        }

        return static::$client;
    }
}
