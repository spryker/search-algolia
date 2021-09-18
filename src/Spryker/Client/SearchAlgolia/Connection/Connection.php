<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Connection;

use Algolia\AlgoliaSearch\SearchClient;
use Generated\Shared\Transfer\SearchConnectionResponseTransfer;

class Connection implements ConnectionInterface
{
    /**
     * @var \Algolia\AlgoliaSearch\SearchClient
     */
    protected $algoliaClient;

    /**
     * @param \Algolia\AlgoliaSearch\SearchClient $client
     */
    public function __construct(SearchClient $client)
    {
        $this->algoliaClient = $client;
    }

    /**
     * @return \Generated\Shared\Transfer\SearchConnectionResponseTransfer
     */
    public function checkConnection(): SearchConnectionResponseTransfer
    {
        $rawResponse = $this->algoliaClient->isAlive();

        $isSuccessful = isset($rawResponse['message']) && $rawResponse['message'] === 'server is alive';

        $searchConnectionResponseTransfer = new SearchConnectionResponseTransfer();
        $searchConnectionResponseTransfer->setIsSuccessfull($isSuccessful);
        $searchConnectionResponseTransfer->setRawResponse($rawResponse);

        return $searchConnectionResponseTransfer;
    }
}
