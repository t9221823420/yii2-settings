<?php

use yozh\base\components\db\Migration;
use yozh\base\components\db\Schema;
use yozh\form\ActiveField;

/**
 * Class m180305_040759_tablename_table_dev
 */
class m000000_000001_settings_table_dev extends Migration
{
	protected static $_table = 'settings';
	
	/**
	 * {@inheritdoc}
	 */
	public function safeUp( $params = [] )
	{
		parent::safeUp( [
			'mode' => 1 ? self::ALTER_MODE_UPDATE : self::ALTER_MODE_IGNORE,
		] );
		
	}
	
	public function getColumns( $columns = [] )
	{
		
		return parent::getColumns( [
			
			'name'   => $this->string(),
			'type'   => $this->enum( ActiveField::getConstants( 'INPUT_TYPE_' ) )
			                 ->notNull()->defaultValue( ActiveField::DEFAULT_INPUT_TYPE ),
			'widget' => $this->enum( ActiveField::getConstants( 'WIDGET_TYPE_' ) )
			                 ->notNull()->defaultValue( ActiveField::DEFAULT_WIDGET_TYPE ),
			'config' => $this->json(),
			'data'   => $this->json(),
		
		] );
	}
	
	
}
