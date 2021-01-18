<?php
/**
 * Copyright (C) 2021 Merchant's Edition GbR
 * Copyright (C) 2017-2018 thirty bees
 * Copyright (C) 2007-2016 PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@merchantsedition.com so we can send you a copy immediately.
 *
 * @author    Merchant's Edition <contact@merchantsedition.com>
 * @author    thirty bees <contact@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2021 Merchant's Edition GbR
 * @copyright 2017-2018 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   Open Software License (OSL 3.0)
 * PrestaShop is an internationally registered trademark of PrestaShop SA.
 * thirty bees is an extension to the PrestaShop software by PrestaShop SA.
 */

/**
 * Class Core_Foundation_Database_EntityManager
 */
// @codingStandardsIgnoreStart
class Core_Foundation_Database_EntityManager
{
    // @codingStandardIgnoreEnd

    protected $db;
    protected $configuration;

    protected $entityMetaData = [];

    /**
     * Core_Foundation_Database_EntityManager constructor.
     *
     * @param Core_Foundation_Database_DatabaseInterface $db
     * @param Core_Business_ConfigurationInterface       $configuration
     *
     * @since 1.0.0
     * @version 1.0.0 Initial version
     */
    public function __construct(
        Core_Foundation_Database_DatabaseInterface $db,
        Core_Business_ConfigurationInterface $configuration
    ) {
        $this->db = $db;
        $this->configuration = $configuration;
    }

    /**
     * Return current database object used
     *
     * @return Core_Foundation_Database_DatabaseInterface
     *
     * @since 1.0.0
     * @version 1.0.0 Initial version
     */
    public function getDatabase()
    {
        return $this->db;
    }

    /**
     * Return current repository used
     *
     * @param string $className
     *
     * @return mixed
     *
     * @since 1.0.0
     * @version 1.0.0 Intial version
     */
    public function getRepository($className)
    {
        if (is_callable([$className, 'getRepositoryClassName'])) {
            $repositoryClass = call_user_func([$className, 'getRepositoryClassName']);
        } else {
            $repositoryClass = null;
        }

        if (!$repositoryClass) {
            $repositoryClass = 'Core_Foundation_Database_EntityRepository';
        }

        $repository = new $repositoryClass(
            $this,
            $this->configuration->get('_DB_PREFIX_'),
            $this->getEntityMetaData($className)
        );

        return $repository;
    }

    /**
     * Return entity's meta data
     *
     * @param string $className
     *
     * @return mixed
     * @throws Adapter_Exception
     *
     * @since 1.0.0
     * @version 1.0.0 Initial version
     */
    public function getEntityMetaData($className)
    {
        if (!array_key_exists($className, $this->entityMetaData)) {
            $metaDataRetriever = new Adapter_EntityMetaDataRetriever();
            $this->entityMetaData[$className] = $metaDataRetriever->getEntityMetaData($className);
        }

        return $this->entityMetaData[$className];
    }

    /**
     * Flush entity to DB
     *
     * @param Core_Foundation_Database_EntityInterface $entity
     *
     * @return $this
     *
     * @since 1.0.0
     * @version 1.0.0 Initial version
     */
    public function save(Core_Foundation_Database_EntityInterface $entity)
    {
        $entity->save();

        return $this;
    }

    /**
     * DElete entity from DB
     *
     * @param Core_Foundation_Database_EntityInterface $entity
     *
     * @return $this
     *
     * @since 1.0.0
     * @version 1.0.0 Initial version
     */
    public function delete(Core_Foundation_Database_EntityInterface $entity)
    {
        $entity->delete();

        return $this;
    }
}
