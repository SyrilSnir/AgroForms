<?php

use app\models\Forms\Manage\Companies\CompanyForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var  View  $this */
/** @var ActiveForm $form */
/** @var CompanyForm $model */

$this->title = t('Edit company', 'company') . ': ' . $model->name;
if (!empty($model->getFirstErrors())):?>
<div class="callout callout-info">
    <h5><i class="fas fa-info" style="color:red"></i> <?php echo Yii::t('app','Note')?>:</h5>
        <?php echo Yii::t('app','Required fields are missing') ?>
    </div>
<?php endif ;?>
<div class="update-form">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col">                           
                            <?php $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                            ]); ?>
                            <ul id="company-tabs" class="nav nav-tabs">
                              <li class="nav-item">
                                <a class="nav-link active" href="#about" tabindex="1" data-toggle="tab"><?php echo t('About company','company') ?></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="#address" tabindex="2" data-toggle="tab"><?php echo t('Address','company') ?></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="#contacts" tabindex="3" data-toggle="tab"><?php echo t('Contacts','company') ?></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="#bank" tabindex="4" data-toggle="tab"><?php echo t('Bank details','company') ?></a>
                              </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab">                            
                                <?= $form->field($model, 'name')->textInput(['readonly' => '']) ?>
                                <?= $form->field($model, 'fullName')->textInput(['readonly' => '']) ?>
                                <?= $form->field($model, 'inn')->textInput(['readonly' => '']) ?>
                                <?= $form->field($model, 'kpp')->textInput(['readonly' => '']) ?>
                                <?= $form->field($model, 'phone')->textInput() ?>
                                <?= $form->field($model, 'fax')->textInput() ?>
                                <?= $form->field($model, 'site')->textInput() ?>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="card card-info">
                                        <div class="card-header"><?php echo t('Legal address','company') ?></div>
                                        <div class="card-body">
                                        <?= $form->field($model->legalAddressForm, 'index')->textInput(['readonly' => '']) ?>
                                        <?= $form->field($model->legalAddressForm, 'address')->textInput(['readonly' => '']) ?>
                                        <?= $form->field($model->legalAddressForm, 'countryId')->widget(Select2::class,
                                        [
                                            'data' => $model->legalAddressForm->countriesList(),
                                            'options' => [ 'id' => 'l_country' ],
                                        ])
                                        ?>
                                        <?= $form->field($model->legalAddressForm, 'regionId')->widget(DepDrop::class,
                                        [
                                            'data' => $model->legalAddressForm->regionsList(),
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'options' => [ 'id' => 'l_region' ],
                                            'pluginOptions' => [
                                                'depends' => ['l_country'],
                                                'placeholder' => 'Select...',
                                                'url' => '/api/geography/get-regions'
                                            ]                            
                                        ])
                                        ?> 
                                        <?= $form->field($model->legalAddressForm, 'cityId')->widget(DepDrop::class,
                                                [
                                                    'data' => $model->legalAddressForm->citiesList(),
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'options' => [ 'id' => 'l_city' ],
                                                    'pluginOptions' => [
                                                        'depends' => ['l_region'],
                                                        'placeholder' => 'Select...',
                                                        'url' => '/api/geography/get-cities'
                                                    ]                            
                                                ])
                                        ?>                  
                                        </div>
                                    </div>
                                    <div class="card card-info">
                                        <div class="card-header"><?php echo t('Mailing address','company')?></div>
                                        <div class="card-body">
                                            <?= $form->field($model->postalAddressForm, 'index')->textInput(['readonly' => '']) ?>
                                            <?= $form->field($model->postalAddressForm, 'address')->textInput(['readonly' => '']) ?>  
                                            <?= $form->field($model->postalAddressForm, 'countryId')->widget(Select2::class,
                                                    [
                                                        'data' => $model->postalAddressForm->countriesList(),
                                                        'options' => [ 'id' => 'p_country' ],
                                                    ])
                                            ?> 
                                            <?= $form->field($model->postalAddressForm, 'regionId')->widget(DepDrop::class,
                                                    [
                                                        'data' => $model->postalAddressForm->regionsList(),
                                                        'type' => DepDrop::TYPE_SELECT2,
                                                        'options' => [ 'id' => 'p_region' ],
                                                        'pluginOptions' => [
                                                            'depends' => ['p_country'],
                                                            'placeholder' => 'Select...',
                                                            'url' => '/api/geography/get-regions'
                                                        ]                            
                                                    ])
                                            ?> 
                                            <?= $form->field($model->postalAddressForm, 'cityId')->widget(DepDrop::class,
                                                    [
                                                        'data' => $model->postalAddressForm->citiesList(),
                                                        'type' => DepDrop::TYPE_SELECT2,
                                                        'options' => [ 'id' => 'p_city' ],
                                                        'pluginOptions' => [
                                                            'depends' => ['p_region'],
                                                            'placeholder' => 'Select...',
                                                            'url' => '/api/geography/get-cities'
                                                        ]                            
                                                    ])
                                            ?>                 
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="card card-info">
                                        <div class="card-header"><?php echo t('Head of company','company') ?></div>
                                        <div class="card-body">
                                            <?= $form->field($model->contacts, 'chiefPosition')->textInput() ?>
                                            <?= $form->field($model->contacts, 'chiefFio')->textInput() ?>
                                            <?= $form->field($model->contacts, 'chiefPhone')->textInput() ?>
                                            <?= $form->field($model->contacts, 'chiefEmail')->textInput() ?>
                                        </div>

                                    </div>
                                    <div class="card card-info">
                                        <div class="card-header"><?php echo t('Project manager','company') ?></div>
                                        <div class="card-body">
                                            <?= $form->field($model->contacts, 'managerPosition')->textInput() ?>
                                            <?= $form->field($model->contacts, 'managerFio')->textInput() ?>
                                            <?= $form->field($model->contacts, 'managerPhone')->textInput() ?>
                                            <?= $form->field($model->contacts, 'managerEmail')->textInput() ?>
                                            <?= $form->field($model->contacts, 'managerFax')->textInput() ?>
                                        </div>

                                    </div> 
                                    <div class="card card-info">
                                        <div class="card-header"><?php echo t('Signer (used in proposal)','company') ?></div>
                                        <div class="card-body">
                                            <?= $form->field($model->contacts, 'proposalSignaturePost')->textInput() ?>
                                            <?= $form->field($model->contacts, 'proposalSignatureName')->textInput() ?>
                                        div>

                                    </div>                                 
                                </div>

                                <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="home-tab">
                                            <?= $form->field($model->bankDetails, 'rsSchet')->textInput(['readonly' => '']) ?>
                                            <?= $form->field($model->bankDetails, 'ksSchet')->textInput(['readonly' => '']) ?>
                                            <?= $form->field($model->bankDetails, 'bik')->textInput(['readonly' => '']) ?>
                                            <?= $form->field($model->bankDetails, 'bankInfo')->textInput(['readonly' => '']) ?>
                                </div>                         
                            </div>
                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('app', 'Cancel'), ['company'], ['class' => 'btn btn-secondary']) ?>
                            </div>
        <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>