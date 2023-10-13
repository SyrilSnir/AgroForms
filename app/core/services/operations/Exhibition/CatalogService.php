<?php

namespace app\core\services\operations\Exhibition;

use app\core\repositories\manage\Exhibition\CatalogRepository;
use app\core\services\operations\DataManqageInterface;

/**
 * Description of CatalogService
 *
 * @author kotov
 */
class CatalogService implements DataManqageInterface
{
     /**
     * 
     * @var CatalogRepository
     */
    protected $repository;
}
