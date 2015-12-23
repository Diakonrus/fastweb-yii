<?php
class Ymap extends CWidget
{
    /*
     *  $startCoord - координаты куда центрируется карта при инициализации
     *  $coordsData - массив с координатами точек и описанием (array[$i]['coords'] - координаты, array[$i]['description'] - описание точки)
     *  $mapX - ширина выводимого окна
     *  $mapY - высота выводимого окна
     *  $class - строка с классом для карты
     *
     */
    public $startCoord = null;
    public $coordsData = array();
    public $mapX = 600;
    public $mapY = 400;
    public $class = null;

    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
        $this->startCoord = (!empty($this->startCoord)?$this->startCoord:"37.609218,55.753559");
    }

    public function run()
    {
        // этот метод будет вызван внутри CBaseController::endWidget()
        $this->render('ymap',  array(
            'coordsData' => $this->coordsData,
            'startCoords' => $this->startCoord,
            'mapX' => $this->mapX,
            'mapY' => $this->mapY,
            'class' => $this->class,
        ));
    }
}