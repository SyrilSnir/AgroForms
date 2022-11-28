<?php

use app\models\ActiveRecord\Requests\Request;
/** @var Request $request */
?>
<!--  <div style="width: 50%;float: left">
                <p style="font-weight: bold">Организатор:</p>
                <p>Должность:</p>
                <p style="text-decoration: underline">Руководитель выставочного комитета</p>
                <p>ФИО:</p>
                <p style="text-decoration: underline">Елизарова Алла Владимировна</p> 
                <p>Подпись: __________________</p>
            </div> -->
<div class="row">
    <p style="font-family: Verdana;font-size: 7pt;text-align:left"><?php echo t('By signing this application, the Exhibitor confirms his agreement with the Rules of the exhibition and guarantees payment for the ordered services')?>.</p>
    <div style="text-align: left">
        <p style="font-family:Verdana;text-decoration: underline;font-weight: bold"><?php echo t('Exhibitor', 'exhibitions')?>:</p>  
        <div style="position:relative;">                                    
            <div style="padding-left: 1pt;float:left; width: 30%; border: 1px solid black">                    
                <p style="font-family: Verdana;font-weight: bold;font-size: 8pt"><?php echo t('Position', 'user') . ', ' . t('Full name', 'user')?>:</p>
                <p style="font-family: Verdana;font-weight: lighter;font-size: 8pt;font-style: italic"><?php echo $request->getExponentSignerPosition() ?>&nbsp;</p>
                <p style="font-family: Verdana;font-weight: lighter;font-size: 8pt;font-style: italic"><?php echo $request->getExponentSignerFullName() ?>&nbsp;</p>                    
            </div>   
            <div style="padding-left: 1pt;margin-left: 20px;float:left; width: 25%; border: 1px solid black">                    
                <p style="font-family: Verdana;font-size: 8pt"><?php echo t('Signature') ?>:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                 
            <div style="padding-left: 1pt;margin-left: 60px;float:left; width: 40%; border: 1px solid black">                    
                <p style="font-size: 8pt"><?php echo t('Date') ?>:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                     
        </div>
    </div>
</div> 
<div class="row">
    <div style="text-align: left">
        <p style="font-family: Verdana;text-decoration: underline;font-weight: bold;"><?php echo t('Organizer', 'exhibitions')?>:</p>  
        <div style="position:relative;">                                    
            <div style="padding-left: 1pt;float:left; width: 30%; border: 1px solid black">                    
                <p style="font-family: Verdana;font-weight: bold;font-size: 8pt"><?php echo t('Position', 'user') . ', ' . t('Full name', 'user')?>:</p>
                <p style="font-family: Verdana;font-weight: lighter;font-size: 8pt;font-style: italic"><?php echo $request->getOrganizerSignerPosition() ?>&nbsp;</p>
                <p style="font-family: Verdana;font-weight: lighter;font-size: 8pt;font-style: italic"><?php echo $request->getOrganizerSignerFullName() ?>&nbsp;</p>                    
            </div>   
            <div style="padding-left: 1pt;margin-left: 20px;float:left; width: 25%; border: 1px solid black">                    
                <p style="font-family: Verdana;font-size: 8pt"><?php echo t('Signature') ?>:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                 
            <div style="padding-left: 1pt;margin-left: 60px;float:left; width: 40%; border: 1px solid black">                    
                <p style="font-family: Verdana;font-size: 8pt"><?php echo t('Date') ?>:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                     
        </div>
    </div>
</div> 