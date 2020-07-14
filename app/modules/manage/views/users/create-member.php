<?php

use app\models\Forms\Manage\Users\MemberForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this  */
/** @var MemberForm $model  */
/** @var bool $update */

$this->title = $update ? 'Изменить пользователя' : 'Создать пользователя';
$action = $update ? Url::to(['/manage/users/update', 'id' => $model->userId ]) : '/manage/users/create-member';
?>

<div class="create-form">
    

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin([ 
        'action' => Url::to($action)]); ?>

    <?= $form->field($model, 'login')->textInput() ?>
    <?= $form->field($model, 'fio')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <?php if ($update): ?>                        
        <?= $form->field($model, 'userType')->dropDownList($model->typeList()) ?>             
    <?php endif; ?>    
                            
    <?= $form->field($model->member, 'position')->textInput() ?>                              
    <?= $form->field($model, 'genre')->dropDownList([
        0 => 'Не задано',
        1 => 'Мужской',
        2 => 'Женский'
    ]) ?>                                                                              
    <?php 
        echo $form->field($model, 'birthday')->widget(DatePicker::class, [
           'options' => ['placeholder' => 'Дата рождения'],
            'value' => $model->birthday,
            'removeButton' => false,
            'pickerIcon' => false,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);    
    ?>
                            
    <?= $form->field($model, 'language')->dropDownList([
        0 => 'Русский',
        1 => 'Английский',
      //  2 => 'Немецкий'
    ]) ?>
                            <br>
    <?= $form->field($model, 'company')->widget(Select2::class,[
        'data' => $model->organizationList()
            ]) ?>                               
    <?= $form->field($model->member, 'activities')->hiddenInput()->label(false) ?>                     
    <?= $form->field($model->member, 'proposalSignaturePost')->textInput() ?>                     
    <?= $form->field($model->member, 'proposalSignatureName')->textInput() ?>                     
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

