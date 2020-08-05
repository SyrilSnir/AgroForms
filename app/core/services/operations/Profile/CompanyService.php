<?php

namespace app\core\services\operations\Profile;

use app\models\ActiveRecord\Companies\Company;
use app\models\Forms\Manage\Companies\CompanyForm;

/**
 * Description of CompanyService
 *
 * @author kotov
 */
class CompanyService
{
    /**
     *
     * @var Company
     */
    protected $company;
    
    function __construct(Company $company)
    {
        $this->company = $company;
    }
    public function edit(CompanyForm $form) 
    {
        $legalAddress = $this->company->legalAddress;
        $postalAddress = $this->company->postalAddress;
        $bankDetail = $this->company->bankDetails;
        $contact = $this->company->contacts;
        $legalAddress->edit(
                $form->legalAddressForm->index, 
                $form->legalAddressForm->cityId, 
                $form->legalAddressForm->address
                );
        $postalAddress->edit(
                $form->postalAddressForm->index, 
                $form->postalAddressForm->cityId, 
                $form->postalAddressForm->address
                );
        $contact->edit(
                $form->contacts->chiefPosition, 
                $form->contacts->chiefFio, 
                $form->contacts->chiefPhone, 
                $form->contacts->chiefEmail, 
                $form->contacts->managerPosition, 
                $form->contacts->managerFio, 
                $form->contacts->managerPhone, 
                $form->contacts->managerEmail,
                $form->contacts->managerFax,
                $form->contacts->proposalSignaturePost,
                $form->contacts->proposalSignatureName
                );
        $bankDetail->edit(
                $form->bankDetails->rsSchet, 
                $form->bankDetails->ksSchet, 
                $form->bankDetails->bankInfo, 
                $form->bankDetails->bik
                );        
        $this->company->edit(
                $form->name,
                $form->fullName, 
                $form->inn, 
                $form->kpp, 
                $form->phone, 
                $form->site, 
                $form->fax,
                $bankDetail,
                $contact,
                $legalAddress,
                $postalAddress                
                );
        $this->company->save();
        
    }

}
