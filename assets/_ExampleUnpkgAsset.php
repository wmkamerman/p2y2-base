<?php
/**
 * _ExampleUnpkgAsset.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
 * @link https://github.com/p2made
 * @license MIT
 *
 * @package p2made/yii2-p2y2-base
 * @class \p2m\base\assets\_ExampleUnpkgAsset
 */

namespace p2m\base\assets; /* edit this if using elsewhere */

/**
 * Load this asset with...
 * p2m\assets\_ExampleUnpkgAsset::register($this);
 *
 * or specify as a dependency with...
 *     'p2m\assets\_ExampleUnpkgAsset',
 */
class _ExampleUnpkgAsset extends \p2m\base\assets\P2UnpkgAssetBase
{
	protected $unpkgName = 'unpkgName';

	protected $version = '0.0.0';

	protected $unpkgPath = 'unpkgPath';

	public $depends = [
		'depends'
	];

	public $js = [
		'javascipt.min.js'
	];

	public $css = [
		'css'
	];

	public $jsOptions = [
		'jsOptions'
	];

	public $cssOptions = [
		'cssOptions'
	];

	public $publishOptions = [
		'publishOptions'
	];

	public function init()
	{
		$this->configureAsset();
		parent::init();
	}
}
