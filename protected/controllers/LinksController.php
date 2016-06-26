<?php


class LinksController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('save', 'check', 'invitePage','PromoSpotList', 'sendSMS', 'confirm', 'confirmPage', 'FB', 'VK'),
                'users'=>array('?'),
            ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Links;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Links']))
		{
			$model->attributes=$_POST['Links'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Links']))
		{
			$model->attributes=$_POST['Links'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Links');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Links('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Links']))
			$model->attributes=$_GET['Links'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionDownloads()
    {
        $model=new Downloads('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Downloads']))
            $model->attributes=$_GET['Downloads'];

        $this->render('downloads',array(
            'model'=>$model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Links the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Links::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}



    /**
     * Performs the AJAX validation.
     * @param Links $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='links-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }



////////////////////////////VK APPPPPPPP//////////////////////////////////////////////////////
    public function actionVK()
    {
        $this->layout = "//layouts/vkapp";
        $this->render("main");

        //$this->render("testpage");
    }

    public function actionInvitePage(){
        $this->layout = "//layouts/vkapp";
        $this->render("userinfo2");
    }

    public function actionSave(){
        if(isset($_POST["invite"])){

            $invite = new Invites();
            $invite_arr = explode("-", $_POST["invite"]);
            $invite->client_id = $invite_arr[0];
            $invite->receiver_id = $invite_arr[1];
            $invite->date = date("Y-m-d");
            $invite->save(false);
            /*
            $file = fopen('logs/invites.log', 'a');
            fwrite($file, date("Y-m-d") . "_" . $_POST["invite"] . "\n");
            fclose($file);*/
        }
    }

    public function actionCheck(){

        if(isset($_GET["uid"]) && isset($_GET["fuid"])){
            $invites_limit = 5;
            $invites_number = 0;
            $received_once = false;
            $viewer_uid = $_GET["uid"];
            $friend_uid = $_GET["fuid"];

            if($invite_count = Invites::model()->count("client_id=:client_id AND date=:date", array(":client_id"=>$viewer_uid, ":date"=>date("Y-m-d")))){
                if($receiver_count = Invites::model()->count("receiver_id=:client_id AND date=:date", array(":client_id"=>$friend_uid, ":date"=>date("Y-m-d")))){
                    echo "2";
                }
                else{
                    if($invite_count >= $invites_limit){
                        echo "0";
                    }
                    else{
                        echo "1";
                    }

                }
            }
            else{
                echo "1";
            }

        }
    }

    public function actionConfirmPage(){
        $this->layout = "//layouts/vkapp";
        $this->render("confirm");
    }

//    public function actionPromoSpotList(){
//
//        if(isset($_POST["city_id"])){
//            $city_id = $_POST["city_id"];
//            $result_str = "";
//            $promo_spots_arr = Yii::app()->params["promo_spot"][$city_id];
//            foreach($promo_spots_arr as $index=>$value){
//                $result_str .= "<option value='{$index}'>{$value}</options>";
//            }
//            echo  $result_str;
//        }
//        else{
//            echo "<option value=''>Промо точка не найдена</options>";
//        }
//    }

    public function actionPromoSpotList(){

        if(isset($_POST["city_id"])){
            $city_id = $_POST["city_id"];
            $promo_spot = Yii::app()->params["promo_spot"][$city_id];
            $result_str = "<option value='{$city_id}'>{$promo_spot}</options>";
            echo  $result_str;
        }
        else{
            echo "<option value=''>Промо точка не найдена</options>";
        }
    }

    public function actionConfirmed(){
        if(isset($_GET["gn"])){
            $this->layout = "//layouts/vkapp";
            $gifts_number = $_GET["gn"];
            $this->render("gift_dialog", array('model'=>$gifts_number));
        }

    }

    public function actionConfirm(){
        //$_GET["vid"] = "192335129";

        if(isset($_POST["vid"]) && isset($_POST["phone"]) && isset($_POST["city"]) && isset($_POST["promo_spot"]) && isset($_POST["uid"]) && isset($_POST["prefix"])){
            $vid = $_POST["vid"];
            $this->layout = "//layouts/vkapp";

            /*Removes gift and gets gifts number*/
            $gifts_number = Activations::model()->removeGift($vid);

            $phone_number  = str_replace("+", "", $_POST["prefix"]) . $_POST["phone"];
            $city_id  = $_POST["city"];
            $promo_spot  = $_POST["promo_spot"];
            $uid = $_POST["uid"];

            if(isset($_COOKIE[$phone_number])){

                if($_COOKIE[$phone_number] == $uid){

                    $activation = new Activations();
                    $activation->city_id= $city_id;
                    $activation->client_id= $vid;
                    $activation->promo_id= $promo_spot;
                    $activation->sercret_key = $uid;
                    $activation->date = date("Y-m-d H:i:s");
                    $activation->save(false);
                    //$this->render("gift_dialog");
                    echo $gifts_number;
                }
                else{
                    echo "0";
                }
            }
            else{
                echo "0";
            }
        }
        else{
            echo "0";
        }

        /*if(isset($_POST["phone"]) && isset($_POST["city"]) && isset($_POST["promo_spot"]) && isset($_POST["uid"]) && isset($_POST["prefix"])){



            $phone_number  = str_replace("+", "", $_POST["prefix"]) . $_POST["phone"];
            $city_id  = $_POST["city"];
            $promo_spot  = $_POST["promo_spot"];
            $uid = $_POST["uid"];

            if(isset($_COOKIE[$phone_number])){

                if($_COOKIE[$phone_number] == $uid){
                    $activation = new Activations();
                    $activation->city_id= $city_id;
                    $activation->promo_id= $promo_spot;
                    $activation->sercret_key = $uid;
                    $activation->date = date("Y-m-d H:i:s");
                    $activation->save(false);

                    $this->render("gift_dialog");
                }
            }

        }*/
    }

    public function actionSendSMS(){

        $send_status = 0;

        if(isset($_POST["phone"]) && isset($_POST["def"]) && isset($_POST["city"]) && isset($_POST['vid'])){
            if(preg_match_all("/^[0-9]{7}$/", $_POST["phone"])) {
                $queries_number = Queries::model()->count(array('condition'=>'client_id=:client_id AND date=:date', 'params'=>array(':client_id'=>$_POST['vid'], ':date'=>date("Y-m-d"))));

                if($queries_number < 2){
                    $phone_number  = $_POST["phone"];
                    $def  = str_replace("+", "", $_POST["def"]);
                    $city_id = $_POST["city"];
                    $promo_spot =  Yii::app()->params["promo_spot"][$city_id];
                    $uid = mb_substr(md5(date("Y-m-d H:i:s") . $def.$phone_number), 0, 5,  "utf-8");

                    $query = new Queries();
                    $query->phone = $def . $phone_number;
                    $query->client_id = $_POST['vid'];
                    $query->messages = "Kod:" . $uid .". Svoi priz Vy mozhete zabrat v '" . $promo_spot . "'";
                    $query->date = date("Y-m-d");
                    $query->save(false);

                    $timeout = Yii::app()->params["timeout2"];
                    setcookie($def.$phone_number,$uid,time()+$timeout);

                    Activations::sendSMS($query->messages, $phone_number, $def);
                    $send_status = 1;
                    echo "1";
                }
                else{
                    echo "2";
                }
            }
            else{
                echo "0";
            }
        }
        else{
            echo $send_status;
        }
    }
////////////////////////////////////FB//////////////////////////////////////////////////////////////

    public function actionFB()
    {
        $this->layout = "//layouts/fbapp";
        $this->render("main");

        //$this->render("testpage");
    }

}
