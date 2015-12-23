<?php

class backendfilterWidget extends CWidget{

    public $model;
    public $listId;
	/**
	 * SYNTAX:
	 * [column name, ...] by default text filter or
	 * [array(column name, field type, other params ...),...]
	 *
	 * @var array
	 */
    public $columns = array();

    public function init(){
        //Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', CClientScript::POS_HEAD);
    }

    public function run(){

        $this->render('form', array(
            'id' => $this->id,
            'model' => $this->model,
            'columns' => $this->columns,
            'listId' => $this->listId,
        ));

    }

	public function getFilterControl($form, $columnData) {

		// prepare data if used default filter
		if (is_string($columnData))
			$columnData = array($columnData);

		if (empty($columnData))
			throw new CException(Yii::t('application', 'Invalid column data "{data}"', array('{data}'=>print_r($columnData, true))));

		// as simply that equal model attribute
		$columnName = $columnData[0];

		// set universal data for callables and custom filters
		$columnData['model'] = $this->model;
		$columnData['attribute'] = $columnName;
		$columnData['form'] = $form;
		$columnData['this'] = $this;

		// html options from 'htmlOptions' key
		$columnData['htmlOptions'] = empty($columnData['htmlOptions']) ? array() : $columnData['htmlOptions'];
//		$htmlOptions = $columnData['htmlOptions'];

		// fetch params from after 0 index
		$extendedParams = array_slice($columnData, 1);

		if ( count($extendedParams) > 0 && isset($extendedParams[0]) ) {
			// if isset filterName
			if (is_string($filterName = $extendedParams[0])) {
				// custom filter
				return $this->callCustomFilter($filterName, $columnName, array_slice($extendedParams, 1));
			} elseif (is_array($listData = $extendedParams[0])) {
				// drop down list
				return $form->dropDownListRow($this->model, $columnName, $listData, $columnData['htmlOptions']);
			} elseif (is_callable($callable = $extendedParams[0])) {
				// from callable
				// callable params: $model, $attribute, $form, $this, $htmlOptions, ... customParams
//				var_dump(array_keys(array_slice($extendedParams, 1))); die;
				return call_user_func_array($callable, array_slice($extendedParams, 1));
			}
		}

		// return default filter
		return $form->textFieldRow($this->model, $columnName, $columnData['htmlOptions']);
	}

	protected function callCustomFilter($filterName, $columnName, $filterData) {

		$methodName = 'filter' . ucfirst($filterName);
		if (!method_exists($this, $methodName))
			throw new CException(Yii::t('application', 'Filter "{filterName}" not found', array('{filterName}'=>$filterName)));

		return $this->$methodName($columnName, $filterData);
	}

	/**
	 * renders dropDownListRow
	 * example: array('field', 'select', 'listData' => array(...))
	 * need listData parameter
	 */
	public function filterSelect($columnName, $options) {
		// or dropDownListRow($data['model'], $data['attribute'], $data['listData'], $data['htmlOptions']);
		return $options['form']->dropDownListRow($this->model, $columnName, $options['listData'], array_merge(array('empty'=>'Не выбрано'), $options['htmlOptions']));
	}

    /**
     * renders toggleButtonRow <br>
     * example: array('field', 'checkbox', 'htmlOptions'=>array( <br>
     *      'enabledLabel'=>'Да', <br>
     *      'disabledLabel'=>'Нет', <br>
     * )) <br>
     * need listData parameter
     */
    public function filterCheckbox($columnName, $options) {
        return $options['form']->toggleButtonRow($this->model, $columnName, $options['htmlOptions']);
    }

	public function filterUser($columnName, $options) {
		// or dropDownListRow($data['model'], $data['attribute'], $data['listData'], $data['htmlOptions']);
		$hasMultiple = isset($options['multiple']) && $options['multiple'];
		$url = CHtml::normalizeUrl(array('/user/list/get'));
		$jsData = CJavaScript::encode(array(
			'url' => $url,
			'multiple'=>$hasMultiple
		));

		return $options['form']->select2Row($this->model, $columnName, array(
			'asDropDownList' => false,
			'options' => array(
				'multiple'=>$hasMultiple,
				'ajax' => array(
					'url' => $url,
					'dataType' => 'json',
					'data'=>'js:function (term) { return {q: term} }',
					'results'=>'js:function (data) { return {results: data} }'
				),
				'initSelection' => "js:function (element, callback) {
					var value = element.val(),
						that = this,
						jsData = {$jsData};

					if (value != '')
						$.get(jsData.url, {ids: value}, function (data) {
							callback(jsData.multiple ? data : data.pop());
						}, 'json');
				}"
			),
			'htmlOptions'=>array_merge(array('class' => 'span5'), $options['htmlOptions'])
		));
	}

	public function filterDate($columnName, $options) {
        $range = isset($options['range']) && $options['range'];

		return $options['form']->widgetRow('ext.backendfilter.DateFilter', array(
			'model' => $this->model,
			'attribute' => $columnName,
			'form'=>$options['form'],
            'range'=>$range,
			'htmlOptions' => array_merge(array(
				'class' => 'span5',
			), $options['htmlOptions'])
		));
	}
}