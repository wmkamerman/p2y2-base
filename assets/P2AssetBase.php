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
	 * Yii asset properties
	 *
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
	 * P2 asset data structure

	'assetName' => array(
		'version' => 'version',
		'sourcePath' => 'sourcePath',
		'baseUrl' => 'baseUrl',
		'css' => [
		],
		'js' => [
		],
		'cssOptions' => [
		],
		'jsOptions' => [
		],
		'depends' => [
		],
		'publishOptions' => [
		],
		'cssIntegrity' => [
			'published' => 'published-hash',
			'static' => 'static-hash',
		],
		'jsIntegrity' => [
			'published' => 'published-hash',
			'static' => 'static-hash',
		],
	),

	 */

	protected function setAssetProperties()
	{
		$data = $this->assetData; // just to shorten following code

		if(isset($data['version'])) {
			$this->version = $data['version'];
		}
		if(isset($data['css'])) {
			$this->css = $data['css'];
		}
		if(isset($data['js'])) {
			$this->js = $data['js'];
		}
		if(isset($data['cssOptions'])) {
			$this->cssOptions = $data['cssOptions'];
		}
		if(isset($data['jsOptions'])) {
			$this->jsOptions = $data['jsOptions'];
		}
		if(isset($data['depends'])) {
			$this->depends = $data['depends'];
		}
		if(isset($data['publishOptions'])) {
			$this->publishOptions = $data['publishOptions'];
		}

		if(isset($data['baseUrl']) && self::useStatic()) {
			$this->baseUrl = 'https://' . $data['baseUrl'];
			self::insertAssetVersion($this->baseUrl);
			$this->sourcePath = null;
			$this->insertIntegrity('static');
		} elseif(isset($data['sourcePath'])) {
			$this->sourcePath = $data['sourcePath'];
			self::insertAssetVersion($this->sourcePath);
			self::insertP2mPath($this->sourcePath);
			$this->baseUrl = null;
			$this->insertIntegrity('published');
		} else {
			return;
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

	protected function configureStaticAsset($assetData)
	{
		if(isset($assetData['baseUrl'])) {
			$this->baseUrl = $assetData['baseUrl'];
			self::insertAssetVersion($this->baseUrl);
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
			self::insertAssetVersion($this->sourcePath);
			self::insertP2mPath($this->sourcePath);
		}

		if(isset($assetData['css'])) {
			$this->css = $assetData['css'];
		}
		if(isset($assetData['js'])) {
			$this->js = $assetData['js'];
		}
	}

	// ===== utility functions ===== //

	protected static function insertAssetVersion(&$target)
	{
		if(isset($this->version)) {
			$target = str_replace('##-version-##', $this->version, $target);
		}
	}

	protected static function p2mPath()
	{
		if(isset(self::$_p2mPath)) {
			return self::$_p2mPath;
		}

		self::$_p2mPath = '@vendor/p2made/' . $this->_p2mProjectId . '/vendor';
		return self::$_p2mPath;
	}

	protected static function insertP2mPath(&$target)
	{
		$target = str_replace('@p2m@', self::p2mPath(), $target);
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
