<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia;

use Algolia\AlgoliaSearch\SearchClient;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SearchAlgolia\Connection\Connection;
use Spryker\Client\SearchAlgolia\Connection\ConnectionInterface;
use Spryker\Client\SearchAlgolia\Dependency\Client\SearchAlgoliaToStoreClientInterface;
use Spryker\Client\SearchAlgolia\Index\IndexNameResolver\IndexNameResolver;
use Spryker\Client\SearchAlgolia\Index\IndexNameResolver\IndexNameResolverInterface;
use Spryker\Client\SearchAlgolia\Index\SourceIdentifier;
use Spryker\Client\SearchAlgolia\Index\SourceIdentifierInterface;
use Spryker\Client\SearchAlgolia\Reader\DocumentReader;
use Spryker\Client\SearchAlgolia\Reader\DocumentReaderInterface;
use Spryker\Client\SearchAlgolia\Search\Search;
use Spryker\Client\SearchAlgolia\Search\SearchInterface;
use Spryker\Client\SearchAlgolia\SearchContextExpander\SearchContextExpander;
use Spryker\Client\SearchAlgolia\SearchContextExpander\SearchContextExpanderInterface;
use Spryker\Client\SearchAlgolia\Writer\DocumentWriter;
use Spryker\Client\SearchAlgolia\Writer\DocumentWriterInterface;

class SearchAlgoliaFactory extends AbstractFactory
{
    /**
     * @return Algolia\AlgoliaSearch\SearchClient
     */
    public function createAlgoliaSearchSearchClient(): SearchClient
    {
        $client = SearchClient::create(
            $this->getConfig()->getApplicationId(),
            $this->getConfig()->getSearchApiKey()
        );

        return $client;
    }

    /**
     * @return Algolia\AlgoliaSearch\SearchClient
     */
    public function createAlgoliaSearchWriteClient(): SearchClient
    {
        $client = SearchClient::create(
            $this->getConfig()->getApplicationId(),
            $this->getConfig()->getWriteApiKey()
        );

        return $client;
    }

    /**
     * @return Algolia\AlgoliaSearch\SearchClient
     */
    public function createAlgoliaSearchAdminClient(): SearchClient
    {
        $client = SearchClient::create(
            $this->getConfig()->getApplicationId(),
            $this->getConfig()->getAdminApiKey()
        );

        return $client;
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Writer\DocumentWriterInterface
     */
    public function createDocumentWriter(): DocumentWriterInterface
    {
        return new DocumentWriter(
            $this->createAlgoliaSearchWriteClient()
        );
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Reader\DocumentReaderInterface
     */
    public function createDocumentReader(): DocumentReaderInterface
    {
        return new DocumentReader(
            $this->createAlgoliaSearchSearchClient()
        );
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Search\SearchInterface
     */
    public function createSearch(): SearchInterface
    {
        return new Search(
            $this->createAlgoliaSearchSearchClient()
        );
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Connection\Connection
     */
    public function createConnection(): ConnectionInterface
    {
        return new Connection(
            $this->createAlgoliaSearchSearchClient()
        );
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Index\SourceIdentifierInterface
     */
    public function createSourceIdentifierChecker(): SourceIdentifierInterface
    {
        return new SourceIdentifier($this->getConfig());
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Index\IndexNameResolver\IndexNameResolverInterface
     */
    public function createIndexNameResolver(): IndexNameResolverInterface
    {
        return new IndexNameResolver(
            $this->getStoreClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\SearchContextExpander\SearchContextExpanderInterface
     */
    public function createSearchContextExpander(): SearchContextExpanderInterface
    {
        return new SearchContextExpander(
            $this->createIndexNameResolver()
        );
    }

    /**
     * @return \Spryker\Client\SearchAlgolia\Dependency\Client\SearchAlgoliaToStoreClientInterface
     */
    public function getStoreClient(): SearchAlgoliaToStoreClientInterface
    {
        return $this->getProvidedDependency(SearchAlgoliaDependencyProvider::CLIENT_STORE);
    }
}
