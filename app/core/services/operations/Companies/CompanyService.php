<?php

namespace app\core\services\operations\Companies;

use app\core\repositories\manage\Companies\BankDetailRepository;
use app\core\repositories\manage\Companies\CompanyRepository;
use app\core\repositories\manage\Companies\ContactRepository;
use app\core\repositories\manage\Companies\LegalAddressRepository;
use app\core\repositories\manage\Companies\PostalAddressRepository;
use app\models\ActiveRecord\Companies\BankDetail;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Companies\Contact;
use app\models\ActiveRecord\Companies\LegalAddress;
use app\models\ActiveRecord\Companies\PostalAddress;
use app\models\ActiveRecord\Users\User;
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
     * @var CompanyRepository 
     */
    protected $companies;
    /**
     *
     * @var ContactRepository
     */
    protected $contacts;
    /**
     *
     * @var LegalAddressRepository
     */
    protected $legalAddresses;
    
    /**
     *
     * @var PostalAddressRepository
     */
    protected $postalAddresses;
    
    /**
     *
     * @var BankDetailRepository
     */
    protected $bankDetails;
    
    public function __construct(
            CompanyRepository $companies, 
            ContactRepository $contacts, 
            LegalAddressRepository $legalAddresses, 
            PostalAddressRepository $postalAddresses, 
            BankDetailRepository $bankDetails)
    {
        $this->companies = $companies;
        $this->contacts = $contacts;
        $this->legalAddresses = $legalAddresses;
        $this->postalAddresses = $postalAddresses;
        $this->bankDetails = $bankDetails;
    }
    
    public function create(CompanyForm $form)
    {
        $legalAddress = LegalAddress::create(
                $form->legalAddressForm->index, 
                $form->legalAddressForm->cityId, 
                $form->legalAddressForm->address
                );
        $postalAddress = PostalAddress::create(
                $form->postalAddressForm->index, 
                $form->postalAddressForm->cityId, 
                $form->postalAddressForm->address                
                );
        $contact = Contact::create(
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
        $bankDetail = BankDetail::create(
                $form->bankDetails->rsSchet, 
                $form->bankDetails->ksSchet, 
                $form->bankDetails->bankInfo, 
                $form->bankDetails->bik
                );
        $company = Company::create(                
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
                $postalAddress );
        $this->companies->save($company); 
        return $company;
        
        
    }

        public function edit($id, CompanyForm $form) 
    {
        /** @var LegalAddress $legalAddress */
        /** @var PostalAddress $postalAddress */
        /** @var Contact $contact */
        /** @var BankDetail $bankDetail */
        /** @var Company $company */
        $legalAddress = $this->legalAddresses->get($form->legalAddressForm->id);        
        $postalAddress = $this->postalAddresses->get($form->postalAddressForm->id);
        $contact = $this->contacts->get($form->contacts->id);
        $bankDetail = $this->bankDetails->get($form->bankDetails->id);
        $company = $this->companies->get($id);
        
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
        $company->edit(
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
        $this->companies->save($company);
    }
    
    public function block($id)
    {
        /** @var Company $company */
        /** @var User $member */         
        $company = $this->companies->get($id);
        $member = $company->getMember();
        $company->block();
        if ($member) {
            $member->block();
            $member->save();
        }
        $company->save();
    }
    
    public function unblock($id)
    {
        /** @var Company $company */
        /** @var User $member */        
        $company = $this->companies->get($id);
        $member = $company->getMember();
        $company->unblock();
        if ($member) {
            $member->unblock();
            $member->save();
        }
        $company->save();
    }    

    public function remove($id)
    {
        /** @var Company $company */
        $company = $this->companies->get($id);
        $company->deleteCompany();
        $this->companies->save($company); 
    }            
}
