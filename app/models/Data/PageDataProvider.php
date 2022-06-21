<?php

namespace app\models\Data;

use app\models\Forms\RowsCountForm;
use yii\data\ActiveDataProvider;

/**
 * Description of PageDataProvider
 *
 * @author kotov
 */
class PageDataProvider
{
    /**
     * 
     * @var ActiveDataProvider
     */
    protected $dataProvider;
    
    /**
     * 
     * @var RowsCountForm
     */
    protected $rowsCountForm;
    
    public static function create(ActiveDataProvider $dataProvider, RowsCountForm $rowsCountForm): self
    {
        return new self($dataProvider, $rowsCountForm);
    }
    
    public function __construct(ActiveDataProvider $dataProvider, RowsCountForm $rowsCountForm)
    {
        $this->dataProvider = $dataProvider;
        $this->rowsCountForm = $rowsCountForm;
    }

    public function getDataProvider(): ActiveDataProvider
    {
        return $this->dataProvider;
    }

    public function getRowsCountForm(): RowsCountForm
    {
        return $this->rowsCountForm;
    }


}
