<?php

class Book extends BookGen
{

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bookAuthors' => array(self::HAS_MANY, 'BookAuthor', 'book'),
			'bookReader' => array(self::HAS_ONE, 'BookReader', 'book'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID book',
			'name' => 'Name of book',
			'date_create' => 'Date Create book',
			'date_edit' => 'Date Edit book',
		);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
                        array('name', 'checkUniqName'),
			//array('date_create, date_edit', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, date_create, date_edit', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Book the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>