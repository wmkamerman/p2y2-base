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
	 * protected $assetName;
	 */
	protected $assetName;

	/*
	 * @var string
	 * protected $version;
	 */
	protected $version; // = '0.0.0'

	/*
	 * @var array
	 * protected $resourceData;
	 */
	protected $resourceData = [];

	/*
	 * @var string
	 * private $_p2mPath;
	 */
	private $_p2mPath;

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
	 * P2 asset data structure
	 *

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
			//'cssIntegrity' => [
			//	'static-hash',
			//],
			'js' => [
				'js/jsfile.js', // or
			],
			'jsOptions' => [ // iff there are static specific jsOptions
				'integrity' => 'static-hash', // iff js has hash[s]
				'crossorigin' => 'anonymous', // iff js has hash[s]
			],
			//'jsIntegrity' => [
			//	'static-hash',
			//],
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
			//'cssIntegrity' => [
			//	'published-hash',
			//],
			'js' => [
				'js/jsfile.js', // or
			],
			'jsOptions' => [ // iff there are published specific jsOptions
				'integrity' => 'published-hash', // iff js has hash[s]
				'crossorigin' => 'anonymous',    // iff js has hash[s]
			],
			//'jsIntegrity' => [
			//	'published-hash',
			//],
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

	 *
	 */

	protected function configureAsset($assetData)
	{
		$this->configureAssetOptions($assetData);

		if(self::useStatic() && isset($assetData['static'])) {
			//$this->configureStaticAsset($assetData['static']);
			$assetData = $assetData['static'];

			if(isset($assetData['baseUrl'])) {
				$this->baseUrl = $assetData['baseUrl'];
				$this->insertAssetVersion($this->baseUrl);
			}
		}
		elseif(isset($assetData['published'])) {
			//$this->configurePublishedAsset($assetData['published']);
			$assetData = $assetData['published'];

			if(isset($assetData['sourcePath'])) {
				$this->sourcePath = $assetData['sourcePath'];
				$this->insertAssetVersion($this->sourcePath);
				$this->insertP2mPath($this->sourcePath);
			}
		}

		if(isset($assetData['css'])) {
			$this->css = $assetData['css'];
		}
		if(isset($assetData['js'])) {
			$this->js = $assetData['js'];
		}

		$this->configureAssetOptions($assetData);
	}

	protected function configureAssetOptions($assetData)
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
	}

	// ===== utility functions ===== //

	protected function p2mPath()
	{
		if(isset($this->_p2mPath)) {
			return $this->_p2mPath;
		}

		$this->_p2mPath = '@vendor/p2made/' . $this->_p2mProjectId . '/vendor';

		return $this->_p2mPath;
	}

	protected function insertP2mPath(&$target)
	{
		$target = str_replace('@p2m@', $this->p2mPath(), $target);
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
}
