<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'registration-form'
)); ?>

<div class="block_content">
    <div class="text">
        <h1>Регистрация</h1>
        <p>
            Уже регистрировались?
            <a href="/login">Войти на сайт</a>
            |
            <a href="/login/restore">Восстановить пароль</a>
        </p>


        <div id="position1" style="margin-bottom:20px; width: 170px; height:35px; border-radius:10px; border:2px solid black; background: #e9edf1;">
            <a href="#" onclick="$(this).parent().css('background', '#e9edf1'); $('#position2').css('background', '#FFF'); $('#UrLicoData').show(); return false;" ><span style="position:absolute; margin-top:7px; margin-left:30px;">Юридическое лицо</span></a>
        </div>
        <div id="position2" style="position:absolute; margin-top:-55px; margin-left:350px; width: 170px; height:35px; border-radius:10px; border:2px solid black; background: #FFF;">
            <a href="#" onclick="$(this).parent().css('background', '#e9edf1'); $('#position1').css('background', '#FFF'); $('#UrLicoData').hide(); return false;" ><span style="position:absolute; margin-top:7px; margin-left:30px;">Физическое лицо</span></a>
        </div>

        <HR>


        <div class="row control-group <?php echo $model->hasErrors('email') ? 'error' : '' ?>" style="padding-bottom: 40px;">
            <span class="row_name">Введите E-Mail адрес (на него будет выслан пароль) <span class="ast">*</span>:</span>
            <div class="input">
                <?php echo $form->textField($model, 'email', array('class'=>'inp', 'placeholder' => 'Введите email')); ?>
                <?php if($model->hasErrors('email')): ?><span class="help-inline" style="color:red;"><?php echo $model->getError('email') ?></span><?php endif ?>
            </div>
        </div>

        <div class="row control-group <?php echo $model->hasErrors('first_name') ? 'error' : '' ?>" style="padding-bottom: 40px;">
            <span class="row_name">Имя:</span>
            <div class="input">
                <?php echo $form->textField($model, 'first_name', array('class'=>'inp', 'placeholder' => 'Введите имя')); ?>
                <?php if($model->hasErrors('first_name')): ?><span class="help-inline" style="color:red;"><?php echo $model->getError('first_name') ?></span><?php endif ?>
            </div>
        </div>

        <div id="UrLicoData">
            <p class="bline1">Данные юридического лица</p>

            <div class="row control-group <?php echo $model->hasErrors('organization') ? 'error' : '' ?>" style="padding-bottom: 30px;">
                <span class="row_name">Организация:</span>
                <div class="input">
                    <?php echo $form->textField($model, 'organization', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите организацию')); ?>
                    <?php if($model->hasErrors('organization')): ?><span class="help-inline"><?php echo $model->getError('organization') ?></span><?php endif ?>
                </div>
            </div>

            <div class="row control-group <?php echo $model->hasErrors('ur_addres') ? 'error' : '' ?>" style="padding-bottom: 30px;">
                <span class="row_name">Юридический адрес:</span>
                <div class="input">
                    <?php echo $form->textField($model, 'ur_addres', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите юридический адрес')); ?>
                    <?php if($model->hasErrors('ur_addres')): ?><span class="help-inline"><?php echo $model->getError('ur_addres') ?></span><?php endif ?>
                </div>
            </div>

            <div class="row control-group <?php echo $model->hasErrors('fiz_addres') ? 'error' : '' ?>" style="padding-bottom: 30px;">
                <span class="row_name">Физический адрес:</span>
                <div class="input">
                    <?php echo $form->textField($model, 'fiz_addres', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите физический адрес')); ?>
                    <?php if($model->hasErrors('fiz_addres')): ?><span class="help-inline"><?php echo $model->getError('fiz_addres') ?></span><?php endif ?>
                </div>
            </div>

            <div class="row control-group <?php echo $model->hasErrors('inn') ? 'error' : '' ?>" style="padding-bottom: 30px;">
                <span class="row_name">ИНН:</span>
                <div class="input">
                    <?php echo $form->textField($model, 'inn', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите ИНН')); ?>
                    <?php if($model->hasErrors('inn')): ?><span class="help-inline"><?php echo $model->getError('inn') ?></span><?php endif ?>
                </div>
            </div>

            <div class="row control-group <?php echo $model->hasErrors('kpp') ? 'error' : '' ?>" style="padding-bottom: 30px;">
                <span class="row_name">КПП:</span>
                <div class="input">
                    <?php echo $form->textField($model, 'kpp', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите КПП')); ?>
                    <?php if($model->hasErrors('kpp')): ?><span class="help-inline"><?php echo $model->getError('kpp') ?></span><?php endif ?>
                </div>
            </div>

            <div class="row control-group <?php echo $model->hasErrors('okpo') ? 'error' : '' ?>" style="padding-bottom: 30px;">
                <span class="row_name">ОКПО:</span>
                <div class="input">
                    <?php echo $form->textField($model, 'okpo', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите ОКПО')); ?>
                    <?php if($model->hasErrors('okpo')): ?><span class="help-inline"><?php echo $model->getError('okpo') ?></span><?php endif ?>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top: 50px;">
            <?php echo CHtml::submitButton('Регистрация', array( 'class' => 'send', 'style' => 'padding:10px; cursor:pointer;' )); ?>
        </div>

    </div>


</div>

<?php $this->endWidget(); ?>



