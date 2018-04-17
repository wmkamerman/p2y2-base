<?php
/**
 * AssetsSettings.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
 * @link https://github.com/p2made
 * @license MIT
 *
 * @package p2made/yii2-p2y2-base
 * @class \p2m\base\helpers\AssetsSettings
 */

namespace p2m\base\helpers;

use Yii;

/**
 * Settings for p2m assets
 * Located here to be used in multiple packages
 */
class AssetsSettings extends P2Settings
{
	/**
	 *
	 * Constants define identifiers for settings block
	 *
	 */
	const BLOCK_NAME = 'assets';

	const USE_STATIC = 'useStatic';
	const STATIC_END = 'staticEnd';
	const BOOTSWATCH = 'bootswatch';

	/**
	 * Constants define defaults for settings block
	 */
	const DEFAULT_USE_STATIC = false;
	const DEFAULT_STATIC_END = false;
	const DEFAULT_BOOTSWATCH = false;

	/**
	 * @var array | false assets settings
	 */
	private static $_assetsSettings;

	/**
	 * @var boolean use static resources
	 * @default false
	 */
	private static $_useStatic;

	/**
	 * @var array | false static application end
	 * @default false
	 */
	private static $_staticEnd;

	/**
	 * @var string | false Bootswatch theme
	 * @default false
	 */
	private static $_bootswatch;

	/**
	 * Get assets settings
	 * @return array | false
	 * @default false
	 */
	public static function assetsSettings()
	{
		if(isset(self::$_assetsSettings)) {
			return self::$_assetsSettings;
		}

		return self::getSettingsBlock(self::BLOCK_NAME);
	}

	/**
	 * Get assetsUseStatic setting - use static resources
	 * @return boolean
	 * @default false
	 */
	public static function assetsUseStatic()
	{
		if(isset(self::$_useStatic)) {
			return self::$_useStatic;
		}

		return self::getSettingsItem(
			self::$_useStatic,
			self::assetsSettings(),
			self::USE_STATIC,
			self::DEFAULT_USE_STATIC
		);
	}

	/**
	 * Get assetsStaticEnd setting - static application end
	 * @return array | false
	 * @default false
	 */
	public static function assetsStaticEnd()
	{
		if(isset(self::$_staticEnd)) {
			return self::$_staticEnd;
		}

		return self::getSettingsItem(
			self::$_staticEnd,
			self::assetsSettings(),
			self::STATIC_END,
			self::DEFAULT_STATIC_END
		);
	}

	/**
	 * Get bootswatchTheme setting
	 * @return string | false
	 * @default false
	 */
	public static function bootswatchTheme()
	{
		if(isset(self::$_bootswatch)) {
			return self::$_bootswatch;
		}

		return self::getSettingsItem(
			self::$_bootswatch,
			self::assetsSettings(),
			self::BOOTSWATCH,
			self::DEFAULT_BOOTSWATCH
		);
	}
}
