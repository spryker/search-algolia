<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Writer;

use Algolia\AlgoliaSearch\SearchClient;
use Generated\Shared\Transfer\SearchDocumentTransfer;

class DocumentWriter implements DocumentWriterInterface
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
     * @return bool
     */
    public function writeDocument(SearchDocumentTransfer $searchDocumentTransfer): bool
    {
        $indexName = $searchDocumentTransfer
            ->getSearchContextOrFail()
            ->getAlgoliaSearchContextOrFail()
            ->getIndexNameOrFail();

        $index = $this->algoliaClient->initIndex($indexName);

        $data = $searchDocumentTransfer->getData();
        $data['id'] = $searchDocumentTransfer->getIdOrFail();
        $index->saveObject($searchDocumentTransfer->getData(), ['objectIDKey' => 'id']);

        return true; // TODO: return based on response
    }

    /**
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer[] $searchDocumentTransfers
     *
     * @return bool
     */
    public function writeDocuments(array $searchDocumentTransfers): bool
    {
        $objects = [];

        foreach ($searchDocumentTransfers as $searchDocumentTransfer) {
            if ($searchDocumentTransfer->getData()['type'] !== 'product_abstract') {
                continue;
            }
            $data = $searchDocumentTransfer->getData();
            $data['id'] = $searchDocumentTransfer->getIdOrFail();
            $objects[] = $data;
        }

        $indexName = $searchDocumentTransfer
            ->getSearchContextOrFail()
            ->getAlgoliaSearchContextOrFail()
            ->getIndexNameOrFail();

        $index = $this->algoliaClient->initIndex($indexName);
        $index->saveObjects($objects, ['objectIDKey' => 'id']);

        return true; // TODO: return based on response
    }

    /**
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer $searchDocumentTransfer
     *
     * @return bool
     */
    public function deleteDocument(SearchDocumentTransfer $searchDocumentTransfer): bool
    {
        $indexName = $searchDocumentTransfer
            ->getSearchContextOrFail()
            ->getAlgoliaSearchContextOrFail()
            ->getIndexNameOrFail();

        $index = $this->algoliaClient->initIndex($indexName);
        $index->deleteObject($searchDocumentTransfer->getId());

        return true; // TODO return based on response
    }

    /**
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer[] $searchDocumentTransfers
     *
     * @return bool
     */
    public function deleteDocuments(array $searchDocumentTransfers): bool
    {
        $objectIds = [];
        foreach ($searchDocumentTransfers as $searchDocumentTransfer) {
            $objectIds[] = $searchDocumentTransfer->getId();
        }

        $indexName = $searchDocumentTransfer
            ->getSearchContextOrFail()
            ->getAlgoliaSearchContextOrFail()
            ->getIndexNameOrFail();

        $index = $this->algoliaClient->initIndex($indexName);
        $index->deleteObjects($objectIds);

        return true; // TODO return based on response
    }
}
