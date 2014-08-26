<?php

class Author extends AuthorGen
{

    public function beforeDelete() {
        if (parent::beforeDelete()){
            // удалим связи с книгами
            foreach ($this->bookAuthors as $ba){
                if ( ! $ba->delete()){
                    throw new CDbException(implode(',', $ba->getErrors()));
                }
            }
            return true;
        }
        return false;
    }

    public function report3Readers(){
        $sql = '
            	SELECT
                    a.id, a.name, a.date_create, a.date_edit
                FROM
                    book_author ba, book_reader br, author a
                WHERE
                    a.id = ba.author
                    AND br.book =  ba.book
                GROUP BY a.id, a.name, a.date_create, a.date_edit
                HAVING COUNT(br.id) > 2
        ';

        $command = $this->getDbConnection()->createCommand($sql);
        $rows = $command->queryAll();
        return new CArrayDataProvider($this->populateRecords($rows));
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

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>