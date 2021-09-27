<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\SearchAlgolia;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class SearchAlgoliaConfig extends AbstractSharedConfig
{
    /**
     * Available facet types.
     *
     * @var string
     */
    public const FACET_TYPE_ENUMERATION = 'enumeration';

    /**
     * @var string
     */
    public const FACET_TYPE_RANGE = 'range';

    /**
     * @var string
     */
    public const FACET_TYPE_PRICE_RANGE = 'price-range';

    /**
     * @var string
     */
    public const FACET_TYPE_CATEGORY = 'category';

    /**
     * @var string[]
     */
    protected const SUPPORTED_SOURCE_IDENTIFIERS = [];

    /**
     * @api
     *
     * @return string
     */
    public function getAdminApiKey(): string
    {
        return $this->get(SearchAlgoliaConstants::ADMIN_API_KEY);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSearchApiKey(): string
    {
        return $this->get(SearchAlgoliaConstants::SEARCH_API_KEY);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getWriteApiKey(): string
    {
        return $this->get(SearchAlgoliaConstants::WRITE_API_KEY);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getApplicationId(): string
    {
        return $this->get(SearchAlgoliaConstants::APPLICATION_ID);
    }

    /**
     * @api
     *
     * @return string[]
     */
    public function getSupportedSourceIdentifiers(): array
    {
        return static::SUPPORTED_SOURCE_IDENTIFIERS;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getIndexPrefix(): string
    {
        return $this->get(SearchAlgoliaConstants::INDEX_PREFIX, '');
    }
}
