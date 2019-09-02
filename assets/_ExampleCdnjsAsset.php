<?php
/**
 * _ExampleCdnjsAsset.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
 * @link https://github.com/p2made
 * @license MIT
 *
 * @package p2made/yii2-p2y2-base
 * @class \p2m\base\assets\_ExampleCdnjsAsset
 */

/**
 * Load this asset with...
 * p2m\assets\_ExampleCdnjsAsset::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\_ExampleCdnjsAsset',
 */

namespace p2m\base\assets; /* edit this if using elsewhere */

class _ExampleCdnjsAsset extends P2AssetBase
{
	protected $version = '0.0.0';

	private $assetData = [
		/**
		 * 'static' section
		 * use this for static version of assets
		 * leave out if there's no static version
		 */
		'static' => [
			'baseUrl' => '//example.com/path_to_asset/##-version-##',
			'css' => [
				'css/css_file.css',
			],
			'js' => [
				'js/js_file.js',
			],
		],
		/**
		 * 'published' section
		 * use this for published version of assets
		 * leave out if there's no published version
		 */
		'published' => [
			'sourcePath' => '@path/to/assets/folder',
			'css' => [
				'css/css_file.css',
			],
			'js' => [
				'js/js_file.js',
			],
		],
		'css' => [
		],
		'cssOptions' => [
		],
		'js' => [
		],
		'jsOptions' => [
		],
		'depends' => [
		],

		/**
		 * OPTIONAL :
		 * Use 'endName' for custom assets belonging to one application end,
		 * AND when you have a static application end to publish asset to,
		 * AND when you want to publish asset to an end specific folder
		 * leave any of the above is NOT true
		 */
		//
		'endName' = 'endName',
	];

	public function init()
	{
		$this->configureAsset($this->resourceData);
		parent::init();
	}
}
