<?php
/**
 * P2AssetBase.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
 * @link https://github.com/p2made
 * @package p2made/yii2-p2y2-base
 * @license MIT
 */

/**
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 * ##### ^ ##### ^ #####                                           ##### ^ ##### ^ #####
 * ##### ^ ##### ^ #####      DO NOT USE THIS CLASS DIRECTLY!      ##### ^ ##### ^ #####
 * ##### ^ ##### ^ #####                                           ##### ^ ##### ^ #####
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
 */

/**
 * Load this asset with...
 * p2m\assets\base\P2AssetBase::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\base\P2AssetBase',
 */

namespace p2m\assets\base;

use p2m\base\helpers\Settings;

class P2AssetBase extends \yii\web\AssetBundle
{
	/*
	 * @var string
	 * private $_p2mPath;
	 */
	//private static $_p2mPath = '@vendor/p2made/yii2-p2y2-base/assets/lib';

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
	 * @var boolean
	 * private $_useStatic = false;
	 */
	private static $_useStatic;

	/*
	 * @var array | false
	 * private $_staticEnd = false;
	 */
	private static $_staticEnd;

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

		if(P2AssetBundle::useStatic() && isset($assetData['static'])) {
			$this->configureStaticAsset($assetData['static']);
		} elseif(isset($assetData['published'])) {
			$this->configurePublishedAsset($assetData['published']);
		} else {
			return;
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
		}

		if(isset($assetData['css'])) {
			$this->css = $assetData['css'];
		}
		if(isset($assetData['js'])) {
			$this->js = $assetData['js'];
		}
	}

	// ===== utility functions ===== //

	protected static function p2mPath()
	{
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
		if(isset($_useStatic)) {
			return $_useStatic;
		}

		$_useStatic = Settings::assetsUseStatic();

		return $_useStatic;
	}

	/**
	 * Get staticEnd setting - static application end
	 * @return array | false
	 * @default false
	 */
	protected static function staticEnd()
	{
		if(isset($_staticEnd)) {
			return $_staticEnd;
		}

		$_staticEnd = Settings::assetsStaticEnd();

		return $_staticEnd;
	}
}
