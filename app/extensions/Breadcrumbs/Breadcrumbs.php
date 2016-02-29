<?php
/**
 * Created by PhpStorm.
 * User: Matios
 * Date: 26.02.2016
 * Time: 16:39
 */
Yii::import('zii.widgets.CBreadcrumbs');

class Breadcrumbs extends CBreadcrumbs {

    public $params;
    protected $parentLinks = array();

    public function run() {

        //Определение правила по URL
        $currentRule = Yii::app()->urlManager->parseUrl(Yii::app()->request);
        $currentMask = null; //Маска URL (ключ в Rules)
        foreach(Yii::app()->urlManager->rules as $ruleParam => $ruleRow) {
            if ($currentRule == trim($ruleRow, '/')) {
                $currentMask = $ruleParam;
                break;
            }
        }

        if (!empty($currentMask)) {
            //Если маска найдена, то формируем крошку для корня через модель Pages
            $currentMaskArray = explode('/<', $currentMask);
            $currentMask = trim($currentMaskArray[0], '/');
            /** @var $page Pages */
            $page = Pages::model()->find('url = :url', array(":url" => $currentMask));
            if (!empty($page)) {
                if (count($currentMaskArray) > 1) {
                    $this->addLink(array($page->title => Yii::app()->urlManager->createUrl('/' . $currentMask)));
                } else {
                    $this->addLink($page->title);
                }
            }
        }


        if (!empty($this->params['model'])) {
            //если у модели есть родители - находим их и добавляем в очередь
            if (!empty($this->params['model']->parent)) {
                $this->setParentLink($this->params['model']->parent);
            }

            //Инвертируем очередь и добавляем крошки в список
            if (!empty($this->parentLinks)) {
                $this->parentLinks = array_reverse($this->parentLinks);
                foreach($this->parentLinks as $parentLink) {
                    $this->addLink($parentLink);
                }
            }

            //Добавляем крошку переданной модели
            if (!empty($this->params['model']->name)) {
                if (!isset($this->params['model']->parent_id) || $this->params['model']->parent_id > 0) {
                    $this->addLink($this->params['model']->name);
                }
            }
        }

        parent::run();
    }


    /**
     * Добавляем крошку в список
     *
     * @param $array
     */
    protected function addLink($array) {
        if (!is_array($array)) {
            $array = array($array);
        }

        if (empty($this->links)) {
            $this->links = $array;
        } else {
            $this->links = CMap::mergeArray($this->links, $array);
        }
    }

    /**
     * Добавление крошки родителя в очередь
     *
     * @param $parent
     */
    protected function setParentLink($parent) {
        if (!empty($parent)) {
            //Формирование роута
            $route = '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;

            if (!empty(Yii::app()->controller->module->id)) {
                $route = '/' . Yii::app()->controller->module->id . $route;
            }

            //Если нужные данные есть, добавляем крошку в очередь и ищем родителя
            if (!empty($parent->name) && !empty($parent->url) && !empty($parent->parent_id) && $parent->parent_id != 0) {
                $this->parentLinks[] = array($parent->name => Yii::app()->urlManager->createUrl($route, array('param'=>$parent->url)));
                $this->setParentLink($parent->parent);
            }
        }
    }
}