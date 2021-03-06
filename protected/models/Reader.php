<?php

class Reader extends ReaderGen
{

        public function beforeDelete() {
            if (parent::beforeDelete()){
                // удалим связи с читаемыми книгами
                foreach ($this->bookReaders as $br){
                    if ( ! $br->delete()){
                        throw new CDbException(implode(',', $br->getErrors()));
                    }
                }
                return true;
            }
            return false;
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
	 * @return Reader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>