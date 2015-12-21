<?php

class UserFilterModel extends CFormModel {
    //sex search
    public $sex;
    //for bootstrap
    public $sex_toggle;

    public $birthday_toggle;

    public $birthday_option;
    public $birthday_from;
    public $birthday_to;

    public $phone_toggle;
    public $phone;

    public $email_toggle;
    public $email;
    public $email_confirm;

    public $created_option;
    public $created_toggle;
    public $created_from;
    public $created_to;

    public $city_toggle;
    public $country_toggle;
    public $country;
    public $regions_toggle;
    public $regions;
    public $settlements_toggle;
    public $settlements;

    public function rules() {
        return array(
            //change safe attributes for matches
            array('sex_toggle, birthday_toggle, phone_toggle, created_toggle', 'safe'),

            //change safe attributes
            array('sex, phone', 'safe'),

            array('birthday_option, birthday_from, birthday_to', 'safe'),
            array('created_option, created_from, created_to', 'safe'),

            array('email_toggle, email_confirm, email', 'safe'),
            array('city_toggle, country_toggle, regions_toggle, settlements_toggle', 'safe'),
            array('settlements, regions, country', 'safe'),
            //array('sex', 'in', 'range'=>array('man', 'woman'), 'allowEmpty'=>true),
            //array('birthday_option', 'in', 'range'=>array('range', 'more', 'small', 'strong')),
            //array('birthday_from, birthday_to', 'date', 'format'=>'dd.MM.yyyy', 'allowEmpty'=>true),
        );
    }

    public function beforeValidate() {
        /*
        $this->birthday_from = strtotime($this->birthday_from);
        $this->birthday_to = strtotime($this->birthday_to);

        $this->created_from = strtotime($this->created_from);
        $this->created_to = strtotime($this->created_to);

        $this->kids_birthday_from = strtotime($this->kids_birthday_from);
        $this->kids_birthday_to = strtotime($this->kids_birthday_to);
         *
         */
    }

    public function attributeLabels() {
        return array(
            'sex_toggle'=>'Учитывать пол',
            'birthday_toggle'=>'Учитывать дату рождения',
            'phone_toggle'=>'Учитывать данные о номере телефона',
            'created_toggle'=>'Учитывать дату регистрации',
            'sex'=>'Пол',
            'phone'=>'Телефон',
            'birthday_option'=>'Варианты поиска',
            'created_option'=>'Варианты поиска',
            'email_toggle'=>'Учитывать данные об электронной почте',
            'email_confirm'=>'Подтвержден ли email',
            'city_toggle'=>'Учитывать данные о проживании',
            'country_toggle'=>'Учитывать страну',
            'regions_toggle'=>'Учитывать регион',
            'settlements_toggle'=>'Учитывать населенный пункт',
        );
    }

    public static function expressions() {
        return array(
            array('in', 't.sex', 'value'=>'&sex', 'skip'=>'!&sex_toggle'),
            array('cdate', 't.birthday', 'value'=>'&birthday_from', 'skip'=>'&birthday_option!="strong" || !&birthday_toggle'),
            array('cdate', 't.birthday', 'operator'=>'">"', 'value'=>'&birthday_from', 'skip'=>'&birthday_option!="more" || !&birthday_toggle'),
            array('cdate', 't.birthday', 'operator'=>'"<"', 'value'=>'&birthday_from', 'skip'=>'&birthday_option!="small" || !&birthday_toggle'),
            array('drange', 't.birthday', 'from'=>'&birthday_from', 'to'=>'&birthday_to', 'inclusive'=>true,'skip'=>'&birthday_option!="range" || !&birthday_toggle'),

            array('cdate', 't.created', 'value'=>'&created_from', 'skip'=>'&created_option!="strong" || !&created_toggle'),
            array('cdate', 't.created', 'operator'=>'">"', 'value'=>'&created_from', 'skip'=>'&created_option!="more" || !&created_toggle'),
            array('cdate', 't.created', 'operator'=>'"<"', 'value'=>'&created_from', 'skip'=>'&created_option!="small" || !&created_toggle'),
            array('drange', 't.created', 'from'=>'&created_from', 'to'=>'&created_to', 'inclusive'=>true,'skip'=>'&created_option!="range" || !&created_toggle'),

            array('like', 't.phone', 'value'=>'&phone', 'skip'=>'!&phone_toggle'),

            array('like', 't.email', 'value'=>'&email', 'skip'=>'!&email_toggle'),
            array('compare', 't.mail_confirm', 'value'=>'&email_confirm', 'skip'=>'!&email_toggle'),

            array('multy', array('jcity', 'jcity.region', 'jcity.country'), 'expressions'=>array(
                array('in', 'jcity.id', 'value'=>'&settlements', 'skip'=>'!&settlements_toggle || !&city_toggle', 'strong'=>false),
                array('in', 'region.id', 'value'=>'&regions', 'skip'=>'!&regions_toggle || !&city_toggle', 'strong'=>false),
                array('in', 'country.id', 'value'=>'&country', 'skip'=>'!&country_toggle || !&city_toggle', 'strong'=>false),
            )),
        );
    }

}
