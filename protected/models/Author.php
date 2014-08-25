<?php

class Author extends AuthorGen
{

    // уехало в baseModel
//	public function searchAdmin()
//	{
//		$criteria=new CDbCriteria;
//		$criteria->compare('id',$this->id,true);
//		$criteria->compare('name',$this->name,true);
//                if ($this->date_create !== null){
//                    $dtStart = CDateTimeParser::parse($this->date_create,'yyyy-MM-dd');
//                    if ($dtStart !== false){
//                        $dtEnd = $dtStart + 86400 ; // + 1 день
//                        $criteria->addBetweenCondition('date_create', $dtStart , $dtEnd);
//                    }
//                }
//		//$criteria->compare('date_create',$this->date_create);
//                if ($this->date_edit !== null){
//                    $dtStart = CDateTimeParser::parse($this->date_edit,'yyyy-MM-dd');
//                    if ($dtStart !== false){
//                        $dtEnd = $dtStart + 86400 ; // + 1 день
//                        $criteria->addBetweenCondition('date_edit', $dtStart , $dtEnd);
//                    }
//                }
//		//$criteria->compare('date_edit',$this->date_edit);
//
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
//	}

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

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>