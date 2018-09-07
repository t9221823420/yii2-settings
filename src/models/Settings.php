<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 11.03.2018
 * Time: 22:00
 */

namespace yozh\settings\models;

use yozh\base\components\validators\ReadOnlyValidator;
use yozh\crud\models\BaseModel as ActiveRecord;
use yozh\form\ActiveField;
use yozh\widget\widgets\BaseWidget as Widget;

class Settings extends ActiveRecord
{
	const TYPE_CUSTOM = 'custom';
	const TYPE_SYSTEM = 'system';
	
	const DEFAULT_TYPE = self::TYPE_CUSTOM;
	
	public static function tableName()
	{
		return '{{%yozh_settings}}';
	}
	
	/*
	public function readOnlyAttributes( ?array $attributes = [] ): array
	{
		return parent::readOnlyAttributes( [
			'type',
		] );
	}
	*/
	
	public static function addSystemParam( $name, $data, $config = null, $input_type = null, $input_widget = null )
	{
		$attributes = [
			'type'         => static::TYPE_SYSTEM,
			'data'         => $data,
			'config'       => $config,
			'input_type'   => $input_type,
			'input_widget' => $input_widget,
		];
		
		if( $Settings = static::findOne( [ 'name' => $name ] ) ) {
			
			if( $Settings->type != static::TYPE_SYSTEM )
			{
				throw new \yii\base\InvalidParamException( "Settings '{$Settings->name}' is not system type." );
			}
			
			$Settings->setAttributes( $attributes )->save();
		}
		else{
			
			$attributes['name'] = $name;
			
			(new Settings($attributes))->save();
		}
		
	}
	
	public function rules()
	{
		
		return [
			[ [ 'name', 'type', 'data', ], 'required', 'except' => static::SCENARIO_FILTER ],
			
			[ [ 'name', 'type', ], ReadOnlyValidator::class, 'when' => function( $Model ) {
				return in_array( $Model->getOldAttribute( 'type' ), [
					static::TYPE_SYSTEM,
				] );
			} ],
			
			[ [ 'name', ], 'string', 'max' => 255 ],
			[ [ 'name', ], 'filter', 'filter' => 'trim' ],
			[ [ 'name', ], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process' ],
			[ [ 'name', ], 'unique', 'targetClass' => static::class ],
			
			[ [ 'type', ], 'default', 'value' => Settings::DEFAULT_TYPE ],
			[ [ 'type', ], 'in', 'range' => Settings::getConstants( 'TYPE_' ) ],
			
			[ 'input_type', 'default', 'value' => ActiveField::DEFAULT_INPUT_TYPE ],
			[ 'input_widget', 'default', 'value' => ActiveField::DEFAULT_WIDGET_TYPE ],
			
			[ [ 'input_type' ], 'in', 'range' => ActiveField::getConstants( 'INPUT_TYPE_' ) ],
			[ [ 'input_widget' ], 'in', 'range' => ActiveField::getConstants( 'WIDGET_TYPE_' ) ],
			
			[ [ 'config', 'data', ], function( $attribute ) {
				
				$result = json_decode( \yii\helpers\Json::encode( $this->$attribute ), true );
				
				if( json_last_error() ) {
					$this->addError( 'chain', \Yii::t( 'app', "Invalid or malformed data for JSON" ) );
				}
			} ],
		
		];
	}
	
	public function attributesIndexList( ?array $only = null, ?array $except = null, ?bool $schemaOnly = false )
	{
		$attributes = [
			'name',
			'data',
			'type',
		];
		
		return array_combine( $attributes, $attributes );
	}
	
}