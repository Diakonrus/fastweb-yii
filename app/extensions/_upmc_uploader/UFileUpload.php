<?php

class UFileUpload extends CInputWidget
{
    public $url;
    public $viewOptions = array(
        // Подгон высоты тумбов в соответствии с соотнощением сторон
        'aspectRatio' => 1.0,
        //'debug' => true,
        // способ выравнивания изображения внутри тумба (inner - поместить полностью в рамку, outer - заполнить рамку)
        'stretch' => 'outer'
    );

    public $itemButtons = array(
        'template' => '{view}{delete}',

        'view' => array(
            'icon' => 'eye-open',
            'click' => 'js:function (data) {}'
        ),
        'delete' => array(
            'icon' => 'remove-2',
            'click' => 'js:function (data) {}'
        )
    );

    public function init() {
        $publishFolder = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', false, -1, true);

        Yii::app()->clientScript->packages['_fileuploader'] = array(
            'baseUrl' => $publishFolder,
            'js' => array(
                'js/vendor/jquery.ui.widget.js',
                'js/jquery.iframe-transport.js',
                'js/jquery.fileupload.js',
                'js/jquery.fileupload-process.js',
                //'js/jquery.fileupload-image.js',
                //'js/jquery.fileupload-audio.js',
                //'js/jquery.fileupload-video.js',
                //'js/jquery.fileupload-validate.js',
                //'js/jquery.fileupload-ui.js',

            ),
            'css' => array(
                'css/jquery.fileupload.css',
                'css/jquery.fileupload-ui'
            ),
            'depends' => array('jquery', 'glyphicons'),
        );
        Yii::app()->clientScript->registerPackage('_fileuploader');

        $this->render('index', array(
            'controlId' => $this->id . '_uploader',
            'uploadName' => $this->hasModel() ? CHtml::activeName($this->model, $this->attribute) : $this->name,
            'uploadUrl' => CHtml::normalizeUrl($this->url),
            'uploadId' => $this->hasModel() ? CHtml::activeId($this->model, $this->attribute) : "{$this->id}_{$this->name}",
            'publicUrl' => $publishFolder
        ));
    }

    public function getJsItemButtons() {
        $buttons = $this->itemButtons;

        $template = preg_replace_callback('/{(\w+)}/i', array($this, 'buildButtonTemplate'), $buttons['template']);
        unset($buttons['template']);

        foreach ($buttons as $name=>&$option) {
            $option['className'] = $name.'-button';
        }

        return CJavaScript::encode(array('template' => $template, 'buttons' => $buttons));
    }

    public function buildButtonTemplate($matches) {
        $button = $this->itemButtons[$matches[1]];
        return CHtml::link('', '#', array(
            'class' => $matches[1] . '-button ' . (isset($button['icon']) ? 'icon-' . $button['icon'] : '')
        ));
    }

    public function t($message, $params = array()) {
        return Yii::t(get_class($this).".messages", $message, $params);
    }

    /**
     * Small Js register helper
     *
     * @param $id
     * @param $code
     * @param $params
     */
    public function registerScript($id, $code, $params) {
        $jsnames = implode(',', array_keys($params));
        $jsparams = array();
        foreach ($params as $param)
            $jsparams[] = CJavaScript::encode($param);

        $jsparams = implode(',', $jsparams);

        Yii::app()->clientScript->registerScript($id, "(function ({$jsnames}) {{$code}})({$jsparams});", CClientScript::POS_READY);

    }
}