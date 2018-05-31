<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 11.03.2018
 * Time: 22:00
 */

namespace yozh\settings\models;

use yozh\crud\models\BaseModel as ActiveRecord;
use yozh\form\ActiveField;
use yozh\widget\BaseWidget as Widget;

class Settings extends ActiveRecord
{
	public static function tableName()
	{
		return 'settings';
	}
	
	public function rules()
	{
		
		return [
			[ [ 'name', ], 'required' ],
			[ [ 'name' ], 'string', 'max' => 255 ],
			[ [ 'name' ], 'filter', 'filter' => 'trim' ],
			[ [ 'name' ], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process' ],
			[ [ 'name' ], 'unique', 'targetClass' => static::class ],
			
			[ 'type', 'default', 'value' => ActiveField::DEFAULT_INPUT_TYPE ],
			[ 'widget', 'default', 'value' => ActiveField::DEFAULT_WIDGET_TYPE ],
			
			[ [ 'type' ], 'in', 'range' => ActiveField::getConstants( 'INPUT_TYPE_' ) ],
			[ [ 'widget' ], 'in', 'range' => ActiveField::getConstants( 'WIDGET_TYPE_' ) ],
			
			[ [ 'config', 'data', ], function( $attribute ) {
				
				$result = json_decode( \yii\helpers\Json::encode( $this->$attribute ), true );
				
				if( json_last_error() ) {
					$this->addError( 'chain', \Yii::t( 'app', "Invalid or malformed data for JSON" ) );
				}
			} ],
		
		];
	}
	
	public function attributeIndexList()
	{
		$attributes = [ 'name', 'data' ];
		
		return array_combine( $attributes, $attributes );
	}
	
}