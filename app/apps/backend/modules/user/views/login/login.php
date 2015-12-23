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
        body,html{
            margin: 0;
            padding: 0;
            display: table;
            width: 100%;
            height: 100%;
        }
        .container{
            display:table-cell;
            vertical-align: middle;
        }
        
        a.btn_in{
            color: #FC2626;
            font-weight: bold;
            font-size: 24px;
            text-shadow: 2px 2px 10px #fff, -2px -2px 10px #FFF, -2px 0 10px #fff, 0 -2px 10px #fff;
            cursor: pointer;
        }
        a.btn_in:hover{
            text-decoration: none;
        }

	';
	Yii::app()->clientScript->registerCss(get_class($model).'.form', $css);
?>



<?php
$cs = Yii::app()->clientScript;
$script = "

        $(document).on('click', '.restorePassBtn', function(){
            regexp = /[a-z0-9!$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum|ru)\b/

            str = $('#RestorePass').val();
            if (!str.match(regexp)) {
                alert ('Не коректный E-mail!');
                return false;
            }
            else {

                $.ajax({
                    type: 'POST',
                    url: '/admin/user/login/recover',
                    dataType: 'json',
                    data: { email:str },
                    success: function(data) {
                        if (data=='ok'){

                        }
                        else {
                            alert(data);
                        }
                        $('#restorepassModal').modal('hide');
                    }
                });
            }
        });

";
$cs->registerScript('my_script', $script, CClientScript::POS_READY);
?>

<div class="login-bg-form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'login-form',
        'type'=>'horizontal',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),

        'htmlOptions'=>array('class'=>'form-vertical'),
    )); ?>
    <div class="title">Идентифицируйте себя</div>

    <div class="input-block">
        <div class="input-prepend">
            <span class="add-on"><span class="icon-user"></span></span>
            <?php echo $form->textField($model,'username', array('class'=>'input-style')); ?>
        </div>
    <br>
        <div class="input-prepend">
            <span class="add-on"><span class="icon-lock"></span></span>
            <?php echo $form->passwordField($model,'password',array('class'=>'input-style')); ?>
        </div>
    <br>

    <a href="#" style="margin-left:50px;" onclick="$('#restorepassModal').modal('show');" >Восстановить пароль</a>

    </div>

    <div style="position:absolute; margin-left:260px; margin-top:100px">
        <a onclick="document.getElementById('login-form').submit();" class="btn_in">Войти</a>
    </div>


    <?php $this->endWidget(); ?>
</div>


<div id="restorepassModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="restorepassLabel">Восстановление пароля</h3>
    </div>
    <div class="modal-body">
        <p>Если вы забыли пароль, то введите свой e-mail, под которым Вы зарегистрированы на сайте.</p>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input id="RestorePass" class="input-style" type="text">
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
        <button class="btn btn-primary restorePassBtn">Восстановить</button>
    </div>
</div>