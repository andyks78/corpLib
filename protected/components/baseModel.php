<?php
class baseModel extends CActiveRecord
{

    const ENCODE = 'UTF-8';
    const PAGE_SIZE = 25;
    const CACHE_TIMEOUT = 100000000; //

    public function checkUniqName(){
        if (($this->name !== null) && (mb_strlen(trim($this->name), $this::ENCODE) === 0)){
            return true;
        }
        $cr = new CDbCriteria();
        if ($this->id !== null){
            $cr->addCondition('id <> '.$this->id);
        }

        $cr->addColumnCondition(array('name'=>trim($this->name)));
        if ($this->count($cr) !== 0){
            $this->addError('name', 'Такой автор уже есть');
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


//    public function beforeSave() {
//        if (parent::beforeSave()){
//
//            if ($this->isNewRecord){
//                if (isset($this->attributes['date_create'])){
//                    $this->date_create = $this->date_edit = time();
//                }
//            }
//            else{
//                if (isset($this->attributes['date_edit'])){
//                    $this->date_edit = time();
//                }
//            }
//            return true;
//        }
//        else{
//            return false;
//        }
//    }

    public function cache($duration = null, $dependency=null, $queryCount=1)
    {
        if ($duration === null){
            $duration = $this::CACHE_TIMEOUT;
        }
        $this->getDbConnection()->cache($duration, $dependency, $queryCount);
        return $this;
    }


    function dateInt2str($dateInt, $isText = false, $format = "Y-m-d"){

        if ($dateInt === null){
            return null;
        }

        $cDate = time();
        $delta = $cDate - $dateInt;
        if ( ! $isText){
            $delta = 99999999999;
        }

        if ( $delta <= (24*60*60)){
            $out = 'сегодя, '.date('H:i', $dateInt);
        }
        elseif ( $delta <= ( 2 * 24*60*60)){
            $out = 'вчера, '.date('H:i', $dateInt);
        }
        else{
            $out = date($format, $dateInt); //date("Y-m-d H:i:s");
        }
        return $out;
    }

    public function getCurrentDateTime(){
        return date("Y-m-d H:i:s");
    }

}
?>