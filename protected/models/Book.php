<?php

class Book extends BookGen
{
    public function reportRandom5(){

        $cr = new CDbCriteria();
        $cr->limit = 5;
        $cr->order = 'RAND()'; // так делать нерекомендуют на больших объмах ;))

        return new CActiveDataProvider($this, array(
                'criteria'=>$cr,
                'pagination'=>false,
        ));
    }

    public function report3Authors(){

        $sql = '
            SELECT
                b.id, b.name, b.date_create, b.date_edit
            FROM
                book b, book_author ba, book_reader br
            WHERE
                b.id = br.book
                AND b.id = ba.book
            GROUP BY b.id, b.name, b.date_create, b.date_edit
            HAVING COUNT(ba.id) > 2
        ';
        $command = $this->getDbConnection()->createCommand($sql);
        $rows = $command->queryAll();
        return new CArrayDataProvider($this->populateRecords($rows));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()){
            // удалим связи с авторами
            foreach ($this->bookAuthors as $ba){
                if ( ! $ba->delete()){
                    throw new CDbException(implode(',', $ba->getErrors()));
                }
            }
            // удалим связи с читателем
            if ( ! $this->bookReader->delete()){
                throw new CDbException(implode(',', $this->bookReader->getErrors()));
            }

            return true;
        }
        return false;
    }

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