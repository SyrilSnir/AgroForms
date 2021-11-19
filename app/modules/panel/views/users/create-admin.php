<?php

use app\models\Forms\Manage\Users\AdminForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this  */
/** @var AdminForm $model  */
/** @var bool $update */

$this->title = ($update) ? 'Изменить пользователя: ' . $model->login : 'Создать пользователя';
$action = ($update) ? Url::to(['/manage/users/update', 'id' => $model->userId ]) : '/manage/users/create-admin';
?>

<div class="create-form">
    

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
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
    <?= $form->field($model, 'gender')->dropDownList([
        0 => 'Не задано',
        1 => 'Мужской',
        2 => 'Женский'
    ]) ?>                                                                              
    <?php 
        echo $form->field($model, 'birthday')->widget(DatePicker::class, [
           'options' => ['placeholder' => 'Дата рождения'],
            'value' => $model->birthday,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
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