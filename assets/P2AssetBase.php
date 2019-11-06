<?php
/**
 * P2AssetBase.php
 *
 * @author Pedro Plowman
 * @copyright Copyright &copy; Pedro Plowman, 2019
 * @link https://github.com/p2made
 * @license MIT
 *
 * @package p2made/yii2-p2y2-base
 * @class \p2m\base\assets\P2AssetBase
 */

/**
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 * ##### ^ #####                                           ##### ^ #####
 * ##### ^ #####      DO NOT USE THIS CLASS DIRECTLY!      ##### ^ #####
 * ##### ^ #####                                           ##### ^ #####
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 */

/**
 * Load this asset with...
 * p2m\assets\base\P2AssetBase::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\base\P2AssetBase',
 */

namespace p2m\base\assets;

use p2m\base\helpers\P2AssetsSettings as Settings;

class P2AssetBase extends \yii\web\AssetBundle
{
	// ##### ^ ##### ^ P2M Asset Properties ^ ##### ^ #####

	/*
	 * @var string
	 * private $_p2mProjectId;
	 */
	protected $_p2mProjectId = 'yii2-p2y2-base';

	/*
	 * @var string
	 * protected $packageName;
	 * The simple name of the package that the asset is built on
	 */
	protected $packageName;

	/*
	 * @var string
	 * protected $packageVersion;
	 */
	protected $packageVersion; // = '0.0.0'

	/*
	 * @var array
	 * protected $packageData;
	 */
	protected $packageData = [];

	// ##### ^ ##### ^ P2 asset data structure ^ ##### ^ #####

	/*
	 *

	protected $packageData = [
		'baseUrl' => 'baseUrl',
		'sourcePath' => 'sourcePath',
		'static' => [
			'css' => [
				'css/cssfile.css',
				[
					'css/cssfile.css'
					'integrity' => 'static-hash', // iff css has hash[s]
					'crossorigin' => 'anonymous', // iff css has hash[s]
				],
			],
			'cssOptions' => [
				'integrity' => 'static-hash', // iff css has hash[s]
				'crossorigin' => 'anonymous', // iff css has hash[s]
			],
			'js' => [
				'js/jsfile.js',
				[
					'js/jsfile.js'
					'integrity' => 'static-hash', // iff js has hash[s]
					'crossorigin' => 'anonymous', // iff js has hash[s]
				],
			],
			'jsOptions' => [
				'integrity' => 'static-hash', // iff js has hash[s]
				'crossorigin' => 'anonymous', // iff js has hash[s]
			],
			'publishOptions' => [
			],
		],
		'published' => [
			'css' => [
				'css/cssfile.css',
			],
			'cssOptions' => [
			],
			'js' => [
				'js/jsfile.js',
			],
			'jsOptions' => [
			],
			'publishOptions' => [
			],
		],
		'css' => [
			'css/cssfile.css',
		],
		'cssOptions' => [
		],
		'js' => [
			'js/jsfile.js',
		],
		'jsOptions' => [
		],
		'publishOptions' => [
		],
		'depends' => [
			'some\useful\ThingAsset',
		],
	];

	 *
	 */

	// ##### ^ ##### ^ Private Properties ^ ##### ^ #####

	/*
	 * @var boolean
	 * private $_useStatic = false;
	 */
	private static $_useStatic;

	/*
	 * @var array | false
	 * private $_assetsEnd = false;
	 */
	private static $_assetsEnd;

	/*
	 * @var bool | false
	 * private $_assetsEnd = false;
	 */
	private static $_aliasSet = false;

	/*
	 * @var string
	 * private $_version;
	 */
	private $_version; // = '0.0.0'

	// ##### ^ ##### ^ Yii Asset VariaPropertiesles ^ ##### ^ #####

	/**
	 * @var string
	 * public $baseUrl;
	 *
	 * @var string
	 * public $sourcePath;
	 *
	 * @var array
	 * public $css = [];
	 *
	 * @var array
	 * public $js = [];
	 *
	 * @var array
	 * public $cssOptions = [];
	 *
	 * @var array
	 * public $jsOptions = [];
	 *
	 * @var array
	 * public $publishOptions = [];
	 *
	 * @var array
	 * public $depends = [];
	 */

	protected function configureAsset($data)
	{
		$insertVersion = function($source) {
			if(isset($this->packageVersion))
				return str_replace('##-version-##', $this->packageVersion, $source);
			return $source;
		};

		/*
		 * For easier access to p2m stuff we give it an alias
		 * but only if it hasn't already been set.
		 * the 2nd asset & after need different names.
		 */
		//self::setP2mAlias();
		if(!self::$_aliasSet) {
			\Yii::setAlias('@p2m',      '@vendor/p2made');
			\Yii::setAlias('@jsdelivr', 'https://cdn.jsdelivr.net/npm');
			\Yii::setAlias('@cdnjs',    'https://cdnjs.cloudflare.com/ajax/libs');
			self::$_aliasSet = true;
		}

		if(self::useStatic()) {
			$branch = 'static';
			if(isset($data['baseUrl']))
				$this->baseUrl = $insertVersion($data['baseUrl']);
		}
		else {
			$branch = 'published';
			if(isset($data['sourcePath']))
				$this->sourcePath = $insertVersion($data['sourcePath']);
		}

		if(isset($data[$branch])) {
			$branchData = $data[$branch];
			$dataTemp = $data;
			$data = array_merge($dataTemp, $branchData);
		}

		$yiiAttributes = [
			'css', 'cssOptions', 'js', 'jsOptions', 'publishOptions', 'depends'
		];

		foreach($yiiAttributes as $attribute) {
			if(isset($data[$attribute]))
				$this->{$attribute} = $data[$attribute];
		}
	}

	// ===== utility functions ===== //

	/**
	 * Get useStatic setting - use static resources
	 * @return boolean
	 * @default false
	 */
	protected static function useStatic()
	{
		if(isset(self::$_useStatic))
			return self::$_useStatic;

		self::$_useStatic = Settings::assetsUseStatic();

		return self::$_useStatic;
	}

	/**
	 * Get assetsEnd setting - static application end
	 * @return array | false
	 * @default false
	 */
	protected static function assetsEnd()
	{
		if(isset($_assetsEnd))
			return $_assetsEnd;

		$_assetsEnd = Settings::assetsassetsEnd();

		return $_assetsEnd;
	}
}

	/*
	protected function __construct($bypass = false, $config = [])
	{

		if($bypass) return;

		$data = $this->packageData;


		parent::__construct();
	}
	*/
