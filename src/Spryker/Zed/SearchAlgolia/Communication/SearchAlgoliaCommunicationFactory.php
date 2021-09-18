<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SearchAlgolia\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Spryker\Zed\SearchAlgolia\SearchAlgoliaConfig getConfig()
 * @method \Spryker\Zed\SearchAlgolia\Persistence\SearchAlgoliaEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\SearchAlgolia\Business\SearchAlgoliaFacadeInterface getFacade()
 * @method \Spryker\Zed\SearchAlgolia\Persistence\SearchAlgoliaRepositoryInterface getRepository()
 */
class SearchAlgoliaCommunicationFactory extends AbstractCommunicationFactory
{
}
