<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveForm;
use yozh\form\ActiveField;
use yozh\base\components\helpers\Inflector;
use yozh\settings\models\Settings;
use yii\base\Model;

$inputs = [];

foreach( ActiveField::getInputs() as $name => $item ) {
	$inputs[ $name ] = $item['label'];
}

$widgets = [];

foreach( ActiveField::getWidgets( $Model->input_type ) as $name => $item ) {
	$widgets[ $name ] = $item['label'];
}

$fields = $fields ?? [];

$fields = function( ActiveForm $form, Model $Model, ?array $attributes = [], ?array $params = [] ) use ( $fields, $inputs, $widgets ) {
	
	if( $fields instanceof Closure ) {
		$fields = $fields( $form, $Model );
	}
	
	$typeList = Settings::getConstants( 'TYPE', true );
	
	/**
	 * @var ActiveForm $form
	 */
	
	$fields['name'] = $Model->isNewRecord || !in_array( $Model->type, [ Settings::TYPE_SYSTEM, ] )
		? $form->field( $Model, 'name' )
		: $form->field( $Model, 'name' )->static();
	
	$fields['type'] = $Model->isNewRecord || !in_array( $Model->type, [ Settings::TYPE_SYSTEM, ] )
		? $form->field( $Model, 'type' )->dropDownList( $typeList )
		: $form->field( $Model, 'type' )->static();
	
	/* на будущее
	$fields['input_type'] = $form->field( $Model, 'input_type' )->dropDownList( $inputs, [
		'class'         => 'form-control yozh-widget yozh-widget-nested-select',
		'data-url'      => Url::to( [ 'get-widgets-list' ] ),
		'data-selector' => '#' . Html::getInputId( $Model, 'input_widget' ),
		'prompt'        => Yii::t( 'app', 'Select' ),
	] )
	;
	
	$fields['input_widget'] = $form->field( $Model, 'input_widget' )->dropDownList( $widgets, [
		'class'  => 'form-control',
		'prompt' => Yii::t( 'app', 'Select' ),
	] )
	;
	
	$fields['config'] = $form->field( $Model, 'config' )->baseWidget( ActiveField::WIDGET_TYPE_TEXTAREA );
	*/
	
	$fields['data'] = $form->field( $Model, 'data' )->baseWidget( $Model->input_widget );
	
	return $fields;
	
};

include( Yii::getAlias( $parentViewPath . '/' . basename( __FILE__ ) ) );