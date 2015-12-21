<?php
error_reporting(E_ERROR | E_PARSE);
set_time_limit(0);

require_once (__DIR__ .'/XmlImport/SimpleXMLReader.php');

class XmlImport extends SimpleXMLReader {

    public $start_teg;
    public $getRubric;
    private $k = 1;
    private $pid0 = 0;
    private $series = array();
    private $pid3 = 0;

    private $cats;

    public $patch;
    public $watermark;


    public function __construct($type)  {
        set_time_limit(0);
        $this->registerCallback("КоммерческаяИнформация", array($this, "callbackItems"));
    }


	public function utf8_for_xml($string)	{
		return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
	}

    /* Получаем xml классификатора */
    protected function callbackItems($reader)  {
        $xml = $reader->expandSimpleXml();

        //Каталоги
        $this->chk_rubric($xml->Классификатор);

        //Товары
        $this->chk_product($xml->Каталог);

        return true;
    }



	public function clear_str($str){
		$str = str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $str);
		$str = trim($str);
		return $str;
	}

	private function clear($text){
		$text = trim(html_entity_decode($text), " \t\n\r\0\x0B\xC2\xA0");
		$text = trim($text);
		return $text;
	}




	/* Преобразует строку в транслит
	 * @param string $str : Строка для преобразования
	 * @return string : преобразованная строка
	 */
	public function translitIt($str){
		$str  = trim($str);
		$tr   = array(
				"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
				"Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
				"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
				"О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
				"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
				"Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
				"Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
				"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
				"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
				"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
				"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
				"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
				"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
		);
		return strtr($str,$tr);
	}

    /* Преобразует строку в url убирая все лишнее
     * @param string $str : Строка для преобразования
     * @return string : преобразованная строка
     */
    public function ConvertToUrl($str,$file=false){
        $str = trim($str);
        $str = mb_strtolower($str, 'UTF-8');
        $str = $this->translitIt($str);
        $str = preg_replace('/[^a-z0-9\-_]/', ' ', $str);
        $str = preg_replace('/ +/', '-', $str);
        $str = trim($str,"-");
        return $str;
    }


    /**
     *  $patch - путь к папке с файлами
     *  $imgOld - имя файла который будет использоваться
     *  $imgNew - новое имя файла (с уже внесенными  изменениями)
     *  $x, ширина в пикс картинки $imgNew
     *  $quality - качество $imgNew, по умолчанию 100
     **/
    private function chgImg($patch, $imgOld, $imgNew, $x, $quality=100){

        $size = getimagesize($patch.$imgOld);
        if(preg_match("/.gif/i",$imgOld)){$source = imagecreatefromgif($patch.$imgOld);}
        elseif(preg_match("/.jpeg/i",$imgOld) or preg_match("/.jpg/i",$imgOld)){$source = imagecreatefromjpeg($patch.$imgOld);}
        elseif(preg_match("/.png/i",$imgOld)) {$source = imagecreatefrompng($patch . $imgOld);}
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
        if(preg_match("/.gif/i",$imgOld)){imagegif($target, $patch.$imgNew, $quality);}
        elseif(preg_match("/.jpeg/i",$imgOld) or preg_match("/.jpg/i",$imgOld)){imagejpeg($target, $patch.$imgNew, $quality);}
        elseif(preg_match("/.png/i",$imgOld)) {imagepng($target, $patch.$imgNew, 9); }
        imagedestroy($target);
        imagedestroy($source);
        return true;
    }

    private function addWatermark($img, $img_wm, $watermark_pos = 1){
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

    public function chk_rubric($xml){

        //Очищаем каталог перед импортом
        WarehouseRubrics::model()->deleteAll();

        //Проверяем, есть ли корневой (lvl1) узел - нет, то создаем

        if (!WarehouseRubrics::model()->find('level=1')){
            $root = WarehouseRubrics::getRoot(new WarehouseRubrics);
        }


        foreach ($xml->Группы->Группа as $data0){

            $model = new WarehouseRubrics;

            //Верхний уровень - ищем корневую категорию

            $parent_id = WarehouseRubrics::model()->find('level=1');
            $parent_id = $parent_id->id;
            $root = WarehouseRubrics::model()->findByPk($parent_id);

            $model->parent_id = $parent_id;
            $model->name = $data0->Наименование;
            $model->url = $this->ConvertToUrl($model->name);
            $model->fkey = $data0->Ид;

            $model->appendTo($root);


            if (!isset($data0->Группы->Группа)){continue;}
            $parent_id0 = $model->id;

            //Строим вложеные каталоги
            foreach ($data0->Группы->Группа as $data1){
                $model = new WarehouseRubrics;
                $root = WarehouseRubrics::model()->findByPk($parent_id0);
                $model->parent_id = $parent_id0;
                $model->name = $data1->Наименование;
                $model->url = $this->ConvertToUrl($model->name);
                $model->fkey = $data1->Ид;
                $model->appendTo($root);

                //Строим 3тью вложеность
                if (!isset($data1->Группы->Группа)){continue;}
                $parent_id1 = $model->id;
                foreach ($data1->Группы->Группа as $data2){
                    $model = new WarehouseRubrics;
                    $root = WarehouseRubrics::model()->findByPk($parent_id1);
                    $model->parent_id = $parent_id1;
                    $model->name = $data2->Наименование;
                    $model->url = $this->ConvertToUrl($model->name);
                    $model->fkey = $data2->Ид;
                    $model->appendTo($root);
                }
            }

        }


    }

    public function chk_product($xml){
        //Очищаем каталог перед импортом
        WarehouseElements::model()->deleteAll();

        foreach ($xml->Товары->Товар as $data){

            //Получаем parent_id
            $parent_id = WarehouseRubrics::model()->find('`fkey`="'.($data->Группы->Ид).'"');
            if (!$parent_id){
                echo 'Нет рубрики с `fkey`="'.($data->Группы->Ид).'"<BR>';
                continue;
            }
            $parent_id = $parent_id->id;

            $model = new WarehouseElements;
            $model->parent_id = $parent_id;
            $model->name = $data->Наименование;
            $model->page_name = $data->Наименование;
            $model->fkey = $data->Ид;
            $model->save();

            //Копируем изображение
            if (isset($data->Картинка) && !empty($data->Картинка)){
                $url_origin = $data->Картинка;
                $url_origin = YiiBase::getPathOfAlias('webroot').'/../import_sklad/'.$url_origin;
                copy($url_origin, ($this->patch.$model->id.'.jpeg'));
                //Создаем копии
                $this->chgImg($this->patch, $model->id.'.jpeg', 'medium-'.$model->id.'.jpeg', 206, 50);
                $this->chgImg($this->patch, $model->id.'.jpeg', 'admin-'.$model->id.'.jpeg', 150, 100);
                $this->chgImg($this->patch, $model->id.'.jpeg', 'small-'.$model->id.'.jpeg', 730, 50);
                $this->chgImg($this->patch, $model->id.'.jpeg', 'medium2-'.$model->id.'.jpeg', 900, 100);
                //Накладываем водный знак
                $img = $this->patch.'medium2-'.$model->id.'.jpeg';
                $this->addWatermark($img, $this->watermark, 1);
                $img = $this->patch.'small-'.$model->id.'.jpeg';
                $this->addWatermark($img, $this->watermark, 1);
                $img = $this->patch.'medium-'.$model->id.'.jpeg';
                $this->addWatermark($img, $this->watermark, 1);


                $updateModel = WarehouseElements::model()->findByPk($model->id);
                $updateModel->image = 'jpeg';
                $updateModel->save();
            }


        }
    }


}

?>