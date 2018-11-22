<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveForm;
use yozh\form\ActiveField;
use yozh\base\components\helpers\Inflector;
use yozh\settings\models\Settings;

$inputs = [];

foreach( ActiveField::getInputs() as $name => $item ) {
	$inputs[ $name ] = $item['label'];
}

$widgets = [];

foreach( ActiveField::getWidgets( $Model->input_type ) as $name => $item ) {
	$widgets[ $name ] = $item['label'];
}

$fields = function( ActiveForm $form ) use ( $Model, $inputs, $widgets ) {
	
	$typeList = Settings::getConstants( 'TYPE', true );
	
	/**
	 * @var ActiveForm $form
	 */
	return [
		
		'name' => $Model->isNewRecord || !in_array( $Model->type, [
			Settings::TYPE_SYSTEM,
		] )
			? $form->field( $Model, 'name' )
			: $form->field( $Model, 'name' )->static()
		,
		
		'type' => $Model->isNewRecord || !in_array( $Model->type, [
			Settings::TYPE_SYSTEM,
		] )
			? $form->field( $Model, 'type' )->dropDownList( $typeList )
			: $form->field( $Model, 'type' )->static()
		,
		
		'input_type' => $form->field( $Model, 'input_type' )->dropDownList( $inputs, [
			'class'           => 'form-control yozh-widget yozh-widget-nested-select',
			'data-url'             => Url::to( [ 'get-widgets-list' ] ),
			'data-selector' => '#' . Html::getInputId( $Model, 'input_widget' ),
			'prompt'          => Yii::t( 'app', 'Select' ),
		] ),
		
		'input_widget' => $form->field( $Model, 'input_widget' )->dropDownList( $widgets, [
			'class'  => 'form-control',
			'prompt' => Yii::t( 'app', 'Select' ),
		] ),
		
		'config' => $form->field( $Model, 'config' )->baseWidget( ActiveField::WIDGET_TYPE_TEXTAREA ),
		
		'data' => $form->field( $Model, 'data' )->baseWidget( $Model->input_widget ),
	
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