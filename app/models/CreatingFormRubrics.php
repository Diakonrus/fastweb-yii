<?php

/**
 * This is the model class for table "{{creating_form_rubrics}}".
 *
 * The followings are the available columns in table '{{creating_form_rubrics}}':
 * @property integer $id
 * @property string $name
 * @property string $subject_recipient
 * @property string $email_recipient
 * @property string $complete_mess
 * @property integer $status
 * @property string $creating_at
 */
class CreatingFormRubrics extends CActiveRecord
{
    public $creating_at_start;
	public $creating_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{creating_form_rubrics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, subject_recipient, email_recipient', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>250),
			array('subject_recipient, email_recipient', 'length', 'max'=>350),
			array('complete_mess', 'length', 'max'=>450),
			array('email_recipient', 'email', 'checkMX'=>true, 'message'=>'"{attribute}" не является верным адресом электронной почты.'),
			array('form_template', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, subject_recipient, email_recipient, complete_mess, form_template, status, creating_at, creating_at_start, creating_at_end,
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
			'subject_recipient' => 'Тема письма',
			'email_recipient' => 'Email',
			'complete_mess' => 'Сообщение по завершении',
			'status' => 'Статус',
			'form_template' => 'Шаблон формы',
			'creating_at' => 'Creating At',
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
		$criteria->compare('subject_recipient',$this->subject_recipient,true);
		$criteria->compare('email_recipient',$this->email_recipient,true);
		$criteria->compare('complete_mess',$this->complete_mess,true);
		$criteria->compare('status',$this->status);
		$this->compareDate($criteria, 'creating_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CreatingFormRubrics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Стандартные шаблоны формы
	 */
	public $def_form_template = '
		<ul>
		%feelds_input%
		</ul>
	';
	public $def_feeld_template = '
		<li>%feeld_name%<span style="margin-left:10px;">%feeld_val%</span></li>
	';

	private $feeldsTypesArray = array(
		1 => 'Поле ввода E-mail',
		2 => 'Короткое поле ввода (input)',
		3 => 'Большое поле ввода (textarea)',
		4 => 'Текст',
		5 => 'Дата - день, месяц и год',
		6 => 'Ссылка (в поле `Значение` укажите URL-адрес ссылки)',
		7 => 'Выпадающий список (варианты в выпадающем списке перечислите в поле `Значение` через символ ;)',
		8 => 'Кнопка',
		9 => 'Радио кнопка (варианты списка перечислите в поле `Значение` через символ ;)',
		10 => 'Кнопка отправки формы',
	);

	/**
	 * @param null $id
	 * Возвращает массив типов полей формы либо его (поля) название, если передан id
	 */
	public function getFeeldsTypes($id = null){
		return ((!empty($id))?($this->feeldsTypesArray[$id]):($this->feeldsTypesArray));
	}

	/**
	 * @param $id
	 * Возвращает HTML код формы по id записи в tbl_creating_form_rubrics
	 */
	public function showForm($id){
		$html = '';
		if ($model = CreatingFormRubrics::model()->findByPk($id)){
			//Форма
			$forms = '<form id="creating_form_'.$id.'" action="/apply_auto_form" method="POST">';
			$forms .= 	((!empty($model->form_template))?($model->form_template):($this->def_form_template));
			$forms .= '</form>';

			//Поля формы
			$feelds = '';
			foreach ( CreatingFormElements::model()->findAll('parent_id='.$model->id.' AND `status`=1 ORDER BY order_id ASC') as $data ){
				$feelds .= CreatingFormRubrics::model()->getFeeldHTML($data);
			}

			//Вешаем обработчик JS
			$forms .= '
			<script>
			    $("#creating_form_'.$id.'").submit(function() {
					$.ajax({
						url: "/apply_auto_form",
						type: "POST",
						dataType: "json",
						data: $("#creating_form_'.$id.'").serialize(),
						success: function (response) {
							alert(response);
						},
					});
					return false;
				});
			</script>
			';

			$html = str_replace("%feelds_input%", $feelds, $forms);

		}
		return $html;
	}

	/**
	 * @param $model
	 * Возращает HTML код поля
	 */
	public function getFeeldHTML($model){

		$html = '';

		//Если шаблон пустой - беру из дефолтного
		$model->feeld_template = ((!empty($model->feeld_template))?($model->feeld_template):(CreatingFormRubrics::model()->def_feeld_template));

		//Определяем, что за тип поля. По типу поля работаем со значением
		switch ($model->feeld_type) {
			case 1:
				//Поле ввода E-mail
				$model->feeld_template = str_replace("%feeld_name%", $model->name, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '<input type="text" name="CreatingForm['.$model->id.']" value="'.$model->feeld_value.'">', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 2:
				//Короткое поле ввода (input)
				$model->feeld_template = str_replace("%feeld_name%", $model->name, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '<input type="text" name="CreatingForm['.$model->id.']" value="'.$model->feeld_value.'">', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 3:
				//Большое поле ввода (textarea)
				$model->feeld_template = str_replace("%feeld_name%", $model->name, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '<textarea name="CreatingForm['.$model->id.']">'.$model->feeld_value.'</textarea>', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 4:
				//Текст
				$model->feeld_template = str_replace("%feeld_name%", $model->feeld_value, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 5:
				//Дата - день, месяц и год
				$model->feeld_template = str_replace("%feeld_name%", $model->name, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '<input type="text" name="CreatingForm['.$model->id.']" value="'.$model->feeld_value.'">', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 6:
				//Ссылка (в поле `Значение` укажите URL-адрес ссылки)
				$model->feeld_template = str_replace("%feeld_name%", '<a href="'.$model->feeld_value.'">'.$model->name.'</a>', $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 7:
				//Выпадающий список (варианты в выпадающем списке перечислите в поле `Значение` через символ ;)
				$model->feeld_value = $model->feeld_value.';';
				$selects = '<select name="CreatingForm['.$model->id.']">';
				foreach ( explode(";", $model->feeld_value) as $val ){
					if (empty($val)){continue;}
					$selects .= '<option value="'.$val.'">'.$val.'</option>';
				}
				$selects .= '</select>';
				$model->feeld_template = str_replace("%feeld_name%", $model->name, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", $selects, $model->feeld_template);

				$html = $model->feeld_template;
				break;
			case 8:
				//Кнопка
				$model->feeld_template = str_replace("%feeld_name%", '', $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '<button value="'.$model->feeld_value.'" type="button" name="CreatingForm['.$model->id.']">'.$model->name.'</button>', $model->feeld_template);
				$html = $model->feeld_template;
				break;
			case 9:
				//Радио кнопка
				$model->feeld_value = $model->feeld_value.';';
				$radio = '';
				foreach ( explode(";", $model->feeld_value) as $val ){
					if (empty($val)){continue;}
					$radio .= '<input type="radio" name="CreatingForm['.$model->id.']" value="'.$val.'">'.$val.'<Br>';
				}
				$model->feeld_template = str_replace("%feeld_name%", $model->name, $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", $radio, $model->feeld_template);

				$html = $model->feeld_template;
				break;
			case 10:
				//Кнопка отправки формы
				$model->feeld_template = str_replace("%feeld_name%", '', $model->feeld_template);
				$model->feeld_template = str_replace("%feeld_val%", '<input type="submit" value="'.$model->name.'">', $model->feeld_template);
				$html = $model->feeld_template;
				break;
		}


		return $html;


	}




}
