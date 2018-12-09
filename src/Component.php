<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 29.05.2018
 * Time: 20:14
 */

namespace yozh\settings;

use yozh\settings\models\Settings as Model;

class Component  extends \yozh\base\components\Component
{
	public function get( $name, $default = null )
	{
		if ( $Settings = Model::findOne( ['name' => $name]) ){
			return $Settings->data;
		}
		elseif( defined($name) ){
			return constant( $name );
		}
		elseif( !is_null($default) ){
			return $default;
		}
		
	}
	
	public function set( $name, $data )
	{
		if ( !$Settings = Model::findOne( ['name' => $name]) ){
			$Settings = new Model;
		}
		
		$Settings->data = $data;
		
		$Settings->save();
		
	}
	
}