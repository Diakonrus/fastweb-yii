<?php
Yii::import('application.extensions.yii-chosen-master.*');
/**
 * Кастомизированный контроллер backend модулей
 */
class Controller extends CController
{
	public $layout='//layouts/mainpage';
	public $menu=array();
	public $breadcrumbs=array();
	public $application = 'Yii site';

	public function init(){}

    /**
     * Фильтры backend
     */
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

	public function t($phrase, $params = array()){
		return Yii::t( ucfirst($this->module->name) . 'Module.Phrases', $phrase, $params);
	}

    /**
     * Правила доступа к backend
     */
	public function accessRules()
    {
        $rolesAdm = array('admin'); //по умолчанию
        //Получаем админов
        $model_adm = UserRole::model()->findAll('access_level=10');
        if ($model_adm){
            foreach ($model_adm as $adm_key){
                $rolesAdm[] = $adm_key->name;
            }
        }

        return array(
            // даем доступ только админам
            array(
                'allow',
                'roles'=>$rolesAdm,
            ),
            // всем остальным разрешаем посмотреть только на страницу авторизации и восстановления пароля
            array(
                'allow',
                'actions'=>array('login', 'logout', 'access', 'error', 'recover'),
                'users'=>array('*'),
            ),
            // запрещаем все остальное
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Дополняем меню до нужного вида
     */
    public function stateUrl($name, $add = array(), $remove = array() ){

        foreach($remove as $item){
            unset($add[$item]);
        }

        return $this->createUrl($name, $add);
    }

    public function itemUrl($name, $id){
        return $this->stateUrl($name, array('id' => $id) + $_GET, array('ajax'));
    }

    public function listUrl($name){
        return $this->stateUrl($name, $_GET, array('id'));
    }

    /**
     * Кнопка массового удаления записей
     */
    public function bulkRemoveButton(){
        return array(
            array(
                'id' => 'bulk-remove',
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => Yii::t('Bootstrap', 'GRID.Remove_selected'),
                'click' => 'js:function(checkBoxes){
					var values = [];
					checkBoxes.each(function () {
						values.push($(this).val());
					});

					$.ajax({
					    url: "' . CHtml::normalizeUrl(array('delete', 'ajax' => 'bulk-remove')) . '",
					    type: "POST",
					    data: {"id":values},
					    success: function(){
					        $(".grid-view").yiiGridView("update");
					    },
					    error: function(jqXHR, textStatus, errorThrown) {
					        if(jqXHR.status && jqXHR.status==500){
					            $(".grid-view").yiiGridView("update");  // некоторые записи могут быть удалены даже в случае ошибки, поэтому всегда будем обновляться
                                alert(jqXHR.responseText);
                           }
					    }
					});
				}',
				'htmlOptions' => array(
					'confirm' => Yii::t('Bootstrap', 'GRID.Remove_selected?'),
				)
            )
        );
    }


    public function sendEmail($email = null, $title = null, $body = null){
        if (!empty($email) && !empty($title)){
            preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email, $match);
            if (!empty($match)){
                Yii::app()->mailer->send(array('email'=>$email, 'subject'=>$title, 'body'=>$body));
                return true;
            }
            else { return false; }
        }
    }

    /**Загрузка изображения**/
    /**
     *  $patch - путь к папке с файлами
     *  $imgOld - имя файла который будет использоваться
     *  $imgNew - новое имя файла (с уже внесенными  изменениями)
     *  $x, ширина в пикс картинки $imgNew
     *  $quality - качество $imgNew, по умолчанию 100
     **/
    public  function chgImg($patch, $imgOld, $imgNew, $x, $quality=100){

        $size = getimagesize($patch.$imgOld);

        if(preg_match("/.gif/i",$imgOld)){
            $source = imagecreatefromgif($patch.$imgOld);
        }
        elseif(preg_match("/.jpeg/i",$imgOld) or preg_match("/.jpg/i",$imgOld)){
            $source = imagecreatefromjpeg($patch.$imgOld);
        }
        elseif(preg_match("/.png/i",$imgOld)) {
            $source = imagecreatefrompng($patch . $imgOld);
        }

        //Высчитываем высоту исходя из $x картинки
        $prop = $size[1] / $size[0];// пропорция
        $y = $x * $prop;

        $target = imagecreatetruecolor($x, $y);
        imagecopyresampled(
            $target,  // Идентификатор нового изображения
            $source,  // Идентификатор исходного изображения
            0,0,      // Координаты (x,y) верхнего левого угла
            // в новом изображении
            0,0,      // Координаты (x,y) верхнего левого угла копируемого
            // блока существующего изображения
            $x,     // Новая ширина копируемого блока
            $y,     // Новая высота копируемого блока
            $size[0], // Ширина исходного копируемого блока
            $size[1]  // Высота исходного копируемого блока
        );

        if(preg_match("/.gif/i",$imgOld)){
            imagegif($target, $patch.$imgNew, $quality);
        }
        elseif(preg_match("/.jpeg/i",$imgOld) or preg_match("/.jpg/i",$imgOld)){
            imagejpeg($target, $patch.$imgNew, $quality);
        }
        elseif(preg_match("/.png/i",$imgOld)) {
            imagepng($target, $patch.$imgNew, 9);
        }
        imagedestroy($target);
        imagedestroy($source);
        return true;
    }

