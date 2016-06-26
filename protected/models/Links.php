<?php

/**
 * This is the model class for table "tbl_links".
 *
 * The followings are the available columns in table 'tbl_links':
 * @property integer $id
 * @property integer $link
 * @property integer $game_id
 * @property string $date
 */
class Links extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_links';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('game_id, date, phone_number, status', 'required'),
			array('game_id, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, link, game_id, date, phone_number, status', 'safe', 'on'=>'search'),
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


    public function getColumnByPk($pk, $column){
        $classname = get_class($this);
        if($cat = $classname::model()->findByPk($pk)){
            return $cat->$column;
        }
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'token' => 'Уникальный код',
			'game_id' => 'Игра',
			'date' => 'Дата генерации',
            'phone_number' => 'Номер телефона'
		);
	}

    public function getDateTimeObj($date){

        $DTObj= new DateTime();
        $DTObj->setTimezone(new DateTimeZone('Asia/Almaty'));
        $dayAndTime = explode(' ', $date);
        $day = explode('-', $dayAndTime[0]);
        $time = explode(':', $dayAndTime[1]);

        $DTObj->setDate($day[0], $day[1], $day[2]);
        $DTObj->setTime($time[0], $time[1], $time[2]);
        return $DTObj;

    }

    protected function beforeSave(){
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->date = date("Y-m-d H:i:s");
            }
            return true;
        }
        else{
            return false;
        }
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
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('date',$this->date,true);
        $criteria->compare('phone_number',$this->phone_number,true);

        return new CActiveDataProvider($this, array(
            'sort'=>array(
                'defaultOrder'=>'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            ),
            'criteria'=>$criteria
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Links the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
