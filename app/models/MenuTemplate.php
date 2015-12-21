<?php

/**
 * This is the model class for table "{{menu_template}}".
 *
 * The followings are the available columns in table '{{menu_template}}':
 * @property integer $id
 * @property string $name
 * @property string $param_menu
 * @property string $body
 * @property string $created_at
 */
class MenuTemplate extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>350),
			array('param_menu', 'length', 'max'=>550),
            array('float, status', 'numerical', 'integerOnly'=>true),
			array('body, script, style, base_template_head, base_template_body_link, base_template_body_menu', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, param_menu, body, status, script, style, created_at, float,  base_template_head, base_template_body_link, base_template_body_menu, created_at_start, created_at_end,
                   ', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'param_menu' => 'Параметры',
			'body' => 'Код',
            'script' => 'Скрипт JS',
            'style' => 'Стиль CSS',
            'float' => 'Ориентация',
            'status' => 'Статус',
            'base_template_head' => 'Базовый макет шаблона (общий)',
            'base_template_body_link' => 'Базовый макет шаблона (для ссылок)',
            'base_template_body_menu' => 'Базовый макет шаблона (для меню)',
			'created_at' => 'Дата создания',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('param_menu',$this->param_menu,true);
		$criteria->compare('body',$this->body,true);
        $criteria->compare('script',$this->script,true);
        $criteria->compare('style',$this->style,true);
        $criteria->compare('base_template_head',$this->base_template_head,true);
        $criteria->compare('base_template_body_link',$this->base_template_body_link,true);
        $criteria->compare('base_template_body_menu',$this->base_template_body_menu,true);
        $criteria->compare('float',$this->float);
        $criteria->compare('status',$this->status);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getModelsByParam($param){
        $param = explode("|", $param);
        $result = array();
        foreach($param as $value){
            $tmp_val = explode("=", $value);
            if (count($tmp_val)!=2){ continue; }
            $key = $tmp_val[0];
            $val = $tmp_val[1];

            switch ($key) {
                case 'menu':
                    $model = Menu::model()->findByPk((int)$val);
                    if ($model){
                        $result[]['menu'] = $model;
                    }
                    break;
                case 'link':
                    $model = Pages::model()->findByPk((int)$val);
                    if ($model){
                        $result[]['link'] = $model;
                    }
                    break;
            }

        }
        return $result;
    }


    /** Базовые темплейты меню */
    public $base_template_head_val = '
            <div class="nav col-md-6">
                <ul style="margin-left:50px; min-width:550px;">
                    %base_template_body%
                </ul>
            </div>
        ';
    public $base_template_body_link_val = '
            %init_model%
            <li>
                <div class="icon">
                    <a href="%url_link%">
                        <img width="40" height="40" alt="img" src="%url_img%">
                    </a>
                    <a class="link-menu-top" href="%url_link%">%name_link%</a>
                </div>
            </li>
        ';
    public $base_template_body_menu_val = '
            %init_model%
            <li>
                <div class="icon">
                    <a href="#">
                        <img class="showOrderNavMenu" width="40" height="40" alt="img" src="%url_img%">
                    </a>
                    <a class="showOrderNavMenu link-menu-top" href="#">%name_menu%</a>
                </div>
                <div class="order-nav" style="display: none;">
                    <ul>
                        %links_menu%
                    </ul>
                </div>
            </li>
        ';



}
