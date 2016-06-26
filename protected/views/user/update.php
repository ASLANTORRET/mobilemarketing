<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
    array('label'=>'Создать пользователя', 'url'=>array('create'), ),
    array('label'=>'Все пользователи', 'url'=>array('index')),
    array('label'=>'Управление пользователями', 'url'=>array('admin'),),
    array('label'=>'Посмотреть на пользователя', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Редактировать пользователя', 'url'=>'#', 'itemOptions' => array('class' => 'active')),
);
?>

<h1>Редактировать пользователя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>