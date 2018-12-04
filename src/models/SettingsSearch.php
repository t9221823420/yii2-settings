<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 29.05.2018
 * Time: 21:25
 */

namespace yozh\settings\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yozh\base\interfaces\models\ActiveRecordSearchInterface;

class SettingsSearch extends Settings implements ActiveRecordSearchInterface
{
	public $filter_search;
	
	public function rules( $rules = [], $update = false )
	{
		static $_rules;
		
		if( !$_rules || $update ) {
			
			$_rules = parent::rules( \yozh\base\components\validators\Validator::merge( [
				
				[ [ 'filter_search', ], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process' ],
			
			], $rules ) );
			
		}
		
		return $_rules;
		
	}
	
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}
	
	/**
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search( $params )
	{
		/**
		 * @var $query ActiveQuery
		 */
		$query = parent::find()
			//->from( self::tableName() . ' selfAlias' )
			//->joinWith( 'relation relationAlias' )
		;
		
		$dataProvider = new ActiveDataProvider( [
			'query' => $query,
			'sort'  => [ 'defaultOrder' => [ 'id' => SORT_DESC ] ],
		] );
		
		/*
		$dataProvider->pagination = [
			'pageSize' => 3,
		];
		*/
		
		if( !( $this->load( $params ) && $this->validate() ) ) {
			return $dataProvider;
		}
		
		$query->andFilterWhere( [ 'or',
			[ 'like', 'name', $this->filter_search ],
		] );
		
		return $dataProvider;
	}
}