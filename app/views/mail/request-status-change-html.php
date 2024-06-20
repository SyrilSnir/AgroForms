<?php 

use app\models\ActiveRecord\Requests\Request;

/** @var Request $request */

?>

<h2>Уважаемый участник выставки АГРОСАЛОН!</h2>
<p>Статус вашей заявки (<?php echo $request->form->name ?>, <?php echo $request->form->title ?>) изменился.</p>
<p>Новый статус заявки: "<?= $request->statusText ?>"</p>
<br><br>
<p>С уважением,</p>
<p>Дирекция выставки АГРОСАЛОН</p>
