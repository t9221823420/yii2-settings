<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveForm;
use yozh\form\ActiveField;

$inputs = [];

foreach( ActiveField::getInputs() as $name => $item ) {
	$inputs[ $name ] = $item['label'];
}

$widgets = [];

if( $Model->type ) {
	foreach( ActiveField::getWidgets( $Model->type ) as $name => $item ) {
		$widgets[ $name ] = $item['label'];
	}
}

$fields = function( $form ) use ( $Model, $inputs, $widgets ) {
	
	/**
	 * @var ActiveForm $form
	 */
	return [
		
		'name' => $form->field( $Model, 'name' ),
		
		'type' => $form->field( $Model, 'type' )->dropDownList( $inputs, [
			'class'           => 'form-control yozh-widget yozh-widget-nested-select',
			'url'             => Url::to( [ 'get-widgets-list' ] ),
			'nested-selector' => '#' . Html::getInputId( $Model, 'widget' ),
			'prompt'          => Yii::t( 'app', 'Select' ),
		] ),
		
		'widget' => $form->field( $Model, 'widget' )->dropDownList( $widgets, [
			'class'  => 'form-control',
			'prompt' => Yii::t( 'app', 'Select' ),
		] ),
		
		'config' => $form->field( $Model, 'config' )->baseWidget( ActiveField::WIDGET_TYPE_TEXTAREA ),
		
		'data' => $form->field( $Model, 'data' )->baseWidget( $Model->widget ),
	
	];
};

?>

<div class="form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?php foreach( $fields( $form ) as $field ) {
		print $field;
	} ?>

    <div class="form-group">
		<?= Html::submitButton( Yii::t( 'app', 'Save' ), [ 'class' => 'btn btn-success' ] ) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>