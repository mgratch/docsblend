<?php

/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 2015-01-26
 * Time: 15:19
 */
class ctBrowserPlugin
{

    public function ct_is_browser_type($type = null)
    {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ($type == 'bot') {
            if (preg_match("/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent)) {
                return true;
            }
        } else if ($type == 'browser') {
            if (preg_match("/mozilla\/|opera\//", $user_agent)) {
                return true;
            }
        } else if ($type == 'mobile') {
            if (preg_match("/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent)) {
                return true;
            } else if (preg_match("/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent)) {
                return true;
            }
        }

        return false;
    }

}


if (!function_exists('ct_is_browser_type')) {
    function ct_is_browser_type($type = null)
    {
        $obj = new ctBrowserPlugin();
        return $obj->ct_is_browser_type($type);
    }
}