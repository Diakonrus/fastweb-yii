<?php

/**
 * This is the model class for table "{{loadxml_rubrics}}".
 *
 * The followings are the available columns in table '{{loadxml_rubrics}}':
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $module
 * @property string $tableadd1
 * @property string $tableadd2
 * @property string $tableadd3
 * @property string $tableadd4
 * @property string $brieftext
 * @property string $content1
 * @property string $content_add1
 * @property string $content_add2
 * @property string $content_add3
 * @property string $content_add4
 * @property string $content_link1
 * @property string $content_link2
 * @property string $content_link3
 * @property string $content_link4
 * @property string $content_link5
 * @property string $content2
 * @property string $groups
 * @property string $ext
 * @property string $unique
 * @property integer $splitter
 * @property string $tag
 * @property string $tags
 * @property string $class
 */
class LoadxmlRubrics extends CActiveRecord
{

    public $testedfile;
    public $url_to_file;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{loadxml_rubrics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ext', 'required'),
			array('status, module, splitter', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>250),
			array('tableadd1, tableadd2, tableadd3, tableadd4, unique', 'length', 'max'=>50),
			array('ext', 'length', 'max'=>20),
			array('tag', 'length', 'max'=>60),
			array('tags', 'length', 'max'=>1024),
			array('class', 'length', 'max'=>100),
            array('testedfile', 'file', 'types'=>'csv, xlsx, xml, xls', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, status, module, tableadd1, tableadd2, tableadd3, tableadd4, brieftext, content1, content_add1, content_add2, content_add3, content_add4, content_link1, content_link2, content_link3, content_link4, content_link5, content2, groups, ext, unique, splitter, tag, tags, class, url_to_file,
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
			'name' => 'Name',
			'status' => 'Status',
			'module' => 'Module',
			'tableadd1' => 'Tableadd1',
			'tableadd2' => 'Tableadd2',
			'tableadd3' => 'Tableadd3',
			'tableadd4' => 'Tableadd4',
			'brieftext' => 'Brieftext',
			'content1' => 'Content1',
			'content_add1' => 'Content Add1',
			'content_add2' => 'Content Add2',
			'content_add3' => 'Content Add3',
			'content_add4' => 'Content Add4',
			'content_link1' => 'Content Link1',
			'content_link2' => 'Content Link2',
			'content_link3' => 'Content Link3',
			'content_link4' => 'Content Link4',
			'content_link5' => 'Content Link5',
			'content2' => 'Content2',
			'groups' => 'Groups',
			'ext' => 'Загрузка файла',
			'unique' => 'Unique',
			'splitter' => 'Splitter',
			'tag' => 'Tag',
			'tags' => 'Tags',
			'class' => 'Class',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('module',$this->module);
		$criteria->compare('tableadd1',$this->tableadd1,true);
		$criteria->compare('tableadd2',$this->tableadd2,true);
		$criteria->compare('tableadd3',$this->tableadd3,true);
		$criteria->compare('tableadd4',$this->tableadd4,true);
		$criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('content1',$this->content1,true);
		$criteria->compare('content_add1',$this->content_add1,true);
		$criteria->compare('content_add2',$this->content_add2,true);
		$criteria->compare('content_add3',$this->content_add3,true);
		$criteria->compare('content_add4',$this->content_add4,true);
		$criteria->compare('content_link1',$this->content_link1,true);
		$criteria->compare('content_link2',$this->content_link2,true);
		$criteria->compare('content_link3',$this->content_link3,true);
		$criteria->compare('content_link4',$this->content_link4,true);
		$criteria->compare('content_link5',$this->content_link5,true);
		$criteria->compare('content2',$this->content2,true);
		$criteria->compare('groups',$this->groups,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('unique',$this->unique,true);
		$criteria->compare('splitter',$this->splitter);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('class',$this->class,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoadxmlRubrics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getSplitter($id = null){
        $name = array(
            0 => '',
            1 => ';',
            2 => ',',
            3 => '|',
            4 => '%',
        );
        if (!empty($id)){ return$name[$id]; }
        else { return $name; }
    }

    public function getModule(){
        $name = array(
            1 => 'Каталог',
           // 2 => 'Двигатели',
            //3 => 'Коробки передач',
        );
        return $name;
    }

    public function getTags($model){
        $tags = explode("|", $model->tags);
        $result = array();
        foreach ($tags as $value){
            $result[$value] = $value;
        }
        return $result;
    }

    //Поля в зависимости от модуля
    public function getFeeldsContent2($module){
        //$module: 1- каталог, 2-двигатели, 3-коробка передач
        $result = array();
        switch ($module) {
            case 1:
                $result = CatalogElements::model()->attributeLabels();
                break;
            case 2:
                $result = CatalogengineElements::model()->attributeLabels();
                break;
            case 3:
                $result = CatalogtransmissionElements::model()->attributeLabels();
                break;
        }
        if (isset($result['id'])){unset($result['id']);}
        return $result;
    }
}
