<?php

namespace yozh\settings;

use yozh\base\Module as BaseModule;

class Module extends BaseModule
{

	const MODULE_ID = 'settings';
	
	public $controllerNamespace = 'yozh\\' . self::MODULE_ID . '\controllers';
	
}
