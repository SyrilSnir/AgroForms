<div class="full-view">
    <p>
        <?php //Html::a(t('Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(t('Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                    <div class="card-body">
                        <p>Приглашение было отправлено на адрес электонной почты <?php echo $eMail; ?></p>
                    </div>
            </div>
        </div>
    </div>
</div>

