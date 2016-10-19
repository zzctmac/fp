<?php
/**
 * User: 周智超
 * Date: 2016/9/9
 * Time: 15:27
 */

namespace common;


class Http {
    public static function getBrowserName(){
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $patterns = array(
            'baidu' => '/bidubrowser/',
            'theworld' => '/theworld/',
            'opera' => '/opr\/[\d.]+/',
            'sougou' => '/se [\d]/',
            'maxthon' => '/maxthon/',
            'taobao' => '/taobrowser/',
            'liebao' => '/lbbrowser/',
            'qq' => '/qqbrowser/',
            'tt' => '/tencenttraveler/',
            'firefox' => '/firefox/',
            'google' => '/chrome/',
            'safari' => '/safari/',
            'ie' => '/msie/',
        );
        foreach($patterns as $name=>$pattern){
            if(preg_match($pattern,$agent)){
                return $name;
            }
        }
        return 'otherBrowser';
    }

    public static function redirectWithRefer($url) {
        if (empty($url)){
            echo "跳转失败,请重试.<script>history.back()</script>";
        }
        else{
            ob_clean();
            $url = trim($url);
            echo '<html><head><script type="text/javascript">window.location.href="'.$url.'";</script></head><body></body></html>';
        }
        exit();
    }

    public static function redirect($url) {

        if($url){
            ob_clean();
            $url = trim($url);
            header("Location: ".$url);
        }
        else{
            echo "跳转失败,请重试.<script>history.back()</script>";
        }
        exit;
    }
}