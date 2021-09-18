<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\SearchContextExpander;

use Generated\Shared\Transfer\AlgoliaSearchContextTransfer;
use Generated\Shared\Transfer\SearchContextTransfer;
use Spryker\Client\SearchAlgolia\Index\IndexNameResolver\IndexNameResolverInterface;

class SearchContextExpander implements SearchContextExpanderInterface
{
    /**
     * @var \Spryker\Client\SearchAlgolia\Index\IndexNameResolver\IndexNameResolverInterface
     */
    protected $indexNameResolver;

    /**
     * @param \Spryker\Client\SearchAlgolia\Index\IndexNameResolver\IndexNameResolverInterface $indexNameResolver
     */
    public function __construct(IndexNameResolverInterface $indexNameResolver)
    {
        $this->indexNameResolver = $indexNameResolver;
    }

    /**
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return \Generated\Shared\Transfer\SearchContextTransfer
     */
    public function expandSearchContext(SearchContextTransfer $searchContextTransfer): SearchContextTransfer
    {
        $sourceIdentifier = $searchContextTransfer->requireSourceIdentifier()->getSourceIdentifier();
        $indexName = $this->indexNameResolver->resolve($sourceIdentifier);
        $elasticsearchSearchContextTransfer = $this->createAlgoliaSearchContext($indexName, $sourceIdentifier);
        $searchContextTransfer->setAlgoliaSearchContext($elasticsearchSearchContextTransfer);

        return $searchContextTransfer;
    }

    /**
     * @param string $indexName
     * @param string $sourceIdentifier
     *
     * @return \Generated\Shared\Transfer\AlgoliaSearchContextTransfer
     */
    protected function createAlgoliaSearchContext(string $indexName, string $sourceIdentifier): AlgoliaSearchContextTransfer
    {
        $algoliaSearchContextTransfer = new AlgoliaSearchContextTransfer();
        $algoliaSearchContextTransfer->setIndexName($indexName);

        return $algoliaSearchContextTransfer;
    }
}
