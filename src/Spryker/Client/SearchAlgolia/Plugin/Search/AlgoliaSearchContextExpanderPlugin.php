<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Plugin\Search;

use Generated\Shared\Transfer\SearchContextTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchContextExpanderPluginInterface;

/**
 * @method \Spryker\Client\SearchAlgolia\SearchAlgoliaFactory getFactory()
 */
class AlgoliaSearchContextExpanderPlugin extends AbstractPlugin implements SearchContextExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Adds ElasticsearchSearchContextTransfer as a property to SearchContextTransfer.
     * - ElasticsearchSearchContextTransfer holds metadata/settings needed for search (index name etc.)
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return \Generated\Shared\Transfer\SearchContextTransfer
     */
    public function expandSearchContext(SearchContextTransfer $searchContextTransfer): SearchContextTransfer
    {
        return $this->getFactory()->createSearchContextExpander()->expandSearchContext($searchContextTransfer);
    }
}
