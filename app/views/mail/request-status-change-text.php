<?php 

use app\models\ActiveRecord\Requests\Request;

/** @var Request $request */

?>
Уважаемый участник выставки АГРОСАЛОН!
Статус вашей заявки (<?php echo $request->form->name ?>, <?php echo $request->form->title ?>) изменился.
Новый статус заявки: "<?= $request->statusText ?>"


С уважением,
Дирекция выставки АГРОСАЛОН