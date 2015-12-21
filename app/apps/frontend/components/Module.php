<?php

class Module extends CWebModule {

	protected $_rules = array();

	public function t($category, $phrase, $params = array())
	{
		return Yii::t(ucfirst($this->name).'Module.'.$category, $phrase, $params);
	}

	public function setRules($value)
	{
		if (!is_array($value))
		{
			throw new CException('"rules" can\'t be use with other types except an array');
		}
		$this->_rules = $value;
	}

	public function getRules()
	{
		return $this->_rules;
	}
}