<?php


/**
 * Description of baseItemModel
 *
 * @author qwerty
 */
class baseItemModel extends baseModel {
    
    public function searchAdmin()
    {
            $criteria=new CDbCriteria;
            $criteria->compare('id',$this->id,true);
            $criteria->compare('name',$this->name,true);
            if ($this->date_create !== null){
                $dtStart = CDateTimeParser::parse($this->date_create,'yyyy-MM-dd');
                if ($dtStart !== false){
                    $dtEnd = $dtStart + 86400 ; // + 1 день
                    $criteria->addBetweenCondition('date_create', $dtStart , $dtEnd);
                }
            }
            //$criteria->compare('date_create',$this->date_create);
            if ($this->date_edit !== null){
                $dtStart = CDateTimeParser::parse($this->date_edit,'yyyy-MM-dd');
                if ($dtStart !== false){
                    $dtEnd = $dtStart + 86400 ; // + 1 день
                    $criteria->addBetweenCondition('date_edit', $dtStart , $dtEnd);
                }
            }
            //$criteria->compare('date_edit',$this->date_edit);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function checkUniqName(){
        if (($this->name !== null) && (mb_strlen(trim($this->name), $this::ENCODE) === 0)){
            return true;
        }
        $cr = new CDbCriteria();
        if ( ! $this->isNewRecord){
            $cr->addCondition('id <> '.$this->id);
        }

        $cr->addColumnCondition(array('name'=>trim($this->name)));
        if ((int)$this->count($cr) > 0){
            $this->addError('name', 'Поле "name" должно быть уникальным');
            return true;
        }
        return false;
    }

    public function afterFind() {
        parent::afterFind();
        if (isset($this->attributes['date_create'])){
            $this->date_create = $this->dateInt2str($this->date_create, false, 'Y-m-d H:i:s');
        }
        if (isset($this->attributes['date_edit'])){
            $this->date_edit = $this->dateInt2str($this->date_edit, false, 'Y-m-d H:i:s');
        }
    }

    public function behaviors(){
        return CMap::mergeArray(parent::behaviors(),
                array(
                'CTimestampBehavior' => array(
                            'class' => 'zii.behaviors.CTimestampBehavior',
                            'createAttribute' => 'date_create',
                            'updateAttribute' => 'date_edit',
                            'timestampExpression' => time(),//'date("Y-m-d H:i:s")',
                            'setUpdateOnCreate' => true,
                        ),
                    )
                );
    }
}

?>
