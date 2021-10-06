<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Reader;

use Algolia\AlgoliaSearch\SearchClient;
use Generated\Shared\Transfer\SearchDocumentTransfer;

class DocumentReader implements DocumentReaderInterface
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
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer $searchDocumentTransfer
     *
     * @return \Generated\Shared\Transfer\SearchDocumentTransfer
     */
    public function readDocument(SearchDocumentTransfer $searchDocumentTransfer): SearchDocumentTransfer
    {
        $indexName = $searchDocumentTransfer
            ->getSearchContextOrFail()
            ->getAlgoliaSearchContextOrFail()
            ->getIndexName();

        $index = $this->algoliaClient->initIndex($indexName);
        $result = $index->getObject($searchDocumentTransfer->getId());

        $searchDocumentTransfer->setData($result);

        return $searchDocumentTransfer;
    }
}
