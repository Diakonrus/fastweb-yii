<?php

/**
 * This is the model class for table "{{press_group}}".
 *
 * The followings are the available columns in table '{{press_group}}':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $created_at
 */
class PressGroup extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    public $imagefile;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{press_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url', 'required'),
			array('status, param_design', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>350),
            array('url, title', 'length', 'max'=>250),
            array('url','unique', 'message'=>'Такой URL уже занят - введите другой URL-адрес.'),
            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			array('description, brieftext', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, title, description, url, brieftext, status, created_at, param_design, created_at_start, created_at_end,
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
            'url' => 'Url адрес',
			'name' => 'Название',
			'title' => 'Заголовок',
            'brieftext' => 'Анонс (короткий текст)',
			'description' => 'Описание',
            'param_design' => 'Стиль оформления',
			'status' => 'Статус',
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
		$criteria->compare('title',$this->title,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
        $criteria->compare('param_design',$this->param_design);
		$this->compareDate($criteria, 'created_at');

        $criteria_param = array(
            'criteria'=>$criteria,
        );
        if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 14')){
            $criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
        }


        return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return pressGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave() {
        $this->url = mb_strtolower($this->url);
        return true;
    }


    private $statusArr = array(
        0=>'Отключено',
        1=>'Включено'
    );

    public function getStatuslist($id=null){
        return ((!empty($id))?$this->statusArr[$id]:$this->statusArr);
    }


    public function getParamDesign($id = null){
        $name = array(
            1 => 'Оформление блока на белом фоне',
            2 => 'Оформление блока на сером фоне',
        );
        return ((!empty($id))?$name[$id]:$name);
    }

    /**
     * @param $model - модель press
     * Возращает сформированый дизайн списка новости в соответствии с $model группы
     */
    public function returnDesignElement($model){

        $template_element = '
            <div class="press">
                <figure>
                    %image%
                </figure>
                <article>
                    <span>%maindate%</span>
                    <h1>%url%</h1>
                    %brieftext%
                </article>
            </div>
        ';

        $template_element = str_replace("%image%", ((!empty($model->image))?('<img alt="'.$model->name.'" src="/uploads/filestorage/press/elements/small-'.$model->id.'.'.$model->image.'">'):('')), $template_element);
        $template_element = str_replace("%maindate%", (date("d.m.Y", strtotime($model->maindate))), $template_element);
        $template_element = str_replace("%url%", '<a href="'.Yii::app()->request->requestUri.'/'.$model->id.'">'.$model->name.'</a>', $template_element);
        $template_element = str_replace("%brieftext%", $model->brieftext, $template_element);

        return $template_element;
    }

    /**
     * @param $model - модель pressGroup
     * Возращает сформированый дизайн списка групп в соответствии с $model группы
     */
    public function returnDesignGroup($model){
        //Серый
        $template_gray = '
            <section class="shadow mg-top-15">
                <div class="bg-gray pd-bottom-40 bottom-shadow">
                    <main class="all" role="main">
                        <div class="container">
                            <h1 class="caption-big">%name%</h1>
                            <a href="'.Yii::app()->request->requestUri.'/'.$model->url.'">
                            <figure class="main-pic" style="cursor: pointer;" >
                                %image%
                                <figcaption>
                                    %brieftext%
                                </figcaption>
                            </figure>
                            </a>
                        </div>
                    </main>
                </div>
            </section>
        ';

        //Белый
        $template_white = '
            <section class="metro pd-top-30 mg-bottom-30">
                <main class="all" role="main">
                    <div class="container">
                        <h2 class="main-caption">%name%</h2>
                        <a href="'.Yii::app()->request->requestUri.'/'.$model->url.'">
                        <figure class="main-pic" style="cursor: pointer;">
                            %image%
                            <figcaption>
                                %brieftext%
                            </figcaption>
                        </figure>
                        </a>
                    </div>
                </main>
            </section>
        ';

        $return = $template_white;
        if ($model->param_design == 2){
            $return = $template_gray;
        }

        $return = str_replace("%name%", $model->name, $return);
        $return = str_replace("%image%", ((!empty($model->image))?('<img src="/uploads/filestorage/press/rubrics/'.$model->id.'.'.$model->image.'">'):('')), $return);
        $return = str_replace("%brieftext%", $model->brieftext, $return);
        $return = str_replace("%description%", $model->description, $return);

        $press_element = '';
        $i = 0;
        foreach (Press::model()->findAll('group_id = '.$model->id.' AND status!=0 ORDER BY id DESC') as $dataPress){
            ++$i;
            if ($i%2!=0){ $press_element.='<div class="press-line">'; }
            $press_element .= PressGroup::model()->returnDesignElement($dataPress);
            if ($i%2==0){ $press_element.= '</div>'; }
        }
        $return = str_replace("%press_element%", $press_element, $return);
        return $return;
    }

}
