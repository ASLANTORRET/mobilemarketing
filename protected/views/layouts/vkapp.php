<?php $base_url = Yii::app()->request->baseUrl;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="stylesheet" href="<?=$base_url;?>/css/vkapp.css">
    <script src="http://vkontakte.ru/js/api/xd_connection.js?2" type="text/javascript"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>


    <?php echo $content; ?>

</html>