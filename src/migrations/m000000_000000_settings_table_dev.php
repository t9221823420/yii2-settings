<?php

use yozh\base\components\db\Migration;
use yozh\base\components\db\Schema;
use yozh\form\ActiveField;
use yozh\settings\models\Settings;

/**
 * Class m180305_040759_tablename_table_dev
 */
class m000000_000000_settings_table_dev extends Migration
{
	protected static $_table;
	
	public function __construct( array $config = [] ) {
		
		static::$_table = static::$_table ?? Settings::getRawTableName();
		
		parent::__construct( $config );
		
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function safeUp( $params = [] )
	{
		return parent::safeUp( $params );
		
	}
	
	public function getColumns( $columns = [] )
	{
		
		return parent::getColumns( [
			
			'name'         => $this->string(),
			'type'         => $this->enum( Settings::getConstants( 'TYPE_' ) )
			                       ->notNull()->defaultValue( Settings::DEFAULT_TYPE ),
			'input_type'   => $this->enum( ActiveField::getConstants( 'INPUT_TYPE_' ) )
			                       ->notNull()->defaultValue( ActiveField::DEFAULT_INPUT_TYPE ),
			'input_widget' => $this->enum( ActiveField::getConstants( 'WIDGET_TYPE_' ) )
			                       ->notNull()->defaultValue( ActiveField::DEFAULT_WIDGET_TYPE ),
			'config'       => $this->json(),
			'data'         => $this->json(),
		
		] );
	}
	
	
}