    public function addWatermark($img, $img_wm, $watermark_pos = 1){
        $wm=imagecreatefrompng($img_wm);
        $wmW=imagesx($wm);
        $wmH=imagesy($wm);
        // imagecreatetruecolor - создаёт новое изображение true color
        $image=imagecreatetruecolor($wmW, $wmH);

        // выясняем расширение изображения на которое будем накладывать водяной знак
        if(preg_match("/.gif/i",$img)):
            $image=imagecreatefromgif($img);
        elseif(preg_match("/.jpeg/i",$img) or preg_match("/.jpg/i",$img)):
            $image=imagecreatefromjpeg($img);
        elseif(preg_match("/.png/i",$img)):
            $image=imagecreatefrompng($img);
        else:
            die("Ошибка! Неизвестное расширение изображения");
        endif;
        // узнаем размер изображения
        $size=getimagesize($img);

        //проверяем, что водная марка не больше изображения на которое накладываем
        if ( $size[1]>$wmH || $size[0]>$wmW ){

            // указываем координаты, где будет располагаться водяной знак
            /*
            * $size[0] - ширина изображения
            * $size[1] - высота изображения
            */
            $cx=null;
            $cy=null;

            //Позиции водной марки
            switch ($watermark_pos) {
                case 1: //Замостить
                    for ($y_i=0; $y_i<$size[1]; $y_i = $y_i+$wmH){
                        for ($x_i=0; $x_i<$size[0]; $x_i = $x_i+$wmW){
                            imagecopyresampled ($image, $wm, $x_i, $y_i, 0, 0, $wmW, $wmH, $wmW, $wmH);
                        }
                    }
                    break;
                case 2: //Изображение в нижнем левом углу
                    $cx=10;
                    $cy=$size[1]-$wmH;
                    break;
                case 3: //Изображение внизу по центру
                    $cx=($size[0]/2)-($wmW/2);
                    $cy=$size[1]-$wmH;
                    break;
                case 4: //Изображение в центре
                    $cx=($size[0]/2)-($wmW/2);
                    $cy=($size[1]/2)-($wmH/2);
                    break;
                case 5: //Изображение в левом верхнем углу
                    $cx=10;
                    $cy=10;
                    break;
                case 6:  //Изображение в нижнем правом углу
                    $cx=$size[0]-$wmW;
                    $cy=$size[1]-$wmH;
                    break;
            }

            /* imagecopyresampled - копирует и изменяет размеры части изображения
            * с пересэмплированием
            */
            if (!empty($cx) && !empty($cy)){
                imagecopyresampled ($image, $wm, $cx, $cy, 0, 0, $wmW, $wmH, $wmW, $wmH);
            };

            /* imagejpeg - создаёт JPEG-файл filename из изображения image
            * третий параметр - качество нового изображение
            * параметр является необязательным и имеет диапазон значений
            * от 0 (наихудшее качество, наименьший файл)
            * до 100 (наилучшее качество, наибольший файл)
            * По умолчанию используется значение по умолчанию IJG quality (около 75)
            */
            //imagejpeg($image,$img,90);
            if(preg_match("/.gif/i",$img)){
                imagegif($image,$img,90);
            }
            elseif(preg_match("/.jpeg/i",$img) or preg_match("/.jpg/i",$img)){
                imagejpeg($image,$img,90);
            }
            elseif(preg_match("/.png/i",$img)) {
                imagepng($image,$img,9);
            }

            // imagedestroy - освобождает память
            imagedestroy($image);

            imagedestroy($wm);

            // на всякий случай
            unset($image,$img);

        }

    }


    /**
     * Транслит текста в url
     */
    public function translit($str) {

        $str = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$str);
        $str = str_replace (" ","-",$str);

        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');


        return str_replace($rus, $lat, $str);
    }


    //Удаляет файл
    public function __deleteFile($url){
        $url = YiiBase::getPathOfAlias('webroot').'/../'.$url;
        if (file_exists($url)) {
            unlink($url);
        }
        return true;
    }



}
