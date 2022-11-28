<?php

namespace app\core\services\operations\Documents;

use app\core\repositories\manage\Document\DocumentRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Document\Documents;
use app\models\Forms\Manage\Document\BaseDocumentForm;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of DocumentService
 *
 * @author kotov
 */
class DocumentService implements DataManqageInterface
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
    
    public function create(ManageForm $form): Documents
    {
        $companyId = is_numeric($form->companyId) ? $form->companyId : null;
        $document = Documents::create(
                $form->title, 
                $form->titleEng, 
                $form->description, 
                $form->descriptionEng, 
                $form->exhibitionId,
                $companyId
                );
        if ($form->file) {
            $document->setFile($form->file);
        }
        $this->documents->save($document);
        return $document;
    }
    
    public function edit(int $id, ManageForm $form) : void
    {
        /** @var Documents $document */
        $companyId = is_numeric($form->companyId) ? $form->companyId : null;
        $document = $this->documents->get($id);
        $document->edit(
            $form->title, 
            $form->titleEng, 
            $form->description, 
            $form->descriptionEng, 
            $form->exhibitionId,               
            $companyId
        );
        if ($form->file) {
            $document->setFile($form->file);
        }
        $this->documents->save($document);  
    }
    
    public function remove (int $id) :void
    {        
        /* @var Documents $document */
         $document = $this->documents->get($id);
         $this->documents->remove($document);
    }  

}
