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

/**
 * Load this asset with...
 * p2m\assets\base\P2AssetBase::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\base\P2AssetBase',
 */

namespace p2m\base\assets;

use p2m\base\helpers\P2AssetsSettings;

class P2AssetBase extends \yii\web\AssetBundle
{
// ##### ^ ##### ^ P2M Asset Variables ^ ##### ^ #####

	/*
	 * @var string
	 * private $_p2mProjectId;
	 * Every P2M asset should have a project identifier.
	 */
	protected $_p2mProjectId = 'yii2-p2y2-base';

	/*
	 * @var string
	 * protected $assetName;
	 * The simple name of the asset.
	 * Usually the same as $_packageName
	 */
	protected $assetName;

	/*
	 * @var string
	 * protected $version;
	 */
	protected $assetVersion; // = '0.0.0'

	/*
	 * @var array
	 * protected $assetData;
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
	 * @var string
	 * protected $_packageName;
	 * The simple name of the package that the asset is built on
	 * Usually the same as $assetName
	 */
	private $_packageName;

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

	// ##### ^ ##### WANT TO GET RID OF THIS ##### ^ #####
	/*
	 * @var string
	 * private $_p2mPath;
	 */
	private $_p2mPath;

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

	public function __construct()
	{
		/*
		 * For easier access to p2m stuff we give it an alias
		 * but only if it hasn't already been set.
		 * the 2nd asset & after need different names.
		 */
		if(!self::$_aliasSet) {
			Yii::setAlias('@p2m', '@vendor/p2made');
			self::$_aliasSet = true;
		}

		/*
		 * Usually $assetName is also the name of the package.
		 * When more than one asset uses the same package
		 * the 2nd asset & after need different names.
		 * For those we include the package name as...
		 * 'package' => 'packageName' & swap it in here.
		 */
		if(isset($this->assetData['package']))
			$this->_packageName = $this->assetData['package'];
		else
			$this->_packageName = $this->assetName;

		// Which pattern does the data use?
		switch ($this->assetData['pattern']) {
			case 'unpkg';
				$this->configureUnpkgAsset();
				break;
			case 'cdnjs';
				$this->configureCdnjsAsset();
				break;
			case 'moment';
				$this->configureMomentAsset();
				break;
			case 'vendor';
				$this->configureVendorAsset();
				break;
			default:
				$this->configureCoreAsset();
		}
	}

	/*
	 * Configures an asset not described by a pattern.
	 * This should ONLY be on assets that are part of
	 * P2CoreAsset
	 */
	private function configureCoreAsset()
	{
	}

	/*
	 * Configures an asset described the 'unpkg' pattern.
	 */
	private function configureUnpkgAsset()
	{
		$this->setAssetVersion();
		$this->setUnpkgPath();
		$this->setAssetVariables($this->assetData);
	}

	/*
	 * Configures an asset described the 'cdnjs' pattern.
	 */
	private function configureCdnjsAsset()
	{
		// Assets on CDNJS ALWAYS have versions as '0.0.0'
		$this->setAssetVersion();

		// $baseUrl OR $sourcePath
		if(self::useStatic()) {
			$this->baseUrl = "https://cdnjs.cloudflare.com/ajax/libs/" . $this->_packageName
				. "/" . $this->assetVersion . $this->tail();
			if(isset($this->assetData['static']))
				$this->setAssetVariables($this->assetData['static']);
		}
		else {
			$this->sourcePath = $this->sourcePath . $this->tail();
			if(isset($this->assetData['published']))
				$this->setAssetVariables($this->assetData['published']);
		}

		// Set any variables not already set
		$this->setAssetVariables($this->assetData);
	}

	/*
	 * Configures an asset described the 'moment' pattern.
	 */
	private function configureMomentAsset()
	{
		$this->setUnpkgPath();
	}

	/*
	 * Sets $baseUrl or $sourcePath for 'unpkg' assets
	 */
	private function setUnpkgPath()
	{
		// $baseUrl OR $sourcePath
		if(self::useStatic()) {
			$this->baseUrl = "https://unpkg.com/" . $this->_packageName
				. "@" . $this->assetVersion . $this->tail();
		}
		else {
			$this->sourcePath = "@npm/" . $this->_packageName . $this->tail();
		}
	}

	/*
	 * Configures an asset described the 'vendor' pattern.
	 */
	private function configureVendorAsset()
	{
		// Set $sourcePath
		$this->sourcePath = $this->assetData['sourcePath']

		// Set variables...
		$this->setAssetVariables($this->assetData);
	}

	// ##### ^ ##### WANT TO GET RID OF THIS ##### ^ #####
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

	// ##### ^ ##### UTILITY FUNCTIONS ##### ^ ##### //

	private function setAssetVersion()
	{
		if(!isset($this->assetVersion))
			$this->assetVersion = $this->assetData['version'];
	}

	/**
	 * Sets the variable named in $key
	 * if it is not already set & we have a value for it
	 */
	private function setAssetVariable($source, $key)
	{
		if(!isset($this->$key) && isset($source[$key]))
			$this->$key = $source[$key];
		$this->$key = $this->$key;
	}

	/**
	 * Performs setAssetVariable(...) on a block of variables
	 */
	private function setAssetVariables($source)
	{
		$this->setAssetVariable($source, 'css');
		$this->setAssetVariable($source, 'js');
		$this->setAssetVariable($source, 'cssOptions');
		$this->setAssetVariable($source, 'jsOptions');
		$this->setAssetVariable($source, 'publishOptions');
		$this->setAssetVariable($source, 'depends');
	}

	/**
	 * Returns common ending of paths where there is one
	 * @return string
	 * @default ''
	 */
	private function tail()
	{
		if(isset($this->assetData['path']))
			return '/' . $this->assetData['path'];
		return '';
	}

	/**
	 * Get useStatic setting - use static resources
	 * @return boolean
	 * @default false
	 */
	private static function useStatic()
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
	private static function assetsEnd()
	{
		if(isset($_assetsEnd)) {
			return $_assetsEnd;
		}

		$_assetsEnd = P2AssetsSettings::assetsStaticEnd();

		return $_assetsEnd;
	}

	// ##### ^ ##### WANT TO GET RID OF THIS ##### ^ #####
	protected function insertAssetVersion(&$target)
	{
		if(isset($this->version)) {
			$target = str_replace('##-version-##', $this->version, $target);
		}
	}

	// ##### ^ ##### WANT TO GET RID OF THIS ##### ^ #####
	protected function p2mPath()
	{
		if(isset($this->_p2mPath)) {
			return $this->_p2mPath;
		}

		$this->_p2mPath = '@vendor/p2made/' . $this->_p2mProjectId . '/vendor';

		return $this->_p2mPath;
	}

	// ##### ^ ##### WANT TO GET RID OF THIS ##### ^ #####
	protected function insertP2mPath(&$target)
	{
		$target = str_replace('@p2m@', $this->p2mPath(), $target);
	}
}
