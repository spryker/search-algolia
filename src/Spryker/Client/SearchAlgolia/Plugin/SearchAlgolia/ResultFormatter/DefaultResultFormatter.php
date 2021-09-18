<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Plugin\SearchAlgolia\ResultFormatter;

use Algolia\AlgoliaSearch\Iterators\ObjectIterator as AlgoliaObjectIterator;

/**
 * @method \Spryker\Client\SearchElasticsearch\SearchElasticsearchFactory getFactory()
 */
class DefaultResultFormatter extends AbstractAlgoliaSearchResultFormatterPlugin
{
    protected const NAME = 'default';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param \Algolia\AlgoliaSearch\Iterators\ObjectIterator $searchResult
     * @param array $requestParameters
     *
     * @return array
     */
    protected function formatSearchResult(AlgoliaObjectIterator $searchResult, array $requestParameters): array
    {
        $results = [];

        foreach ($searchResult as $record) {
            $results[] = $record;
        }

        return $results;
    }
}
