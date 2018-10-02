<?php
error_reporting(false);
if(!function_exists('curl_init')){
	die("Please install php-curl\n");
}
if(isset($argv[1]) && $argv[1] !==''){
	if(!is_dir('cookie')){
		mkdir('cookie');
	}
	$cookie = __DIR__.'/cookie/'.$argv[1];
	$data = array('wallet' => $argv[1],'refby' => 'ID11777','botprotection' => 'im not','submit' => 'Login','submit_address' => 1);
}else{
	die("wallet address not found\n");
}
$url['login'] = 'http://affi.cryptoplanets.org/WfHbDz2J3LgFDFhN8S7KcyJneEdcbitdrip/index.php';
$url['post'] = 'http://affi.cryptoplanets.org/WfHbDz2J3LgFDFhN8S7KcyJneEdcbitdrip/ajax.php';
$login = getwebPage($url['login'], http_build_query($data));
if($login['status'] == 200){
	while(true){
		for($i=1; $i <=5; $i++){
			$cap = getwebPage($url['post'], 'correct_captcha=853813&user_captcha=853813&captcha_submit=');
			$res = getwebPage($url['post'], 'reset_contest_button='.$i);
			$un = getwebPage($url['post'], 'unlock_button=unlock_button');
			if($res['status'] == 200 && $un['status'] == 200 && $cap['status'] == 200){
			    getwebPage($url['post'], 'confirm_exploaration_special_claim=1');
				$claim = getwebPage($url['post'], 'confirm_exploaration_point_claim='.$i);
				if($claim['status'] == 200){
					$c['info'] = getwebPage($url['login']);
					$c['first'] = explode('<div class="widget-int num-count"><font size="6" color="#fffd9e">', $c['info']['exec']);
					$c['sec'] = explode('</font></div>', $c['first'][1]);
					if(isset($claim['exec'], $c['sec'][0]) && $claim['exec']!=='' && $claim['exec'] !== '0' && $c['sec'][0] !==''){
							echo "Sukses Claim {$claim['exec']} Point ~ Your Point {$c['sec'][0]}\n";
					}
				}
			}
		}
		sleep(6*60);
	}
}
function getwebPage($url, $post=null){
	  global $cookie;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_REFERER, "http://affi.cryptoplanets.org/WfHbDz2J3LgFDFhN8S7KcyJneEdcbitdrip/index.php");
      curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; E1C 3G Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/49.0.2623.105 Mobile Safari/537.36");
      curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
      curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
      if(isset($post) && $post !==""){
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8", "X-Requested-With: XMLHttpRequest"));
      }else{
      	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html; charset=UTF-8", "X-Requested-With: com.org.bitdrip"));
      }
      $get['exec'] = curl_exec($ch);
      if(!curl_errno($ch)){
          $get['status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   	   $get['infourl'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);  
      }else{
      	return false;
      }
      curl_close($ch);
      return $get;
   }