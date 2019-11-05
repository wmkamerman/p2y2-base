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

	protected $packageData = [
		'static' => [
			'baseUrl' => 'baseUrl',
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
					'integrity' => 'static-hash', // js css has hash[s]
					'crossorigin' => 'anonymous', // js css has hash[s]
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
			'publishOptions' => [
			],
		],
		'depends' => [
			'some\useful\ThingAsset',
		],
	];

 *
 */

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

	protected function __construct($bypass = false, $config = [])
	{
		/*
		 * For easier access to p2m stuff we give it an alias
		 * but only if it hasn't already been set.
		 * the 2nd asset & after need different names.
		 */
		//self::setP2mAlias();

		if($bypass) return;

		if(!self::$_aliasSet) {
			Yii::setAlias('@p2m',      '@vendor/p2made');
			Yii::setAlias('@jsdelivr', 'https://cdn.jsdelivr.net/npm');
			Yii::setAlias('@cdnjs',    'https://cdnjs.cloudflare.com/ajax/libs');
			self::$_aliasSet = true;
		}

		$data = $this->packageData;

		$this->configureAssetOptions($data);

		$this->configureAssetOptions($data);

		parent::__construct();
	}

	protected function configureAsset($data)
	{
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
		if(isset($data['cssOptions']))
			$this->cssOptions = $assedataData['cssOptions'];
		if(isset($data['jsOptions']))
			$this->jsOptions = $assedataData['jsOptions'];
		if(isset($data['publishOptions']))
			$this->publishOptions = $assedataData['publishOptions'];
		if(isset($data['depends']))
			$this->depends = $assedataData['depends'];

	}





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





























	/*
	 * Configures an asset not described by a pattern.
	 * This should ONLY be on assets that are part of
	 * P2CoreAsset
	 */
	protected function configureDefaultAsset()
	{
		$this->setAssetVersion();

		// $baseUrl OR $sourcePath
		if(self::useStatic()) {
			$this->setYiiVariable($source, 'baseUrl');
			if(isset($this->assetData['static']))
				$this->setYiiVariables($this->assetData['static']);
		}
		else {
			$this->setYiiVariable($source, 'sourcePath');
			if(isset($this->assetData['published']))
				$this->setYiiVariables($this->assetData['published']);
		}

		$this->setYiiVariables($this->assetData);
	}

	/*
	 * Configures an asset described the 'unpkg' pattern.
	 */
	protected function configureUnpkgAsset()
	{
		$this->setAssetVersion();
		$this->setUnpkgPath();
		$this->setYiiVariables($this->assetData);
	}

	/*
	 * Configures an asset described the 'cdnjs' pattern.
	 */
	protected function configureCdnjsAsset()
	{
		// Assets on CDNJS ALWAYS have versions as '0.0.0'
		$this->setAssetVersion();

		// $baseUrl OR $sourcePath
		if(self::useStatic()) {
			$this->baseUrl = "https://cdnjs.cloudflare.com/ajax/libs/" . $this->packageName()
				. "/" . $this->assetVersion() . $this->pathTail();
			if(isset($this->assetData['static']))
				$this->setYiiVariables($this->assetData['static']);
		}
		else {
			$this->sourcePath = $this->sourcePath . $this->pathTail();
			if(isset($this->assetData['published']))
				$this->setYiiVariables($this->assetData['published']);
		}

		// Set any variables not already set
		$this->setYiiVariables($this->assetData);
	}

	/*
	 * Configures an asset described the 'moment' pattern.
	 */
	protected function configureMomentAsset()
	{
		$this->setUnpkgPath();
	}

	/*
	 * Configures an asset described the 'vendor' pattern.
	 */
	protected function configureVendorAsset()
	{
		// Set $sourcePath
		$this->sourcePath = $this->assetData['sourcePath'];

		// Set variables...
		$this->setYiiVariables($this->assetData);
	}

	/*
	 * Sets $baseUrl or $sourcePath for 'unpkg' assets
	 */
	private function setUnpkgPath()
	{
		// $baseUrl OR $sourcePath
		if(self::useStatic()) {
			$this->baseUrl = "https://unpkg.com/" . $this->packageName()
				. "@" . $this->assetVersion() . $this->pathTail();
		}
		else {
			$this->sourcePath = "@npm/" . $this->packageName() . $this->pathTail();
		}
	}

	// ##### ^ ##### UTILITY FUNCTIONS ##### ^ ##### //

	protected function assetVersion()
	{
		return $this->_version;
	}

	protected function setAssetVersion()
	{
		if(!isset($this->_version))
			$this->_version = $this->assetData['version'];
	}

	protected function insertAssetVersion(&$target)
	{
		if(isset($this->_version))
			$target = str_replace('@@version@@', $this->_version, $target);
	}

	protected function packageName()
	{
		return $this->_package;
	}

	protected function setPackageName($packageName = null)
	{
		if(isset($packageName)) {
			$this->_package = $packageName;
			return;
		}

		if(isset($this->assetData['package']))
			$this->_package = $this->assetData['package'];
		else
			$this->_package = $this->assetName;
	}

	/**
	 * Sets the variable named in $key
	 * if it is not already set & we have a value for it
	 */
	private function setYiiVariable($source, $key)
	{
		if(!isset($this->$key) && isset($source[$key]))
			$this->$key = $source[$key];
		$this->$key = $this->$key;
	}

	/**
	 * Performs setYiiVariable(...) on a block of variables
	 */
	private function setYiiVariables($source)
	{
		$this->setYiiVariable($source, 'css');
		$this->setYiiVariable($source, 'js');
		$this->setYiiVariable($source, 'cssOptions');
		$this->setYiiVariable($source, 'jsOptions');
		$this->setYiiVariable($source, 'publishOptions');
		$this->setYiiVariable($source, 'depends');
	}

	/**
	 * Returns common ending of paths where there is one
	 * @return string
	 * @default ''
	 */
	private function pathTail()
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
		if(!isset(self::$_useStatic))
			self::$_useStatic = Settings::assetsUseStatic();
		return self::$_useStatic;
	}

	/**
	 * Get assetsEnd setting - static application end
	 * @return array | false
	 * @default false
	 */
	private static function assetsEnd()
	{
		if(!isset(self::$_assetsEnd))
			self::$_assetsEnd = Settings::assetsStaticEnd();
		return self::$_assetsEnd;
	}

	/*
	 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
	 * ##### ^ #####   WANT TO GET RID OF...   ##### ^ #####
	 * ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ ##### ^ #####
	 */

	// ##### ^ ##### WANT TO GET RID OF THIS ##### ^ #####
	protected function configureAsset($assetData = [])
	{
		if(self::useStatic() && isset($assetData['static'])) {
			$tempData = $assetData['static'];

			if(isset($tempData['baseUrl'])) {
				$this->baseUrl = $this->insertAssetVersion($tempData['baseUrl']);
			}

			$this->setYiiVariables($assetData);
		}
		elseif(isset($assetData['published'])) {
			$tempData = $assetData['published'];

			if(isset($tempData['sourcePath'])) {
				$this->sourcePath = $this->insertAssetVersion($tempData['sourcePath']);

				$this->insertP2mPath($this->sourcePath);
			}

			$this->setYiiVariables($assetData);
		}

		$this->setYiiVariables($assetData);
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
