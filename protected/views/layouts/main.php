<?php /* @var $this Controller*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<div class="container" id="content">

    <div>
        <?php
        $this->widget(
            'booster.widgets.TbNavbar',
            array(
                'brand' => 'AndroidPortal',
                'fixed' => true,
                'fluid' => true,
                'items' => array(
                    array(
                        'class' => 'booster.widgets.TbMenu',
                        'type' => 'navbar',
                        'items' => array(
                                    array('label' => 'Категории',
                                        'items' => array(
                                            array('label'=>'Создать категорию', 'url' => array('/categories/create')),
                                            array('label'=> 'Панель категорий', 'url' => array('/categories/admin')),
                                        )),

                                    array('label' => 'Игры',
                                        'items' => array(
                                            array('label'=>'Создать игру', 'url' => array('/games/create')),
                                            array('label'=> 'Панель игр', 'url' => array('/games/admin')),
                                        )),
                            array('label' => 'Ссылки',
                                'url' => array('links/admin')
                                 ),

                            array('label' => 'Активации',
                                'url' => array('activations/admin')
                            ),

                            array('label' => 'Скачивания',
                                'url' => array('links/downloads')
                                ),
                                    array('label' => 'Авторизоваться', 'url' => array('/user/index'),'visible'=>Yii::app()->user->isGuest),
                                    array('label' => 'Выйти ('.Yii::app()->user->name.')', 'url' => array('/site/logout'),'visible'=>!Yii::app()->user->isGuest)
                                )
                    )
                )
            )
        );
        ?>
    </div>

    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    <?php echo $content; ?>
    <?php
    ?>
    <div class="clear"></div>

    <div id="footer">
         <br> &copy; <?php echo date('Y'); ?> AndroidPortal.<br/>

    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
