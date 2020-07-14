<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\StandRepository;
use app\models\ActiveRecord\Forms\Stand;
use app\models\Forms\Manage\Forms\StandForm;

/**
 * Description of StandService
 *
 * @author kotov
 */
class StandService
{
    /**
     *
     * @var StandRepository 
     */
    public $stands;
    
    public function __construct(
            StandRepository $repository
            )
    {
        $this->stands = $repository;
    }
    
    public function create(StandForm $form)
    {
        $stand = Stand::create(
                $form->name,
                $form->description, 
                $form->price,
                $form->digitPrice, 
                $form->freeDigits
                );
        if ($form->photo) {
            $stand->setPhoto($form->photo);
        }
        $this->stands->save($stand);
        if ($form->photo) {
            $stand->image_url = $stand->getUploadedFileUrl('photo');
            $stand->image_path = $stand->getUploadedFilePath('photo');
            $this->stands->save($stand);
        }
        return $stand;           
    }
    
    public function remove ($id) 
    {        
        /* @var $stand Unit */
         $stand = $this->stands->get($id);
         $this->stands->remove($stand);
    }    
}
