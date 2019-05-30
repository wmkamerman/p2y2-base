<?php
/**
 * P2AssetBase.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
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

namespace p2m\base\assets;

use p2m\base\helpers\AssetsSettings;

/**
 * Load this asset with...
 * p2m\assets\base\P2AssetBase::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\base\P2AssetBase',
 */
class P2AssetBase extends \yii\web\AssetBundle
{
	/*
	 * @var string
	 * private $_p2mProjectId;
	 */
	protected $_p2mProjectId = 'yii2-p2y2-base';

	/*
	 * @var string
	 * protected $version;
	 */
	protected $version; // = '0.0.0'

	/*
	 * @var array
	 * protected $assetData;
	 */
	protected $assetData;

	/*
	 * @var string
	 * private static $_p2mPath;
	 */
	private static $_p2mPath;

	/*
	 * @var boolean
	 * private static $_useStatic = false;
	 */
	private static $_useStatic;

	/*
	 * @var array | false
	 * private static $_assetsEnd = false;
	 */
	private static $_assetsEnd;

	/*
	 * @var string | false
	 * private static $_bootswatch = false;
	 */
	private static $_bootswatch;

	/**
	 * @var string
	 * public $sourcePath;
	 *
	 * @var string
	 * public $baseUrl;
	 *
	 * @var array
	 * public $css = [];
	 *
	 * @var array
	 * public $cssOptions = [];
	 *
	 * @var array
	 * public $js = [];
	 *
	 * @var array
	 * public $jsOptions = [];
	 *
	 * @var array
	 * public $depends = [];
	 *
	 * @var array
	 * public $publishOptions = [];
	 */

/*
		'jqueryAsset' => array(
			'name' => 'jquery',
			'version' => '3.3.1',
			'published' => [
				'sourcePath' => '@p2m@/jquery',
				'js' => [
					'jquery-##-version-##.min.js',
				],
			],
			'static' => [
				'baseUrl' => 'https://code.jquery.com',
				'js' => [
					'jquery-##-version-##.min.js',
				],
				'jsIntegrity' => 'sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT',
				'crossorigin' => 'anonymous',
			],
		),

 */

	/*
	 * P2 asset data structure
	 *

	protected $version = '4.7.0';

	protected $resourceData = array(
		'static' => [
			'baseUrl' => 'baseUrl',
			'css' => [
				'css/cssfile.css',
			],
			'cssOptions' => [ // iff there are static specific cssOptions
				'integrity' => 'static-hash', // iff css has hash[s]
				'crossorigin' => 'anonymous', // iff css has hash[s]
			],
			'js' => [
				'js/jsfile.js', // or
			],
			'jsOptions' => [ // iff there are static specific jsOptions
				'integrity' => 'static-hash', // iff js has hash[s]
				'crossorigin' => 'anonymous', // iff js has hash[s]
			],
			'depends' => [ // iff there are static specific depends
			],
			'publishOptions' => [ // iff there are static specific publishOptions
			],
		],
		'published' => [
			'sourcePath' => 'sourcePath',
			'css' => [
				'css/cssfile.css', // or
			],
			'cssOptions' => [ // iff there are published specific cssOptions
				'integrity' => 'published-hash', // iff css has hash[s]
				'crossorigin' => 'anonymous',    // iff css has hash[s]
			],
			'js' => [
				'js/jsfile.js', // or
				['js/jsfile.js', 'integrity' => 'published-hash'],
			],
			'jsOptions' => [ // iff there are published specific jsOptions
				'integrity' => 'published-hash', // iff js has hash[s]
				'crossorigin' => 'anonymous',    // iff js has hash[s]
			],
			'depends' => [ // iff there are published specific depends
			],
			'publishOptions' => [ // iff there are published specific publishOptions
			],
		],
		'cssOptions' => [
		],
		'jsOptions' => [
		],
		'depends' => [
			'some\useful\ThingAsset',
		],
		'publishOptions' => [
		],
	);



		if(isset($data['baseUrl']) && self::useStatic()) {

			$this->baseUrl = 'https://' . $data['baseUrl'];
			$this->sourcePath = null;
			$this->insertIntegrity('static');
		} elseif(isset($data['sourcePath'])) {
			$this->sourcePath = $data['sourcePath'];
			self::insertP2mPath($this->sourcePath);
			$this->baseUrl = null;
			$this->insertIntegrity('published');
		} else {
			return;
		}
	}




	 *
	 */

