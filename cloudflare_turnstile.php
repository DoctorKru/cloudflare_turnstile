<?php

/**
 * <code>.cf-turnstile</code> wrapper class allow to customize the widget appearance in your CSS (e.g., to frame, round, or clean up border artifacts).
 * 
 * Cloudflare Turnstile (https://cloudflare.com/products/turnstile/) benefits:
 * 
 * GDPR Compliant & Privacy-Friendly: unlike Google, it does not track users across the web or drop invasive advertising cookies.
 * 
 * No Annoying Puzzles: visitors rarely see a checkbox and never have to solve "select traffic lights" image puzzles.
 * 
 * 100% free with unlimited requests, no need to use Cloudflare as your DNS/CDN provider to use it.
 * 
 * 
 * @siteurl https://github.com/DoctorKru/cloudflare_turnstile
 * @author DoctorKru
 * @package plugins
 * @subpackage spam
 */

// Force UTF-8 Ø
$plugin_is_filter = 5 | CLASS_PLUGIN;
$plugin_description = gettext("Cloudflare Turnstile Captcha handler.");
$plugin_author = "DoctorKru";
$plugin_version = "1.0.0";
$plugin_date = '2026-10-21';
$plugin_siteurl = 'https://github.com/DoctorKru/cloudflare_turnstile';
$plugin_disable = ($_zp_captcha->name && $_zp_captcha->name != 'Cloudflare Turnstile') ? sprintf(gettext('Only one Captcha handler plugin may be enabled. <a href="#%1$s"><code>%1$s</code></a> is already enabled.'), $_zp_captcha->name) : '';
$plugin_notice = gettext('Cloudflare account and Turnstile keys required. <br><i>Privacy note:</i> This plugin embeds third-party JavaScript from Cloudflare servers.');
$option_interface = 'cloudflare_turnstile';
$plugin_category = gettext('Spam');

class cloudflare_turnstile extends _zp_captcha {

	public $name = 'Cloudflare Turnstile';

	/**
	 * Class instantiator
	 */
	function __construct() {
		setOptionDefault('cloudflare_turnstile_site_key', '');
		setOptionDefault('cloudflare_turnstile_secret_key', '');
		setOptionDefault('cloudflare_turnstile_theme', 'auto');
		setOptionDefault('cloudflare_turnstile_size', 'normal');
		setOptionDefault('cloudflare_turnstile_appearance', 'always');
		setOptionDefault('cloudflare_turnstile_lang', 'auto');
	}

	/**
	 * Returns array of supported options for the admin-options handler
	 *
	 * @return array
	 */
	function getOptionsSupported() {
		return array(
				gettext('Site Key') => array(
						'key' => 'cloudflare_turnstile_site_key',
						'type' => OPTION_TYPE_TEXTBOX,
						'order' => 1,
						'desc' => gettext('Enter your Cloudflare Turnstile Site Key.')
				),
				gettext('Secret Key') => array(
						'key' => 'cloudflare_turnstile_secret_key',
						'type' => OPTION_TYPE_TEXTBOX,
						'order' => 2,
						'desc' => gettext('Enter your Cloudflare Turnstile Secret Key.')
				),
				gettext('Theme Scheme') => array(
						'key' => 'cloudflare_turnstile_theme',
						'type' => OPTION_TYPE_SELECTOR,
						'order' => 3,
						'selections' => array(
								gettext('Auto') => 'auto',
								gettext('Light') => 'light',
								gettext('Dark') => 'dark'
						),
						'desc' => gettext('Select the color theme scheme for the Turnstile widget.')
				),
				gettext('Widget Size') => array(
						'key' => 'cloudflare_turnstile_size',
						'type' => OPTION_TYPE_SELECTOR,
						'order' => 4,
						'selections' => array(
								gettext('Normal') => 'normal',
								gettext('Compact') => 'compact',
								gettext('Flexible') => 'flexible'
						),
						'desc' => gettext('Select the widget display size.')
				),
				gettext('Appearance Visibility') => array(
						'key' => 'cloudflare_turnstile_appearance',
						'type' => OPTION_TYPE_SELECTOR,
						'order' => 5,
						'selections' => array(
								gettext('Always (Default)') => 'always',
								gettext('Execute') => 'execute',
								gettext('Interaction Only') => 'interaction-only'
						),
						'desc' => gettext('Configure the widget appearance behavior.')
				),
				gettext('Language') => array(
						'key' => 'cloudflare_turnstile_lang',
						'type' => OPTION_TYPE_SELECTOR,
						'order' => 6,
						'selections' => array(
								gettext('Auto (Browser Detection)') => 'auto',
								gettext('Arabic (Egypt) [ar-eg]') => 'ar-eg',
								gettext('Bulgarian [bg-bg]') => 'bg-bg',
								gettext('Chinese (Simplified) [zh-cn]') => 'zh-cn',
								gettext('Chinese (Traditional) [zh-tw]') => 'zh-tw',
								gettext('Croatian [hr-hr]') => 'hr-hr',
								gettext('Czech [cs-cz]') => 'cs-cz',
								gettext('Danish [da-dk]') => 'da-dk',
								gettext('Dutch [nl-nl]') => 'nl-nl',
								gettext('English (US) [en-us]') => 'en-us',
								gettext('Farsi [fa-ir]') => 'fa-ir',
								gettext('Finnish [fi-fi]') => 'fi-fi',
								gettext('French [fr-fr]') => 'fr-fr',
								gettext('German [de-de]') => 'de-de',
								gettext('Greek [el-gr]') => 'el-gr',
								gettext('Hebrew [he-il]') => 'he-il',
								gettext('Hindi [hi-in]') => 'hi-in',
								gettext('Hungarian [hu-hu]') => 'hu-hu',
								gettext('Indonesian [id-id]') => 'id-id',
								gettext('Italian [it-it]') => 'it-it',
								gettext('Japanese [ja-jp]') => 'ja-jp',
								gettext('Korean [ko-kr]') => 'ko-kr',
								gettext('Lithuanian [lt-lt]') => 'lt-lt',
								gettext('Malay [ms-my]') => 'ms-my',
								gettext('Norwegian Bokmål [nb-no]') => 'nb-no',
								gettext('Polish [pl-pl]') => 'pl-pl',
								gettext('Portuguese (Brazil) [pt-br]') => 'pt-br',
								gettext('Romanian [ro-ro]') => 'ro-ro',
								gettext('Russian [ru-ru]') => 'ru-ru',
								gettext('Serbian [sr-ba]') => 'sr-ba',
								gettext('Slovak [sk-sk]') => 'sk-sk',
								gettext('Slovenian [sl-si]') => 'sl-si',
								gettext('Spanish [es-es]') => 'es-es',
								gettext('Swedish [sv-se]') => 'sv-se',
								gettext('Tagalog [tl-ph]') => 'tl-ph',
								gettext('Thai [th-th]') => 'th-th',
								gettext('Turkish [tr-tr]') => 'tr-tr',
								gettext('Ukrainian [uk-ua]') => 'uk-ua',
								gettext('Vietnamese [vi-vn]') => 'vi-vn',
								gettext('Klingon [tlh]') => 'tlh'
						),
						'desc' => gettext('Select an explicit language or leave as Auto to match visitor browser.')
				)
		);
	}

