<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SearchAlgolia\Index;

use Generated\Shared\Transfer\SearchContextTransfer;
use Spryker\Client\SearchAlgolia\SearchAlgoliaConfig;

class SourceIdentifier implements SourceIdentifierInterface
{
    /**
     * @var \Spryker\Client\SearchAlgolia\SearchAlgoliaConfig
     */
    protected $config;

    /**
     * @param \Spryker\Client\SearchAlgolia\SearchAlgoliaConfig $config
     */
    public function __construct(SearchAlgoliaConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return bool
     */
    public function isSupported(SearchContextTransfer $searchContextTransfer): bool
    {
        $sourceIdentifier = $searchContextTransfer->requireSourceIdentifier()->getSourceIdentifier();
        $supportedSourceIdentifiers = $this->config->getSupportedSourceIdentifiers();

        return in_array($sourceIdentifier, $supportedSourceIdentifiers, true);
    }
}
