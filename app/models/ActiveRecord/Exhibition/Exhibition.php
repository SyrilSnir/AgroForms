<?php

namespace app\models\ActiveRecord\Exhibition;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use DateTime;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exhibitions}}".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string|null $title_eng Заголовок (ENG)
 * @property string|null $description Описание
 * @property string|null $description_eng Описание (ENG)
 * @property string $address Место проведения
 * @property int $company_id Компания организатор
 * @property int $start_date Дата начала
 * @property int $end_date Дата окончания
 * @property int $assembling_start Дата нвчала монтажа
 * @property int $assembling_end Дата окончания монтажа
 * @property int $disassembling_start Дата нвчала демонтажа
 * @property int $disassembling_end Дата окончания демонтажа
 * @property int $status Статус
 * 
 * @property Company $company
 * @property Contracts[] $contracts
 */
class Exhibition extends ActiveRecord
{    
    use MultilangTrait;
    
    /**
     * Активна
     */
    const STATUS_ACTIVE = 1;
    /**
     * Отменена
     */
    const STATUS_DECLINED = 0;
    /**
     * Проект
     */
    const STATUS_PROJECT = 2;
    /**
     * Завершена
     */
    const STATUS_COMPLETED = 3;
    
    public static function create(
            ExhibitionForm $form
            ):self
    {
                        
               
        $exhibition = new self();
        $exhibition->title = $form->title;
        $exhibition->title_eng = $form->titleEng;
        $exhibition->description = $form->description;
        $exhibition->description_eng = $form->descriptionEng;
        $exhibition->start_date = $form->startDate ? DateTime::createFromFormat('d.m.Y', $form->startDate)->getTimestamp() : null;
        $exhibition->end_date = $form->endDate ? DateTime::createFromFormat('d.m.Y', $form->endDate)->getTimestamp() : null;
        $exhibition->assembling_start = $form->startAssembling ? DateTime::createFromFormat('d.m.Y', $form->startAssembling)->getTimestamp() : null;
        $exhibition->assembling_end = $form->endAssembling ? DateTime::createFromFormat('d.m.Y', $form->endAssembling)->getTimestamp() : null;
        $exhibition->disassembling_start = $form->startDisassembling ? DateTime::createFromFormat('d.m.Y', $form->startDisassembling)->getTimestamp() : null;
        $exhibition->disassembling_end = $form->endDisassembling ? DateTime::createFromFormat('d.m.Y', $form->endDisassembling)->getTimestamp() : null;
        $exhibition->address = $form->address;
        $exhibition->company_id = $form->companyId;
        $exhibition->status = $form->status;
        return $exhibition;
    }
    
    public function edit(
            ExhibitionForm $form
            )
    {
        $this->title = $form->title;
        $this->title_eng = $form->titleEng;
        $this->description = $form->description;
        $this->description_eng = $form->descriptionEng;
        $this->start_date = $form->startDate ? DateTime::createFromFormat('d.m.Y', $form->startDate)->getTimestamp() : null;
        $this->end_date = $form->endDate ? DateTime::createFromFormat('d.m.Y', $form->endDate)->getTimestamp() : null;
        $this->assembling_start = $form->startAssembling ? DateTime::createFromFormat('d.m.Y', $form->startAssembling)->getTimestamp() : null;
        $this->assembling_end = $form->endAssembling ? DateTime::createFromFormat('d.m.Y', $form->endAssembling)->getTimestamp() : null;
        $this->disassembling_start = $form->startDisassembling ? DateTime::createFromFormat('d.m.Y', $form->startDisassembling)->getTimestamp() : null;
        $this->disassembling_end = $form->endDisassembling ? DateTime::createFromFormat('d.m.Y', $form->endDisassembling)->getTimestamp() : null;
        $this->address = $form->address;
        $this->address = $form->address;
        $this->company_id = $form->companyId;   
        $this->status = $form->status;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exhibitions}}';
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }    
    
    /**
     * Gets query for [[Contracts]].
     *
     * @return ActiveQuery
     */    
    public function getContracts()
    {
        return $this->hasMany(Contracts::class, ['exhibition_id' => 'id']);
    }
    
    public function getConrtactsForCompany(int $companyId)
    {
        return $this->getContracts()->andWhere(['company_id' => $companyId])->all();
    }
}