	/**
	 * Returns HTML for Cloudflare Turnstile (including required JavaScript library)
	 *
	 * @param string $siteKey
	 * @param string $theme
	 * @param string $size
	 * @param string $appearance
	 * @param string $lang
	 * @return string
	 */
	function getCaptchaHTML($siteKey, $theme, $size, $appearance, $lang) {
		$script_url = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
		$lang_attr = 'auto';

		if ($lang && $lang !== 'auto') {
			$script_url .= '?language=' . urlencode($lang);
			$lang_attr = htmlspecialchars($lang, ENT_QUOTES, 'UTF-8');
		}

		return '<script src="' . $script_url . '" async defer></script>
				<div class="cf-turnstile" ' .
				'data-sitekey="' . htmlspecialchars($siteKey, ENT_QUOTES, 'UTF-8') . '" ' .
				'data-theme="' . htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') . '" ' .
				'data-size="' . htmlspecialchars($size, ENT_QUOTES, 'UTF-8') . '" ' .
				'data-appearance="' . htmlspecialchars($appearance, ENT_QUOTES, 'UTF-8') . '" ' .
				'data-language="' . $lang_attr . '"></div>';
	}
	/**
	 * Called on form submit to verify Turnstile token.
	 *
	 * @param string $s1 Not used
	 * @param string $s2 Not used
	 * @return boolean
	 */
	function checkCaptcha($s1, $s2) {
		$secretKey = getOption('cloudflare_turnstile_secret_key');
		$captcha = '';

		if (isset($_POST['cf-turnstile-response'])) {
			$captcha = sanitize($_POST['cf-turnstile-response']);
		}

		if (empty($secretKey) || empty($captcha)) {
			return false;
		}

		$verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
		$post_data = http_build_query(array(
				'secret' => $secretKey,
				'response' => $captcha,
				'remoteip' => sanitize($_SERVER['REMOTE_ADDR'])
		));

		$options = array(
				'http' => array(
						'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
						"Content-Length: " . strlen($post_data) . "\r\n",
						'method' => 'POST',
						'content' => $post_data
				)
		);

		$context = stream_context_create($options);
		$result = @file_get_contents($verify_url, false, $context);

		if ($result === false) {
			return false;
		}

		$response = json_decode($result, true);
		return isset($response['success']) && $response['success'] === true;
	}

	/**
	 * Called by Zenphoto forms to generate the CAPTCHA element array
	 *
	 * @param string $prompt
	 * @return array
	 */
	function getCaptcha($prompt) {
		$siteKey = getOption('cloudflare_turnstile_site_key');
		$secretKey = getOption('cloudflare_turnstile_secret_key');
		$theme = getOption('cloudflare_turnstile_theme');
		$size = getOption('cloudflare_turnstile_size');
		$appearance = getOption('cloudflare_turnstile_appearance');
		$lang = getOption('cloudflare_turnstile_lang');

		// Check for proper key configuration
		if (empty($siteKey) || empty($secretKey)) {
			return array(
					'input' => '',
					'html' => '<div class="errorbox"><p>' . gettext('Cloudflare Turnstile keys are not configured properly. Visit the plugin options to enter your keys.') . '</p></div>',
					'hidden' => ''
			);
		} else {
			$html = $this->getCaptchaHTML($siteKey, $theme, $size, $appearance, $lang);
			return array(
					'html' => '<label class="captcha-label">' . $prompt . '</label>',
					'input' => $html
			);
		}
	}

}

// Required for script to be considered a native Zenphoto CAPTCHA handler
if ($plugin_disable) {
	enableExtension('cloudflare_turnstile', 0);
} else {
	$_zp_captcha = new cloudflare_turnstile();
}