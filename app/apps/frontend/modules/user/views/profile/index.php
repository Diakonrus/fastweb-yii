<div class="block_content">
    <div class="kabinet">
        <h1>Личный кабинет</h1>
        <div class="link">
            <a href="/cabinet/settings">
                <span>Настройки</span>
            </a>
            <a href="/cabinet">
                <span>Заказы</span>
            </a>
            <a href="/cabinet/profile">
                <span>Профиль</span>
            </a>
            <a href="/logout">
                <span>Выход</span>
            </a>
        </div>

        <div style="padding-top: 20px; padding-bottom: 20px;">
            <b><?=$modelUser->last_name.' '.$modelUser->first_name.' '.$modelUser->middle_name;?></b><BR>
            <b><?=$modelUser->email;?></b><BR>
        </div>

        <?php echo $this->renderPartial($renderPartial, array('model'=>$model), true); ?>

    </div>
</div>
