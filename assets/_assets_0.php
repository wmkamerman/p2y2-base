<?php



https://unpkg.com/react@16.7.0/umd/react.production.min.js


unpkg.com/:package@:version/:file


class MomentAsset extends \p2m\assets\base\P2MomentAssetBase
{
	protected $version = $this->momentVersion;

	protected $package;

	protected $path;

	protected $cssFile;

	protected $jsFile;

	private $resourceData = [
		'static' => [
			'baseUrl' => 'https://unpkg.com/moment@##-version-##/min',
			'js' => [
				'moment.min.js',
			],
			'jsOptions' => [
				'integrity' => 'sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=',
				'crossorigin' => 'anonymous',
			],
		],
		'published' => [
			'sourcePath' => '@npm/moment/min',
			'js' => [
				'moment.min.js'
			],
		],
	];

	public function init()
	{
		$this->configureAsset($this->resourceData);
		parent::init();
	}
}
