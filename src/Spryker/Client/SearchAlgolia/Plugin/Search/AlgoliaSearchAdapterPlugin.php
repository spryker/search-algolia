<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Plugin\Search;

use Generated\Shared\Transfer\SearchConnectionResponseTransfer;
use Generated\Shared\Transfer\SearchContextTransfer;
use Generated\Shared\Transfer\SearchDocumentTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\ConnectionCheckerAdapterPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchAdapterPluginInterface;
use SprykerTest\Client\Search\Helper\InMemorySearchPluginInterface;

/**
 * @method \Spryker\Client\SearchAlgolia\SearchAlgoliaClient getClient()
 * @method \Spryker\Client\SearchAlgolia\SearchAlgoliaFactory getFactory()
 */
class AlgoliaSearchAdapterPlugin extends AbstractPlugin implements SearchAdapterPluginInterface, ConnectionCheckerAdapterPluginInterface, InMemorySearchPluginInterface
{
    /**
     * @var string
     */
    protected const NAME = 'algolia';

    /**
     * @param string $source
     *
     * @return array
     */
    public function getAllKeys(string $source): array
    {
        return [];
    }

    /**
     * @return void
     */
    public function deleteAll(): void
    {
    }

    /**
     * {@inheritDoc}
     * - Performs search in Algolia.
     *
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface[] $resultFormatters
     * @param array $requestParameters
     *
     * @return array
     */
    public function search(QueryInterface $searchQuery, array $resultFormatters = [], array $requestParameters = [])
    {
        return $this->getClient()->search($searchQuery, $resultFormatters, $requestParameters);
    }

    /**
     * {@inheritDoc}
     * - Reads a single document from Algolia.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer $searchDocumentTransfer
     *
     * @return \Generated\Shared\Transfer\SearchDocumentTransfer
     */
    public function readDocument(SearchDocumentTransfer $searchDocumentTransfer): SearchDocumentTransfer
    {
        return $this->getClient()->readDocument($searchDocumentTransfer);
    }

    /**
     * {@inheritDoc}
     * - Writes a single document to Algolia.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer $searchDocumentTransfer
     *
     * @return bool
     */
    public function writeDocument(SearchDocumentTransfer $searchDocumentTransfer): bool
    {
        return $this->getClient()->writeDocument($searchDocumentTransfer);
    }

    /**
     * {@inheritDoc}
     * - Writes multiple documents to Algolia.
     *
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer[] $searchDocumentTransfers
     *
     * @return bool
     */
    public function writeDocuments(array $searchDocumentTransfers): bool
    {
        return $this->getClient()->writeDocuments($searchDocumentTransfers);
    }

    /**
     * {@inheritDoc}
     * - Deletes a single document from Algolia.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer $searchDocumentTransfer
     *
     * @return bool
     */
    public function deleteDocument(SearchDocumentTransfer $searchDocumentTransfer): bool
    {
        return $this->getClient()->deleteDocument($searchDocumentTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchDocumentTransfer[] $searchDocumentTransfers
     *
     * @return bool
     */
    public function deleteDocuments(array $searchDocumentTransfers): bool
    {
        return $this->getClient()->deleteDocuments($searchDocumentTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return bool
     */
    public function isApplicable(SearchContextTransfer $searchContextTransfer): bool
    {
        return $this->getFactory()->createSourceIdentifierChecker()->isSupported($searchContextTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\SearchConnectionResponseTransfer
     */
    public function checkConnection(): SearchConnectionResponseTransfer
    {
        return $this->getClient()->checkConnection();
    }
}
