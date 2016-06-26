<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php /** @var TbActiveForm $form */
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'horizontalForm',
            'type' => 'horizontal',
            'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'), // for inset effect
        )
    ); ?>



        <p class="note">Поля, обязательные к заполнению. <span class="required">*</span></p>

        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldGroup(
            $model,
            'username',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-7',
                ),
            )
        ); ?>
    <?php echo $form->textFieldGroup(
        $model,
        'password',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-7',
            ),

        )
    ); ?>

        <?php echo $form->textFieldGroup(
            $model,
            'email',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-7',
                ),
                'prepend'=>'@'
            )
        ); ?>

        <?php echo $form->textFieldGroup(
            $model,
            'name',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-7',
                ),
            )
        ); ?>

        <?php echo $form->textFieldGroup(
            $model,
            'surname',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-7',
                ),
            )
        ); ?>
    <?php echo $form->fileFieldGroup($model, 'images_url',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    ); ?>

    <div class="row buttons">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>($user->isNewRecord) ? 'Создать' : 'Сохранить',
        )); ?>

        <?php if($this->action->id=="create"){
        $this->widget(
            'booster.widgets.TbButton',
            array('buttonType' => 'reset', 'label' => 'Очистить')
        );

        }
        ?>

    </div>

<?php

$this->endWidget();
unset($form);

?>


</div><!-- form -->