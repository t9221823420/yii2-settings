<?php

namespace yozh\settings;

class AssetBundle extends \yozh\base\AssetBundle
{

    public $sourcePath = __DIR__ .'/../assets/';

    public $css = [
        //'css/yozh-settings.css',
	    //['css/yozh-settings.print.css', 'media' => 'print'],
    ];
	
    public $js = [
        //'js/yozh-settings.js'
    ];
	
    public $depends = [
        //'yii\bootstrap\BootstrapAsset',
    ];

	public $publishOptions = [
		//'forceCopy'       => true,
	];
	
}