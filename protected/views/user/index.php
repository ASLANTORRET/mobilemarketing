<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Пользователи',
);

$this->menu=array(
    array('label'=>'Создать пользователя', 'url'=>array('create')),
    array('label'=>'Все пользователи', 'url'=>'#', 'itemOptions' => array('class' => 'active')),
    array('label'=>'Управление пользователями', 'url'=>array('admin'),)
);
?>

<h1>Все пользователи</h1>

<?php

$this->widget(
    'booster.widgets.TbGridView',
    array(
        'type' => 'striped',
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'name' => 'username',
                'value' => 'CHtml::link(CHtml::encode($data->username), Yii::app()->controller->createUrl("view", array("id" => $data->id)))',
                'type' => 'html',
            ),
            'email',
            'name',
            'surname',
        )
    ));
?>

