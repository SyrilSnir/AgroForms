<?php

namespace app\core\services\operations\Exhibition;

use app\core\repositories\manage\Exhibition\ExhibitionRepository;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use DateTime;

/**
 * Description of ExhibitionService
 *
 * @author kotov
 */
class ExhibitionService
{
    /**
     *
     * @var ExhibitionRepository
     */
    protected $exhibitions;
    
    public function __construct(ExhibitionRepository $exhibitions)
    {
        $this->exhibitions = $exhibitions;
    }
    
    public function create(ExhibitionForm $form) 
    {
        $exhibition = Exhibition::create(
                $form->title, 
                $form->titleEng,
                $form->description,
                $form->descriptionEng,
                DateTime::createFromFormat('d.m.Y', $form->startDate)->getTimestamp(),
                DateTime::createFromFormat('d.m.Y', $form->endDate)->getTimestamp(),
                );
        $this->exhibitions->save($exhibition);
        return $exhibition;
    }
    
    public function edit($id , ExhibitionForm $form) 
    {
        /** @var Exhibition $exhibition */
        $exhibition = $this->exhibitions->get($id);
        $exhibition->edit(
                $form->title, 
                $form->titleEng,
                $form->description,
                $form->descriptionEng,
                DateTime::createFromFormat('d.m.Y', $form->startDate)->getTimestamp(),
                DateTime::createFromFormat('d.m.Y', $form->endDate)->getTimestamp(),
                );
        $this->exhibitions->save($exhibition);
    }    

}
