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
    <p style="font-family: Verdana;font-size: 7pt;text-align:left">Подписывая настоящую заявку Экспонент подтверждает согласие с Правилами выставки и гарантирует оплату заказанных услуг.</p>
    <div style="text-align: left">
        <p style="font-family: Verdana;text-decoration: underline">Экспонент:</p>  
        <div style="position:relative;">                                    
            <div style="float:left; width: 30%; border: 1px solid gray">                    
                <p style="font-family: Verdana;font-size: 8pt">Должность, ФИО:</p>
                <p style="font-family: Verdana;font-size: 8pt;font-style: italic"><?php echo $request->getExponentSignerPosition() ?>&nbsp;</p>
                <p style="font-family: Verdana;font-size: 8pt;font-style: italic"><?php echo $request->getExponentSignerFullName() ?>&nbsp;</p>                    
            </div>   
            <div style="margin-left: 20px;float:left; width: 25%; border: 1px solid gray">                    
                <p style="font-family: Verdana;font-size: 8pt">Подпись:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                 
            <div style="margin-left: 60px;float:left; width: 40%; border: 1px solid gray">                    
                <p style="font-size: 8pt">Дата:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                     
        </div>
    </div>
</div> 
<div class="row">
    <div style="text-align: left">
        <p style="font-family: Verdana;text-decoration: underline">Организатор:</p>  
        <div style="position:relative;">                                    
            <div style="float:left; width: 30%; border: 1px solid gray">                    
                <p style="font-family: Verdana;font-size: 8pt">Должность, ФИО:</p>
                <p style="font-family: Verdana;font-size: 8pt;font-style: italic"><?php echo $request->getOrganizerSignerPosition() ?>&nbsp;</p>
                <p style="font-family: Verdana;font-size: 8pt;font-style: italic"><?php echo $request->getOrganizerSignerFullName() ?>&nbsp;</p>                    
            </div>   
            <div style="margin-left: 20px;float:left; width: 25%; border: 1px solid gray">                    
                <p style="font-family: Verdana;font-size: 8pt">Подпись:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                 
            <div style="margin-left: 60px;float:left; width: 40%; border: 1px solid gray">                    
                <p style="font-family: Verdana;font-size: 8pt">Дата:</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>                    
            </div>                     
        </div>
    </div>
</div> 