<?php

/**
 * This is the model class for table "tbl_activations".
 *
 * The followings are the available columns in table 'tbl_activations':
 * @property integer $id
 * @property integer $client_id
 * @property integer $city_id
 * @property integer $promo_id
 * @property string $sercret_key
 * @property string $date
 */
class Activations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lipton_activations';
	}


    public $date_to;
    public $date_from;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, city_id, promo_id, sercret_key, date', 'required'),
			array('client_id, city_id, promo_id', 'numerical', 'integerOnly'=>true),
			array('sercret_key', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_id, city_id, promo_id, sercret_key, date, date_to, date_from, phone', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => 'Клиент',
			'city_id' => 'Город',
			'promo_id' => 'Промо точка',
			'sercret_key' => 'Секретный код',
			'date' => 'Дата',
            'phone'=>'Номер'
		);
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('promo_id',$this->promo_id);
		$criteria->compare('sercret_key',$this->sercret_key,true);
		$criteria->compare('date',$this->date,true);
        $criteria->compare('date', ">=" . $this->date_from,true);
        $criteria->compare('date', "<=" . $this->date_to,true);

		return new CActiveDataProvider($this, array(
            'sort'=>array(
                'defaultOrder'=>'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            ),
            'criteria'=>$criteria,
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Activations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /////////////////////////////////////LIPTON PROMO/////////////////////////////////////////////////////////////////////////

    public static function sendSMS($message, $phone, $prefix){

        $sender = "1213";

        $gates = array(
            "7700"=>"altel-kz-all-sms",
            "7708"=>"altel-kz-all-sms",
            "7701"=>"gsmkazakhstan-kz-1213-sms",
            "7702"=>"gsmkazakhstan-kz-1213-sms",
            "7775"=>"gsmkazakhstan-kz-1213-sms",
            "7778"=>"gsmkazakhstan-kz-1213-sms",
            "7777"=>"beeline-kz-1213-sms",
            "7705"=>"beeline-kz-1213-sms",
            "7776"=>"beeline-kz-1213-sms",
            "7771"=>"beeline-kz-1213-sms",
            "7707"=>"neogsm-kz-all-sms",
            "7747"=>"neogsm-kz-all-sms"
        );

        $message = preg_replace('/[\n\r\t\a\e]/u', '', $message);
        $message = trim($message);
        $message = str_replace(" ", "+", $message);

        $phone = $prefix . $phone;
        $params = "?type=sms". "&route=" . $gates[$prefix] . "&sender=".$sender."&receiver=". $phone  . "&msg=" .utf8_decode($message);

        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, "http://smsh06.moremr.com:82/tvt-push" . $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_exec ($curl);
        curl_close ($curl);
    }

    public function checkGifts($viewer_uid){

        $gift_sender = array();

        if($gift_count = Invites::model()->count("receiver_id=:receiver_id AND status=:status", array(":receiver_id"=>$viewer_uid, ":status"=>0))){
            return $gift_count;
        }
        else{
            return "0";
        }
    }

    public function removeGift($vid){

        $invites_number = 0;

        if($gift_counter = Invites::model()->count("receiver_id=:receiver_id AND status=:status", array(":receiver_id"=>$vid, ":status"=>0))){
            $gift = Invites::model()->find(array("order"=>"id ASC", "condition"=>"receiver_id=:receiver_id AND status=:status", "params"=>array(":receiver_id"=>$vid, ":status"=>0)));
            $gift->status = 1;
            $gift->save(false);
            return $gift_counter;
        }
        else{
            return "0";
        }
    }

    public function showData($data){
        echo $data;
    }
/////////////////////////////////////LIPTON PROMO/////////////////////////////////////////////////////////////////////////

}
