<?php

use yii\helpers\Html;
use yii\helpers\Inflector;

if( !isset( $Model ) && isset( $ModelSearch ) ) {
	$Model = $ModelSearch;
}

$_params_['actionId']    = $actionId = $this->context->action->id;
$_params_['actionTitle'] = $actionTitle = Yii::t( 'app', Inflector::camel2words( $this->context->action->id ) );

$_params_['modelId'] = $modelId = Inflector::camel2id( ( new\ReflectionObject( $Model ) )->getShortName() );

$modelTitle = Yii::t( 'app', Inflector::camel2words( ( new\ReflectionObject( $Model ) )->getShortName() ) );

$modelTitle = trim( preg_replace( '/(Search|)/', '', $modelTitle ) );

$_params_['modelTitle'] = $modelTitle;

if( isset($ModelSearch) && Yii::$app->request->get( $ModelSearch->formName() ) ){
	$this->title = Yii::t( 'app', 'Search result') . ": $modelTitle";
}
else{
	$this->title = "$actionTitle: $modelTitle";
}

$this->params['breadcrumbs'][] = [ 'label' => $modelTitle, 'url' => [ 'index' ] ];
//$this->params['breadcrumbs'][] = $actionTitle;

?>