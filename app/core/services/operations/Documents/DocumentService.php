<?php

namespace app\core\services\operations\Documents;

use app\core\repositories\manage\Document\DocumentRepository;
use app\models\ActiveRecord\Document\Documents;
use app\models\Forms\Manage\Document\DocumentForm;

/**
 * Description of DocumentService
 *
 * @author kotov
 */
class DocumentService 
{
    /**
     *
     * @var DocumentRepository 
     */
    public $documents;
    
    public function __construct(DocumentRepository $documents) 
    {
        $this->documents = $documents;
    }
    
    public function create(DocumentForm $form): Documents
    {
        $document = Documents::create(
                $form->title, 
                $form->titleEng, 
                $form->description, 
                $form->descriptionEng, 
                $form->companyId, 
                $form->exhibitionId
                );
        if ($form->file) {
            $document->setFile($form->file);
        }
        $this->documents->save($document);
        return $document;
    }
    
    public function edit(int $id, DocumentForm $form) 
    {
        /** @var Documents $document */
        $document = $this->documents->get($id);
        $document->edit(
            $form->title, 
            $form->titleEng, 
            $form->description, 
            $form->descriptionEng, 
            $form->companyId, 
            $form->exhibitionId                
        );
        if ($form->file) {
            $document->setFile($form->file);
        }
        $this->documents->save($document);  
    }
    
    public function remove ($id) 
    {        
        /* @var Documents $document */
         $document = $this->documents->get($id);
         $this->documents->remove($document);
    }  

}
