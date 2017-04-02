<?php
/**
 * Settings.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
 * @link https://github.com/p2made
 * @package p2made/yii2-p2y2-base
 * @license MIT
 */

namespace p2m\helpers;

use Yii;

/**
 * class p2m\base\helpers\Settings
 */
class Settings extends \p2m\helpers\base\P2Helper
{
	/**
	 * @var array Yii::$app->params
	 */
	private static $_params = Yii::$app->params;

	/**
	 * @var array | false p2m settings
	 */
	private static $_p2mSettings;

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
	 * @var array | false users settings
	 */
	private static $_usersSettings;

	/*
	private static $_requireEmail;
	private static $_requireUsername;
	private static $_useEmail;
	private static $_useUsername;
	private static $_loginEmail;
	private static $_loginUsername;
	private static $_loginDuration;
	private static $_emailConfirmation;
	private static $_emailChangeConfirmation;
	private static $_loginRedirect;
	private static $_logoutRedirect;
	private static $_resetExpireTime;
	private static $_loginExpireTime;
	*/

	/**
	 * Get p2m settings
	 * @return array | false
	 * @default false
	 */
	public static function p2mSettings()
	{
		if(isset($_p2mSettings)) {
			return $_p2mSettings;
		}

		if(!isset($_params['p2m'])) {
			$_p2mSettings = false;
			return $_p2mSettings;
		}

		$_p2mSettings = $_params['p2m'];

		return $_p2mSettings;
	}

	/*
	 *
	 * Assets settings
	 *
	 */

	/**
	 * Get assets settings
	 * @return array | false
	 * @default false
	 */
	public static function assetsSettings()
	{
		if(isset($_assetsSettings)) {
			return $_assetsSettings;
		}

		$settings = $this->p2mSettings();

		if($settings === false) {
			$_assetsSettings = false;
			return $_assetsSettings;
		}

		if(!isset($settings['assets'])) {
			$_assetsSettings = false;
			return $_assetsSettings;
		}

		$_assetsSettings = $settings['assets'];

		return $_assetsSettings;
	}

	/**
	 * Get assetsUseStatic setting - use static resources
	 * @return boolean
	 * @default false
	 */
	public static function assetsUseStatic()
	{
		if(isset($_useStatic)) {
			return $_useStatic;
		}

		$settings = $this->assetsSettings();

		if($settings === false) {
			$_useStatic = false;
			return $_useStatic;
		}

		if(!isset($settings['useStatic'])) {
			$_useStatic = false;
			return $_useStatic;
		}

		$_useStatic = $settings['useStatic'];

		return $_useStatic;
	}

	/**
	 * Get assetsStaticEnd setting - static application end
	 * @return array | false
	 * @default false
	 */
	public static function assetsStaticEnd()
	{
		if(isset($_staticEnd)) {
			return $_staticEnd;
		}

		$settings = $this->assetsSettings();

		if($settings === false) {
			$_staticEnd = false;
			return $_staticEnd;
		}

		if(!isset($settings['staticEnd'])) {
			$_staticEnd = false;
			return $_staticEnd;
		}

		$_staticEnd = $settings['staticEnd'];

		return $_staticEnd;
	}

	/*
	 *
	 * Users settings
	 *
	 */

	/**
	 * Get users settings
	 * @return array | false
	 * @default false
	 */
	public static function usersSettings()
	{
		if(isset($_usersSettings)) {
			return $_usersSettings;
		}

		$settings = $this->p2mSettings();

		if($settings === false) {
			$_usersSettings = false;
			return $_usersSettings;
		}

		if(!isset($settings['users'])) {
			$_usersSettings = false;
			return $_usersSettings;
		}

		$_usersSettings = $settings['users'];

		return $_usersSettings;
	}

