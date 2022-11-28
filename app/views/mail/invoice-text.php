<?php 

use app\models\ActiveRecord\Requests\Request;

/** @var Request $request */

?>
Уважаемый участник выставки АГРОСАЛОН2022!
Вам выставлен счет по заявке (<?php echo $request->form->name ?>, <?php echo $request->form->title ?>).
Счет вы можете найти и скачать в личном кабинете в разделе Мои документы (на сайте http://forms.agrosalon.ru )/

С уважением,
Дирекция выставки АГРОСАЛОН


