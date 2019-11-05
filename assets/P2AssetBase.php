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

// ##### ^ ##### ^ P2 asset data structure ^ ##### ^ #####

/*
 *

 *
 */

	protected $packageData = [
			'baseUrl' => 'baseUrl',
			'sourcePath' => 'sourcePath',
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
			'publishOptions' => [
			],
		'depends' => [
			'some\useful\ThingAsset',
		],
	];


	protected $packageData = [
		'baseUrl' => 'https://cdn.jsdelivr.net/npm/bootstrap@##-version-##/dist',
		'sourcePath' => '@npm/bootstrap/dist',
		'css' => [
			'css/bootstrap.min.css',
		],
		'js' => [
			'js/bootstrap.min.js',
		],
		'static' => [
			'cssOptions' => [
				'integrity' => 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T',
				'crossorigin' => 'anonymous',
			],
			'jsOptions' => [
				'integrity' => 'sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM',
				'crossorigin' => 'anonymous',
			],
		],
		'depends' => [
			'p2m\assets\base\P2YiiAsset',
		],
	];





namespace p2m\base\assets;

use p2m\base\helpers\P2AssetsSettings as Settings;

class P2AssetBase extends \yii\web\AssetBundle
{
// ##### ^ ##### ^ P2M Asset Variables ^ ##### ^ #####
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

// ##### ^ ##### ^ Private Variables ^ ##### ^ #####

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

// ##### ^ ##### ^ Yii Asset Variables ^ ##### ^ #####

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

	/*
	protected function __construct($bypass = false, $config = [])
	{

		if($bypass) return;

		$data = $this->packageData;


		parent::__construct();
	}
	*/

	protected function configureAsset($assetData)
	{
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

		$this->configureAssetOptions($data);

		if(self::useStatic() && isset($data['static'])) {
			if(isset($data['baseUrl'])) {
				$this->baseUrl = $data['baseUrl'];
				$this->insertAssetVersion($this->baseUrl);
			}
		}
		elseif(isset($data['published'])) {
			if(isset($data['sourcePath'])) {
				$this->sourcePath = $data['sourcePath'];
				$this->insertAssetVersion($this->sourcePath);
			}
		}

		if(isset($data['css']))
			$this->css = $assedataData['css'];
		if(isset($data['js']))
			$this->js = $data['js'];

		$this->configureAssetOptions($data);
	}

	protected function configureAssetOptions($data)
	{
		if(isset($data['cssOptions']))
			$this->cssOptions = $data['cssOptions'];
		if(isset($data['jsOptions']))
			$this->jsOptions = $data['jsOptions'];
		if(isset($data['publishOptions']))
			$this->publishOptions = $data['publishOptions'];
		if(isset($data['depends']))
			$this->depends = $data['depends'];
	}

	// ===== utility functions ===== //

	protected function insertAssetVersion(&$target)
	{
		if(isset($this->version))
			$target = str_replace('##-version-##', $this->version, $target);
	}

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
