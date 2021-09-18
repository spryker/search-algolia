<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\SearchAlgolia;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface SearchAlgoliaConstants
{
    /**
     * Specification:
     * - Defines an array of extra Algolia request parameters (i.e. ['foo' => 'bar', ...]). (Optional)
     * - @see https://www.algolia.com/doc/api-client/getting-started/request-options/
     *
     * @api
     */
    public const EXTRA = 'SEARCH_ALGOLIA:REQUEST_OPTIONS';

    /**
     * Specification:
     * - Defines prefix for Algolia indexes.
     *
     * @api
     */
    public const INDEX_PREFIX = 'SEARCH_ALGOLIA:INDEX_PREFIX';

    /**
     * Specification:
     * - This is your unique application identifier. It's used to identify you when using Algolia's API.
     * - @see https://www.algolia.com/apps/02324RT7JY/api-keys/all
     *
     * @api
     */
    public const APPLICATION_ID = 'SEARCH_ALGOLIA:APPLICATION_ID';

    /**
     * Specification:
     * - This is the public API key which can be safely used in your frontend code.This key is usable for search queries and it's also able to list the indices you've got access to.
     * - @see https://www.algolia.com/apps/02324RT7JY/api-keys/all
     *
     * @api
     */
    public const SEARCH_API_KEY = 'SEARCH_ALGOLIA:SEARCH_API_KEY';

    /**
     * Specification:
     * - This is a private API key. Please keep it secret and use it ONLY from your backend: this key is used to create, update and DELETE your indices. You CANNOT use this key to manage your API keys.
     * - @see https://www.algolia.com/apps/02324RT7JY/api-keys/all
     *
     * @api
     */
    public const WRITE_API_KEY = 'SEARCH_ALGOLIA:WRITE_API_KEY';

    /**
     * Specification:
     * - This is the ADMIN API key. Please keep it secret and use it ONLY from your backend: this key is used to create, update and DELETE your indices. You can also use it to manage your API keys.
     * - @see https://www.algolia.com/apps/02324RT7JY/api-keys/all
     *
     * @api
     */
    public const ADMIN_API_KEY = 'SEARCH_ALGOLIA:ADMIN_API_KEY';
}
