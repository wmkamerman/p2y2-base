<?php
/**
 * Settings.php
 *
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @author Pedro Plowman
 * @link https://github.com/p2made
 * @package p2made/yii2-p2y2-users
 * @license MIT
 */

namespace p2m\helpers;

use Yii;

/**
 * class p2m\base\helpers\Settings
 */
class Settings extends \p2m\helpers\base\P2Helper
{
	private static $_p2mParams = Yii::$app->params['p2m'];
	private static $_p2mAssetParams = Yii::$app->params['p2m']['assets'];
	private static $_p2mUserParams = Yii::$app->params['p2m']['users'];

	private static $_useStatic;
	private static $_staticEnd;
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

	/*
	 * Assets settings
	 */
	public static function useStatic()
	{
		if(isset($_useStatic)) {
			return $_useStatic;
		}

		$_useStatic = (
			isset($_p2mAssetParams['useStatic']) ?
			$_p2mAssetParams['useStatic'] : false
		);

		return $_useStatic;
	}

	public static function staticEnd()
	{
		if(isset($_staticEnd)) {
			return $_staticEnd;
		}

		$_useStatic = (
			isset($_p2mAssetParams['staticEnd']) ?
			$_p2mAssetParams['staticEnd'] : false
		);

		return $_staticEnd;
	}

	/*
	 * Users settings
	 */
	public static function requireEmail()
	{
		if(isset($_urequireEmail)) {
			return $_requireEmail;
		}

		$_requireEmail = (
			isset($_p2mUsersParams['requireEmail']) ?
			$_p2mUsersParams['requireEmail'] : true
		);

		return $_requireEmail;
	}

	public static function requireUsername()
	{
		if(isset($_urequireUsername)) {
			return $_requireUsername;
		}

		$_requireUsername = (
			isset($_p2mUsersParams['requireUsername']) ?
			$_p2mUsersParams['requireUsername'] : false
		);

		return $_requireUsername;
	}

	public static function useEmail()
	{
		if(isset($_uuseEmail)) {
			return $_useEmail;
		}

		$_useEmail = (
			isset($_p2mUsersParams['useEmail']) ?
			$_p2mUsersParams['useEmail'] : true
		);

		return $_useEmail;
	}

	public static function useUsername()
	{
		if(isset($_uuseUsername)) {
			return $_useUsername;
		}

		$_useUsername = (
			isset($_p2mUsersParams['useUsername']) ?
			$_p2mUsersParams['useUsername'] : true
		);

		return $_useUsername;
	}

	public static function loginEmail()
	{
		if(isset($_uloginEmail)) {
			return $_loginEmail;
		}

		$_loginEmail = (
			isset($_p2mUsersParams['loginEmail']) ?
			$_p2mUsersParams['loginEmail'] : true
		);

		return $_loginEmail;
	}

	public static function loginUsername()
	{
		if(isset($_uloginUsername)) {
			return $_loginUsername;
		}

		$_loginUsername = (
			isset($_p2mUsersParams['loginUsername']) ?
			$_p2mUsersParams['loginUsername'] : true
		);

		return $_loginUsername;
	}

	public static function loginDuration()
	{
		if(isset($_loginDuration)) {
			return $_loginDuration;
		}

		$_loginDuration = (
			isset($_p2mUsersParams['loginDuration']) ?
			$_p2mUsersParams['loginDuration'] : 2551443 // one mean lunar month
		);

		return $_loginDuration;
	}

	public static function emailConfirmation()
	{
		if(isset($_uemailConfirmation)) {
			return $_emailConfirmation;
		}

		$_emailConfirmation = (
			isset($_p2mUsersParams['emailConfirmation']) ?
			$_p2mUsersParams['emailConfirmation'] : true
		);

		return $_emailConfirmation;
	}

	public static function emailChangeConfirmation()
	{
		if(isset($_uemailChangeConfirmation)) {
			return $_emailChangeConfirmation;
		}

		$_emailChangeConfirmation = (
			isset($_p2mUsersParams['emailChangeConfirmation']) ?
			$_p2mUsersParams['emailChangeConfirmation'] : true
		);

		return $_emailChangeConfirmation;
	}

	public static function loginRedirect()
	{
		if(isset($_uloginRedirect)) {
			return $_loginRedirect;
		}

		$_loginRedirect = (
			isset($_p2mUsersParams['loginRedirect']) ?
			$_p2mUsersParams['loginRedirect'] : null
		);

		return $_loginRedirect;
	}

	public static function logoutRedirect()
	{
		if(isset($_ulogoutRedirect)) {
			return $_logoutRedirect;
		}

		$_logoutRedirect = (
			isset($_p2mUsersParams['logoutRedirect']) ?
			$_p2mUsersParams['logoutRedirect'] : null
		);

		return $_logoutRedirect;
	}

	public static function resetExpireTime()
	{
		if(isset($_uresetExpireTime)) {
			return $_resetExpireTime;
		}

		$_resetExpireTime = (
			isset($_p2mUsersParams['resetExpireTime']) ?
			$_p2mUsersParams['resetExpireTime'] : '2 days'
		);

		return $_resetExpireTime;
	}

	public static function loginExpireTime()
	{
		if(isset($_uloginExpireTime)) {
			return $_loginExpireTime;
		}

		$_loginExpireTime = (
			isset($_p2mUsersParams['loginExpireTime']) ?
			$_p2mUsersParams['loginExpireTime'] : '15 minutes'
		);

		return $_loginExpireTime;
	}
}
