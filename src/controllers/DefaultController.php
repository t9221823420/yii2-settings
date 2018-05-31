<?php

namespace yozh\settings\controllers;

use Yii;
use yozh\form\ActiveField;
use yozh\settings\models\Settings;
use yozh\crud\controllers\DefaultController as Controller;

class DefaultController extends Controller
{
	public static function defaultModelClass()
	{
		return Settings::class;
	}
	
	public function actionTest()
	{
		$foo = Yii::$app->settings->get( 'foo', 'sdfgsdfg' );
		
		Yii::$app->settings->set( 'foo', 'chk' );
		
	}
	
	public function actionGetWidgetsList( $value )
	{
		$items = [];
		
		foreach( ActiveField::getWidgets( $value ) as $name => $item ) {
			$items[ $name ] = $item['label'];
		}
		
		return $this->_renderSelectItems( $items );
		
	}
}
