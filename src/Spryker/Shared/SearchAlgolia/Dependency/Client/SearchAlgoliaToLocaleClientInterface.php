<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\SearchAlgolia\Dependency\Client;

interface SearchAlgoliaToLocaleClientInterface
{
    /**
     * @return string
     */
    public function getCurrentLocale();
}
