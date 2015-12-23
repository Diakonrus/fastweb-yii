<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('Phrases', 'LOGIN');

$this->layout = '//layouts/access';
?>

<?php
	$css = '
        .login-bg-form {
            margin: 0 auto;
            width: 390px;
            height: 380px;
            background: url(/images/admin/auth-form-admin.png)no-repeat;
        }
        .title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #3399cc;
            font-family: Verdana;
            font-size: 9pt;
            margin-left:100px;
            padding-top:60px;
        }
        .input-style {
            color: #3399cc;
            font-family: Verdana;
            font-size: 9pt;
            font-weight: bold;
            height: 20px;
            width: 180px;
        }
        .input-block {
            padding-top:5px;
            margin-left: 70px;
        }
        .input-prepend {
            margin-top:5px;
        }

	';
	Yii::app()->clientScript->registerCss(get_class($model).'.form', $css);
?>


<?php
$cs = Yii::app()->clientScript;
$script = "

    $(document).on('click', '#changePassBtn', function(){
        if ( $('#RecoveryForm_password').val().length == 0 || $('#RecoveryForm_password_repeat').val().length == 0 || $('#RecoveryForm_password').val().length != $('#RecoveryForm_password_repeat').val().length  ) {
            alert ('Пароли не совпадают или пустые!');
            return false;
        }
        else {


            document.getElementById('restorepass-form').submit()
        }
    });

";
$cs->registerScript('my_script', $script, CClientScript::POS_READY);
?>


<div class="login-bg-form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'restorepass-form',
        'type'=>'horizontal',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),

        'htmlOptions'=>array('class'=>'form-vertical'),
    )); ?>
    <div class="title">Введите новый пароль</div>

    <div class="input-block">
        <div class="input-prepend">
            <span class="add-on"><span class="icon-lock"></span></span>
            <?php echo $form->passwordField($model,'password', array('class'=>'input-style')); ?>
        </div>
    <br>
        <div class="input-prepend">
            <span class="add-on"><span class="icon-lock"></span></span>
            <?php echo $form->passwordField($model,'password_repeat',array('class'=>'input-style')); ?>
        </div>
    <br>

    </div>

    <div style="position:absolute; margin-left:260px; margin-top:100px">
        <a  id = 'changePassBtn' href="#">Изменить</a>
    </div>


    <?php $this->endWidget(); ?>
</div>

