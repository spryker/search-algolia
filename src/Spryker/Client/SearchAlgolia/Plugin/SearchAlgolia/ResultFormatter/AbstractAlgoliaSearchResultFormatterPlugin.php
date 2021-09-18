<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Plugin\SearchAlgolia\ResultFormatter;

use Algolia\AlgoliaSearch\Iterators\ObjectIterator as AlgoliaObjectIterator;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface;

abstract class AbstractAlgoliaSearchResultFormatterPlugin extends AbstractPlugin implements ResultFormatterPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return mixed
     */
    public function formatResult($searchResult, array $requestParameters = [])
    {
        $this->assertResultType($searchResult);

        return $this->formatSearchResult($searchResult, $requestParameters);
    }

    /**
     * @param mixed $searchResult
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    protected function assertResultType($searchResult): void
    {
        if (!$searchResult instanceof AlgoliaObjectIterator) {
            throw new InvalidArgumentException(sprintf(
                'Expected search result type was "%s", got "%s" instead.',
                AlgoliaObjectIterator::class,
                get_class($searchResult)
            ));
        }
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return mixed
     */
    abstract protected function formatSearchResult(AlgoliaObjectIterator $searchResult, array $requestParameters);
}
