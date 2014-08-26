<?php

class BookAuthor extends BookAuthorGen
{
    public function rules()
    {
            return array(
                    array('book, author', 'required'),
                    array('book, author', 'length', 'max'=>20),
                    array('book, author', 'checkUniqIdx'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, book, author', 'safe', 'on'=>'search'),
            );
    }

    public function checkUniqIdx(){

        $cr = new CDbCriteria();
        if ( ! $this->isNewRecord){
            $cr->addCondition('id <> '.$this->id);
        }

        $cr->addColumnCondition(array('book'=>$this->book, 'author'=>$this->author));
        if ((int)$this->count($cr) > 0){
            $this->addError('name', 'Такой автор есть у книги');
            return true;
        }
        return false;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookAuthor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>