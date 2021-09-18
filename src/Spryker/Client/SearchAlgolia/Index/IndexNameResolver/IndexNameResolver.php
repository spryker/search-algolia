<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Index\IndexNameResolver;

use Spryker\Client\SearchAlgolia\Dependency\Client\SearchAlgoliaToStoreClientInterface;
use Spryker\Client\SearchAlgolia\SearchAlgoliaConfig;

class IndexNameResolver implements IndexNameResolverInterface
{
    /**
     * @var \Spryker\Client\SearchAlgolia\Dependency\Client\SearchAlgoliaToStoreClientInterface
     */
    protected $storeClient;

    /**
     * @var \Spryker\Client\SearchAlgolia\SearchAlgoliaConfig
     */
    protected $SearchAlgoliaConfig;

    /**
     * @var string|null
     */
    protected static $storeName;

    /**
     * @param \Spryker\Client\SearchAlgolia\Dependency\Client\SearchAlgoliaToStoreClientInterface $storeClient
     * @param \Spryker\Client\SearchAlgolia\SearchAlgoliaConfig $SearchAlgoliaConfig
     */
    public function __construct(SearchAlgoliaToStoreClientInterface $storeClient, SearchAlgoliaConfig $SearchAlgoliaConfig)
    {
        $this->storeClient = $storeClient;
        $this->SearchAlgoliaConfig = $SearchAlgoliaConfig;
    }

    /**
     * @param string $sourceIdentifier
     *
     * @return string
     */
    public function resolve(string $sourceIdentifier): string
    {
        $indexParameters = [
            $this->SearchAlgoliaConfig->getIndexPrefix(),
            $this->getStoreName(),
            $sourceIdentifier,
        ];

        return mb_strtolower(implode('_', array_filter($indexParameters)));
    }

    /**
     * @return string
     */
    protected function getStoreName(): string
    {
        if (static::$storeName === null) {
            $storeTransfer = $this->storeClient->getCurrentStore();

            static::$storeName = $storeTransfer->requireName()->getName();
        }

        return static::$storeName;
    }
}
