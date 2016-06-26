<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
);

$this->menu=array(
    array('label'=>'Создать пользователя', 'url'=>'#', 'itemOptions' => array('class' => 'active')),
    array('label'=>'Все пользователи', 'url'=>array('index')),
    array('label'=>'Управление пользователями', 'url'=>array('admin'),)
);
?>

<legend><h1>Создать пользователя</h1></legend>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>