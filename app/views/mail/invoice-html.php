<?php 

use app\models\ActiveRecord\Requests\Request;

/** @var Request $request */

?>

<h2>Уважаемый участник выставки АГРОСАЛОН!</h2>
<p>Вам выставлен счет по заявке (<?php echo $request->form->name ?>, <?php echo $request->form->title ?>).</p>
<p>Счет вы можете найти и скачать в личном кабинете в разделе Мои документы (на сайте <a href="http://forms.agrosalon.ru">forms.agrosalon.ru</a> )</p>
<br><br>
<p>С уважением,</p>
<p>Дирекция выставки АГРОСАЛОН</p>
