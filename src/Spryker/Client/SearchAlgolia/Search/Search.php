<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Search;

use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\SearchIndex;
use Generated\Shared\Transfer\SearchContextTransfer;
use Generated\Shared\Transfer\SearchResultFacetDataTransfer;
use Generated\Shared\Transfer\SearchResultFacetTransfer;
use Generated\Shared\Transfer\SearchResultTransfer;
use RuntimeException;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchContextAwareQueryInterface;

class Search implements SearchInterface
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
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\SearchResultFormatterPluginInterface[] $resultFormatters
     * @param array $requestParameters
     *
     * @return array
     */
    public function search(QueryInterface $searchQuery, array $resultFormatters = [], array $requestParameters = [])
    {
        $searchResultTransfer = $this->executeQuery($searchQuery, $requestParameters);

        if (!$resultFormatters) {
            return $searchResultTransfer;
        }

        return $this->formatSearchResults($resultFormatters, $searchResultTransfer, $requestParameters);
    }

    /**
     * @param array $resultFormatters
     * @param \Generated\Shared\Transfer\SearchResultTransfer $searchResultTransfer
     * @param array $requestParameters
     *
     * @return array
     */
    protected function formatSearchResults(array $resultFormatters, SearchResultTransfer $searchResultTransfer, array $requestParameters): array
    {
        $formattedSearchResult = [];

        foreach ($resultFormatters as $resultFormatter) {
            $formattedSearchResult[$resultFormatter->getName()] = $resultFormatter->formatResult($searchResultTransfer, $requestParameters);
        }

        return $formattedSearchResult;
    }

    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $query
     * @param array $requestParameters
     *
     * @return \Generated\Shared\Transfer\SearchResultTransfer
     */
    protected function executeQuery(QueryInterface $query, array $requestParameters)
    {
        if (isset($requestParameters['category'])) {
            $requestParameters['category.all-parents'] = $requestParameters['category'];
            unset($requestParameters['category']);
        }
        $searchContext = $this->getSearchContext($query);

        $index = $this->getIndexForQueryFromSearchContext($searchContext);

        $requestOptions = $this->buildRequestOptions($requestParameters);

        $rawSearchResult = $index->search($requestParameters['q'] ?? '', $requestOptions); // TODO implement new way of transporting query data

        return $this->formatRawSearchResults($rawSearchResult);
    }

    /**
     * @param array $requestParameters
     *
     * @return array
     */
    protected function buildRequestOptions(array $requestParameters): array
    {
        $requestOptions = [];

        $filters = [
            'type:product_abstract',
            'locale:en_US',
        ];

        $requestOptions['filters'] = implode(' AND ', $filters);

        $requestOptions['facets'] = ['*'];

        if (!isset($requestParameters['ipp'])) {
            $requestOptions['hitsPerPage'] = 12;
        }

        if (isset($requestParameters['ipp'])) {
            $requestOptions['hitsPerPage'] = $requestParameters['ipp'];
        }

        $page = 0;

        if (isset($requestParameters['page'])) {
            $page = $requestParameters['page'];
            unset($requestParameters['page']);
        }

        $requestOptions['page'] = $page;

        if (isset($requestParameters['ipp'])) {
            $requestOptions['hitsPerPage'] = $requestParameters['ipp'];
        }

        $facetFilters = $this->buildFacetFilters($requestParameters);

        if ($facetFilters) {
            $requestOptions['facetFilters'] = $facetFilters;
        }

        return $requestOptions;
    }

    /**
     * @param array $rawSearchResult
     *
     * @return \Generated\Shared\Transfer\SearchResultTransfer
     */
    protected function formatRawSearchResults(array $rawSearchResult): SearchResultTransfer
    {
        $searchResultTransfer = new SearchResultTransfer();
        $searchResultTransfer->setHits($rawSearchResult['nbHits']);
        $searchResultTransfer->setResults($rawSearchResult['hits']);

        foreach ($rawSearchResult['facets'] as $facetName => $facetValues) {
            $formattedFacetName = $this->getFormattedFacetName($facetName);
            $searchResultFacetTransfer = new SearchResultFacetTransfer();
            $searchResultFacetTransfer
                ->setName($formattedFacetName)
                ->setCount(count($facetValues));

            foreach ($facetValues as $facetKey => $facetCount) {
                $searchResultFacetDataTransfer = new SearchResultFacetDataTransfer();
                $searchResultFacetDataTransfer
                    ->setName($facetKey)
                    ->setCount($facetCount);

                $searchResultFacetTransfer->addSearchResultFacetData($searchResultFacetDataTransfer);
            }

            if (isset($rawSearchResult['facets_stats'][$facetName])) {
                $searchResultFacetTransfer->setStatistics($rawSearchResult['facets_stats'][$facetName]);
            }

            $searchResultTransfer->addFacet($searchResultFacetTransfer);
        }

        return $searchResultTransfer;
    }

    /**
     * @param array $requestParameters
     *
     * @return array
     */
    protected function buildFacetFilters(array $requestParameters): array
    {
        $ignoreParams = [
            'q' => true,
            'ipp' => true,
        ];

        $facetFilters = [];

        foreach ($requestParameters as $key => $value) {
            if (isset($ignoreParams[$key])) {
                continue;
            }

            if ($this->isMinMax($value)) {
                $facetFilters[] = sprintf('(%s:%s TO %s)', $key, $value['min'], $value['max']);

                continue;
            }

            if (is_array($value)) {
                $toCombine = [];
                foreach ($value as $item) {
                    $toCombine[] = sprintf('%s:%s', $key, $item);
                }

                $facetFilters[] = $toCombine;

                continue;
            }

            $facetFilters[] = sprintf('%s:%s', $key, $value);
        }

        return $facetFilters;
    }

    /**
     * @param string|array $value
     *
     * @return bool
     */
    protected function isMinMax($value): bool
    {
        if (is_array($value) && isset($value['min']) && isset($value['max'])) {
            return true;
        }

        return false;
    }

    /**
     * @param string $facetName
     *
     * @return string
     */
    protected function getFormattedFacetName(string $facetName): string
    {
        if ($facetName === 'category.all-parents') {
            return 'category';
        }

        return str_replace('facet.', '', $facetName);
    }

    /**
     * @deprecated Will be replaced with inline usage when SearchContextAwareQueryInterface is merged into QueryInterface.
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\SearchContextAwareQueryInterface|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     *
     * @throws \RuntimeException
     *
     * @return \Generated\Shared\Transfer\SearchContextTransfer
     */
    protected function getSearchContext($searchQuery): SearchContextTransfer
    {
        if (!$searchQuery instanceof SearchContextAwareQueryInterface) {
            throw new RuntimeException(
                sprintf(
                    'Query class %s doesn\'t implement %s interface.',
                    get_class($searchQuery),
                    SearchContextAwareQueryInterface::class
                )
            );
        }

        return $searchQuery->getSearchContext();
    }

    /**
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return \Algolia\AlgoliaSearch\SearchIndex
     */
    protected function getIndexForQueryFromSearchContext(SearchContextTransfer $searchContextTransfer): SearchIndex
    {
        $indexName = $this->getIndexName($searchContextTransfer);

        return $this->algoliaClient->initIndex($indexName);
    }

    /**
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return void
     */
    protected function assertSearchContextTransferHasIndexName(SearchContextTransfer $searchContextTransfer): void
    {
        $searchContextTransfer->getElasticsearchContextOrFail()->requireIndexName();
    }

    /**
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return string
     */
    protected function getIndexName(SearchContextTransfer $searchContextTransfer): string
    {
        $this->assertSearchContextTransferHasIndexName($searchContextTransfer);

        return $searchContextTransfer
            ->getAlgoliaSearchContextOrFail()
            ->getIndexNameOrFail();
    }
}
