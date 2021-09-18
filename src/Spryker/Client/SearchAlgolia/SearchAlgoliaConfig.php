<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia;

use Spryker\Client\Kernel\AbstractBundleConfig;

class SearchAlgoliaConfig extends AbstractBundleConfig
{
    public const FACET_NAME_AGGREGATION_SIZE = 10;

    /**
     * @api
     *
     * @return array
     */
    public function getClientConfig(): array
    {
        return $this->getSharedConfig()->getClientConfig();
    }

    /**
     * @api
     *
     * @return array
     */
    public function getApplicationId(): string
    {
        return $this->getSharedConfig()->getApplicationId();
    }

    /**
     * @api
     *
     * @return array
     */
    public function getAdminApiKey(): string
    {
        return $this->getSharedConfig()->getAdminApiKey();
    }

    /**
     * @api
     *
     * @return array
     */
    public function getSearchApiKey(): string
    {
        return $this->getSharedConfig()->getSearchApiKey();
    }

    /**
     * @api
     *
     * @return array
     */
    public function getWriteApiKey(): string
    {
        return $this->getSharedConfig()->getWriteApiKey();
    }

    /**
     * @api
     *
     * @return string[]
     */
    public function getSupportedSourceIdentifiers(): array
    {
        return $this->getSharedConfig()->getSupportedSourceIdentifiers();
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isDevelopmentMode(): bool
    {
        return APPLICATION_ENV === 'development' || APPLICATION_ENV === 'docker.dev';
    }

    /**
     * @api
     *
     * @return string
     */
    public function getIndexPrefix(): string
    {
        return $this->getSharedConfig()->getIndexPrefix();
    }
}