	protected function configureAsset($assetData)
	{
		if(isset($assetData['cssOptions'])) {
			$this->cssOptions = $assetData['cssOptions'];
		}
		if(isset($assetData['jsOptions'])) {
			$this->jsOptions = $assetData['jsOptions'];
		}
		if(isset($assetData['depends'])) {
			$this->depends = $assetData['depends'];
		}
		if(isset($assetData['publishOptions'])) {
			$this->publishOptions = $assetData['publishOptions'];
		}

		if(self::useStatic() && isset($assetData['static'])) {
			$this->configureStaticAsset($assetData['static']);
		} elseif(isset($assetData['published'])) {
			$this->configurePublishedAsset($assetData['published']);
		}
	}

	protected function configureStaticAsset($assetData)
	{
		if(isset($assetData['baseUrl'])) {
			$this->baseUrl = $assetData['baseUrl'];
			$this->insertAssetVersion($this->baseUrl);
		}
		if(isset($assetData['css'])) {
			$this->css = $assetData['css'];
		}
		if(isset($assetData['js'])) {
			$this->js = $assetData['js'];
		}
	}

	protected function configurePublishedAsset($assetData)
	{
		if(isset($assetData['sourcePath'])) {
			$this->sourcePath = $assetData['sourcePath'];
			$this->insertAssetVersion($this->sourcePath);
			$this->insertP2mPath($this->sourcePath);
			//self::insertAssetVersion($this->sourcePath);
			//self::insertP2mPath($this->sourcePath);
		}

		if(isset($assetData['css'])) {
			$this->css = $assetData['css'];
		}
		if(isset($assetData['js'])) {
			$this->js = $assetData['js'];
		}
	}

	private function insertIntegrity($data, $mode = 'static')
	{
		if (isset($data['cssIntegrity'][$mode])) {
			$this->cssOptions = [
				'integrity' => $data['cssIntegrity'][$mode],
				'crossorigin' => 'anonymous',
			];
		}
		if (isset($data['jsIntegrity'][$mode])) {
			$this->jsOptions = [
				'integrity' => $data['jsIntegrity'][$mode],
				'crossorigin' => 'anonymous',
			];
		}
	}

	protected function configureAssetFromData($assetData)
	{
	}

	// ===== utility functions ===== //

	protected function p2mPath()
	{
		if(isset($this->_p2mPath)) {
			return $this->_p2mPath;
			//return self::$_p2mPath;
		}

		$this->_p2mPath = '@vendor/p2made/' . $this->_p2mProjectId . '/vendor';

		return $this->_p2mPath;
		//self::$_p2mPath = '@vendor/p2made/' . $this->_p2mProjectId . '/vendor';
		//return self::$_p2mPath;
	}

	protected function insertP2mPath(&$target)
	{
		$target = str_replace('@p2m@', $this->p2mPath(), $target);
		//$target = str_replace('@p2m@', self::p2mPath(), $target);
	}

	protected function insertAssetVersion(&$target)
	{
		if(isset($this->version)) {
			$target = str_replace('##-version-##', $this->version, $target);
		}
	}

	/**
	 * Get useStatic setting - use static resources
	 * @return boolean
	 * @default false
	 */
	protected static function useStatic()
	{
		if(isset(self::$_useStatic)) {
			return self::$_useStatic;
		}

		self::$_useStatic = AssetsSettings::assetsUseStatic();

		return self::$_useStatic;
	}

	/**
	 * Get assetsEnd setting - static application end
	 * @return array | false
	 * @default false
	 */
	protected static function assetsEnd()
	{
		if(isset($_assetsEnd)) {
			return $_assetsEnd;
		}

		$_assetsEnd = AssetsSettings::assetsassetsEnd();

		return $_assetsEnd;
	}

	/**
	 * Get bootswatch setting - use static resources
	 * @return boolean
	 * @default false
	 */
	protected static function bootswatch()
	{
		if(isset(self::$_bootswatch)) {
			return self::$_bootswatch;
		}

		self::$_bootswatch = AssetsSettings::bootswatchTheme();
		return self::$_bootswatch;
	}
}



