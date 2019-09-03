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

use p2m\base\helpers\P2AssetsSettings;

/**
 * Load this asset with...
 * p2m\assets\base\P2AssetBase::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\base\P2AssetBase',
 */
class P2AssetBase extends \yii\web\AssetBundle
{
// ##### ^ ##### ^ P2M Asset Variables ^ ##### ^ #####

	/*
	 * @var string
	 * protected $assetName;
	 * The simple name of the package that the asset is built on.
	 */
	protected $assetName;

	/*
	 * @var string
	 * private $_p2mProjectId;
	 * Every P2M asset should have a project identifier.
	 */
	protected $_p2mProjectId = 'yii2-p2y2-base';

	/*
	 * @var string
	 * protected $version;
	 */
	protected $version; // = '0.0.0'

	/*
	 * @var string
	 * private $packagePath;
	 */
	protected $assetPath;

	/*
	 * @var array
	 * protected $resourceData;
	 */
	protected $assetData = [];

	/*
	 * @var array
	 * protected $resourceData;
	 * ##### Deprecated in favour of $assetData #####
	 */
	protected $resourceData = [];

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
	 * private $_p2mPath;
	 * ##### Working to get rid of this #####
	 */
	private $_p2mPath;

// ##### ^ ##### ^ Yii2 Asset Variables ^ ##### ^ #####

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
	 * public $cssOptions = [];
	 *
	 * @var array
	 * public $js = [];
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

	public function __construct()
	{
		if(!self::$_aliasSet) {
			Yii::setAlias('@p2m', '@vendor/p2made');
			self::$_aliasSet = true;
		}
	}

	protected function configureAsset($assetData = [])
	{
		if(self::useStatic() && isset($assetData['static'])) {
			$tempData = $assetData['static'];

			if(isset($tempData['baseUrl'])) {
				$this->baseUrl = $this->insertAssetVersion($tempData['baseUrl']);
			}

			$this->setAssetVariables($assetData);
		}
		elseif(isset($assetData['published'])) {
			$tempData = $assetData['published'];

			if(isset($tempData['sourcePath'])) {
				$this->sourcePath = $this->insertAssetVersion($tempData['sourcePath']);

				$this->insertP2mPath($this->sourcePath);
			}

			$this->setAssetVariables($assetData);
		}

		$this->setAssetVariables($assetData);
	}

	protected function configureUnpkgAsset($assetData = [])
	{
		// Create tail for paths
		$tail = (isset($this->assetPath) ? "/" . $this->assetPath : "");

		// $baseUrl OR $sourcePath
		if(self::useStatic()) {
			$this->baseUrl = "https://unpkg.com/" . $this->assetName . "@" . $this->version . $tail;
		}
		else {
			$this->sourcePath = "@npm/" . $this->assetName . $tail;
		}

		// Create tail for paths

	}

	protected function configureCdnjsAsset()
	{
	}

	// ===== utility functions ===== //

	protected function setAssetVariable(&$assetVariable, $variableData)
	{
		if(!isset($assetVariable)) { $assetVariable = $variableData; }
	}

	protected function setAssetVariables($assetData)
	{
		if(!isset($this->js) && isset($assetData['js'])) {
			$this->js = $assetData['js'];
		}
		if(!isset($this->css) && isset($assetData['css'])) {
			$this->css = $assetData['css'];
		}
		if(!isset($this->jsOptions) && isset($assetData['jsOptions'])) {
			$this->jsOptions = $assetData['jsOptions'];
		}
		if(!isset($this->cssOptions) && isset($assetData['cssOptions'])) {
			$this->cssOptions = $assetData['cssOptions'];
		}
		if(!isset($this->publishOptions) && isset($assetData['publishOptions'])) {
			$this->publishOptions = $assetData['publishOptions'];
		}
		if(!isset($this->depends) && isset($assetData['depends'])) {
			$this->depends = $assetData['depends'];
		}
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

		self::$_useStatic = P2AssetsSettings::assetsUseStatic();

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

		$_assetsEnd = P2AssetsSettings::assetsStaticEnd();

		return $_assetsEnd;
	}

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

	public function init()
	{
		parent::init();
	}
}
