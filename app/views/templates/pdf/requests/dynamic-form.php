<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user = $request->user;
$userProfile = $user->profile;
?>

<div class="pdf-container">    
    <h1 class="text-center">AGROSALON 2020</h1>
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