	/*
	public static function usersRequireEmail()
	{
		if(isset($_requireEmail)) {
			return $_requireEmail;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_requireEmail = false;
			return $_requireEmail;
		}

		if(!isset($settings['requireEmail'])) {
			$_requireEmail = false;
			return $_requireEmail;
		}

		$_requireEmail = $settings['requireEmail'];

		return $_requireEmail;
	}

	public static function usersRequireUsername()
	{
		if(isset($_requireUsername)) {
			return $_requireUsername;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_requireUsername = false;
			return $_requireUsername;
		}

		if(!isset($settings['requireUsername'])) {
			$_requireUsername = false;
			return $_requireUsername;
		}

		$_requireUsername = $settings['requireUsername'];

		return $_requireUsername;
	}

	public static function usersUseEmail()
	{
		if(isset($_useEmail)) {
			return $_useEmail;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_useEmail = false;
			return $_useEmail;
		}

		if(!isset($settings['useEmail'])) {
			$_useEmail = false;
			return $_useEmail;
		}

		$_useEmail = $settings['useEmail'];

		return $_useEmail;
	}

	public static function usersUseUsername()
	{
		if(isset($_useUsername)) {
			return $_useUsername;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_useUsername = false;
			return $_useUsername;
		}

		if(!isset($settings['useUsername'])) {
			$_useUsername = false;
			return $_useUsername;
		}

		$_useUsername = $settings['useUsername'];

		return $_useUsername;
	}

	public static function usersLoginEmail()
	{
		if(isset($_loginEmail)) {
			return $_loginEmail;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_loginEmail = false;
			return $_loginEmail;
		}

		if(!isset($settings['loginEmail'])) {
			$_loginEmail = false;
			return $_loginEmail;
		}

		$_loginEmail = $settings['loginEmail'];

		return $_loginEmail;
	}

	public static function usersLoginUsername()
	{
		if(isset($_loginUsername)) {
			return $_loginUsername;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_loginUsername = false;
			return $_loginUsername;
		}

		if(!isset($settings['loginUsername'])) {
			$_loginUsername = false;
			return $_loginUsername;
		}

		$_loginUsername = $settings['loginUsername'];

		return $_loginUsername;
	}

	public static function usersLoginDuration()
	{
		if(isset($_loginDuration)) {
			return $_loginDuration;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_loginDuration = false;
			return $_loginDuration;
		}

		if(!isset($settings['loginDuration'])) {
			$_loginDuration = false;
			return $_loginDuration;
		}

		$_loginDuration = $settings['loginDuration'];

		return $_loginDuration;
	}

	public static function usersEmailConfirmation()
	{
		if(isset($_emailConfirmation)) {
			return $_emailConfirmation;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_emailConfirmation = false;
			return $_emailConfirmation;
		}

		if(!isset($settings['emailConfirmation'])) {
			$_emailConfirmation = false;
			return $_emailConfirmation;
		}

		$_emailConfirmation = $settings['emailConfirmation'];

		return $_emailConfirmation;
	}

	public static function usersEmailChangeConfirmation()
	{
		if(isset($_emailChangeConfirmation)) {
			return $_emailChangeConfirmation;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_emailChangeConfirmation = false;
			return $_emailChangeConfirmation;
		}

		if(!isset($settings['emailChangeConfirmation'])) {
			$_emailChangeConfirmation = false;
			return $_emailChangeConfirmation;
		}

		$_emailChangeConfirmation = $settings['emailChangeConfirmation'];

		return $_emailChangeConfirmation;
	}

	public static function usersLoginRedirect()
	{
		if(isset($_loginRedirect)) {
			return $_loginRedirect;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_loginRedirect = false;
			return $_loginRedirect;
		}

		if(!isset($settings['loginRedirect'])) {
			$_loginRedirect = false;
			return $_loginRedirect;
		}

		$_loginRedirect = $settings['loginRedirect'];

		return $_loginRedirect;
	}

	public static function usersLogoutRedirect()
	{
		if(isset($_logoutRedirect)) {
			return $_logoutRedirect;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_logoutRedirect = false;
			return $_logoutRedirect;
		}

		if(!isset($settings['logoutRedirect'])) {
			$_logoutRedirect = false;
			return $_logoutRedirect;
		}

		$_logoutRedirect = $settings['logoutRedirect'];

		return $_logoutRedirect;
	}

	public static function usersResetExpireTime()
	{
		if(isset($_resetExpireTime)) {
			return $_resetExpireTime;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_resetExpireTime = false;
			return $_resetExpireTime;
		}

		if(!isset($settings['resetExpireTime'])) {
			$_resetExpireTime = false;
			return $_resetExpireTime;
		}

		$_resetExpireTime = $settings['resetExpireTime'];

		return $_resetExpireTime;
	}

	public static function usersLoginExpireTime()
	{
		if(isset($_loginExpireTime)) {
			return $_loginExpireTime;
		}

		$settings = $this->usersSettings();

		if($settings === false) {
			$_loginExpireTime = false;
			return $_loginExpireTime;
		}

		if(!isset($settings['loginExpireTime'])) {
			$_loginExpireTime = false;
			return $_loginExpireTime;
		}

		$_loginExpireTime = $settings['loginExpireTime'];

		return $_loginExpireTime;
	}
	*/
}
