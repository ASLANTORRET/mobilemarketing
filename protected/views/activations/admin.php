<?php
/* @var $this ActivationsController */
/* @var $model Activations */

$this->breadcrumbs=array(
    'Панель активаций',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#treeDSTK-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Панель активаций</h1>

<?php

$this->widget(
    'booster.widgets.TbGridView',
    array(
        'type' => 'striped',
        'dataProvider' => $model->search(),
        'filter' =>$model,
        'columns' => array(
            array(
                'name'=>'id',
                'htmlOptions' => array('style' => 'width: 60px')
            ),
            'client_id',
            array(
                'name'=>'city_id',
                'value'=>'Yii::app()->params["cities_int"][$data->city_id]',
                'filter'=>CHtml::dropDownList('Activations[city_id]', $model->city_id, Yii::app()->params['cities_int']),
            ),
            array(
                'name'=>'promo_id',
                'value'=>'Yii::app()->params["promo_spot"][$data->city_id][$data->promo_id]',
                'filter'=>'',
            ),
            'sercret_key',
            'date',
            array(
                'name'=>'date_from',
                'header'=>'Время с...',
                'htmlOptions' => array('style' => 'width: 130px')
            ),
            array(
                'name'=>'date_to',
                'header'=>'Время до ...',
                'htmlOptions' => array('style' => 'width: 130px')
            )
        ),
        'summaryText'=>'Итого: <b>{count}</b>',
    ));
?>


