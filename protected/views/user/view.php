<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	$model->username,
);

$this->menu=array(
    array('label'=>'Создать пользователя', 'url'=>array('create'), ),
    array('label'=>'Все пользователи', 'url'=>array('index')),
    array('label'=>'Управление пользователями', 'url'=>array('admin'),),
    array('label'=>'Посмотреть на пользователя', 'url'=>'#', 'itemOptions' => array('class' => 'active')),
    array('label'=>'Редактировать пользователя', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Удалить пользователя', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить данный элемент?'),'visible'=>Yii::app()->user->name!='admin'),
);
?>

<h2><?php echo $model->username; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
		'name',
		'surname',
	),
)); ?>
