<?php

use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use app\models\ActiveRecord\Users\Profile\MemberProfile;

/** @var Request $request */
/** @var RequestStand $form */
/** @var MemberProfile $userProfile */
$form = $request->requestForm;
$formType = $request->formType;
$user = $request->user;
$userProfile = $user->profile;
        
?>
<div class="pdf-container">
    

<h1 class="text-center">AGROSALON 2020</h1>
<div style="padding: 5px">
<h2><strong>Тип стандарной застройки:</strong></h2>
<p><?php echo $form->stand->name ?></p>
<p><?php echo $form->stand->description ?></p>
<ul>
    <li>Длинна: <span><i><?php echo $form->length ?> м.</i></span></li>
    <li>Ширина: <span><i><?php echo $form->width ?> м.</i></span></li>
    <li>Площадь застройки: <span><i><?php echo $form->square ?> м<sup>2</sup>.</i></span></li>
</ul>
<p>Фризовая надпись: <span><strong><?php echo $form->frize_name ?></strong></span></p>
<p>Надбавка за дополнительные символы: <?php echo $form->frize_price ?> USD.</p>

<br>
<br>
<h4>Общая стоимость услуг по настоящей заявке: <strong><?php echo $form->amount ?> USD</strong></h4>
<br>
<br>
    <div class="row">
        <div style="width: 50%;float: left">
            <p style="font-weight: bold">Экспонент:</p>
            <p>Должность:</p>
            <p style="text-decoration: underline"><?php echo $userProfile->proposal_signature_post ?></p>
            <p>ФИО:</p>
            <p style="text-decoration: underline"><?php echo $userProfile->proposal_signature_name ?></p>  
            <p>Подпись: __________________</p>
            
        </div>
        <div style="width: 50%;float: left">
            <p style="font-weight: bold">Организатор:</p>
            <p>Должность:</p>
            <p style="text-decoration: underline">Руководитель выставочного комитета</p>
            <p>ФИО:</p>
            <p style="text-decoration: underline">Елизарова Алла Владимировна</p> 
            <p>Подпись: __________________</p>
        </div>
    </div>
    

</div>

