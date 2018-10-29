<?php
/**
 * 网关调用类
 * @author mail@yuyuefeng.com
 *
 */
namespace App\Components;
use Illuminate\Support\Facades\Log;

class MstKapi {
	
	private static $param = array(); // 请求参数
	
	/**
	 * singleton instance
	 *
	 */
	protected static $_instance = null;
	
	/**
	 * Returns singleton instance of MstKapi
	 *
	 * @return MstKapi
	 */
	public static function getInstance(){
	
		if ( !isset( self::$_instance ) ) {
	
			self::$_instance = new MstKapi();
	
		}
	
		return self::$_instance;
	}
	
	private function getDefautConfig(){
		$api_cfg = config('sms');
		
		return array(
				'api_url'   => $api_cfg['url'],
				'client_id' => $api_cfg['pid'],
				'secret_key'=> $api_cfg['secret_key']
		);
	}
	
	
	/**
	 * 获取请求结果, V2版本
	 * @param  array $cfg
	 * @param  number $time_out
	 * @param  string $pret
	 * @return number[]|string[]
	 */
	public function getResultV2($cfg=array(), $time_out=2, $pret=true, $method = 'POST') {
		$res = array(
				'error' => 100
		);
		if(empty($cfg)){
			$cfg = $this->getDefautConfig();
		}
		
		$post_param = $this->getParam();
		if(isset($post_param['service_name']) && isset($post_param['param'])) {
		    $reportLog = new ReportLog('INTEGRATION', $cfg['api_url'] . '/' . $post_param['service_name']);
			$param = array();
			$param['client_id']    = $cfg['client_id'];
			$param['secret_state'] = strtoupper(md5($cfg['client_id'].$cfg['secret_key'].'_kaikela@'));
			$param['timestamp']	   = (int)(microtime(true)*1000);
			$param = array_merge($param, $post_param);
			$param['param'] = json_encode($param['param']);
			$param_sign 	= strtoupper(md5($param['param']));
			$kapi_sign  	= strtoupper(md5($cfg['client_id'].$cfg['secret_key'].$param['timestamp'].$post_param['service_name']));
			$param['sign']  = strtoupper(md5($param_sign.'&'.$kapi_sign));

			$start_time = microtime(true);
			ksort($param);
            Log::info('kapi_params:' . $param['param']);
			$curl_res = $this->my_curl($cfg['api_url'], json_encode($param), $method, $time_out, array('Content-Type: application/json;charset=utf-8'));
            Log::info('kapi_res ' . print_r($curl_res, true));
			$duration = microtime(true)-$start_time;
			if(200 == $curl_res[0]) {
				if($pret) {
					$json_arr = json_decode($curl_res[1], true);
					if($json_arr['success']) {
                        $reportLog->end('Y');
						$res['error'] = 0;
						$res['data']  = $json_arr['data'];
					} else {
                        $reportLog->end('N');
						$res['msg'] = $json_arr['message'];
					}
				} else {
                    $reportLog->end('Y');
					$res['error'] = 0;
					$res['data']  = $curl_res[1];
				}

				Log::info('kapi_ok' . $post_param['service_name'].'耗时：'.$duration.'s ');
			} else {
			    $reportLog->end('E');
				$res['msg'] = $post_param['service_name'].'KAPI调用失败'.$curl_res[0].$curl_res[2];
				Log::error('kapi_error ' . $post_param['service_name'].'耗时：'.$duration.'s '.json_encode($curl_res));
			}
		} else {
			$res['msg'] = '未定义service_name或param';
		}
		return $res;
	}
	
	/**
	 * 获取请求结果
	 * @param  array $cfg
	 * @param  number $time_out
	 * @param  string $pret
	 * @return number[]|string[]
	 */
	public function getResult($cfg=array(), $time_out=2, $pret=false) {
		$res = array(
				'error' => 100
		);
		if(empty($cfg)){
			$cfg = $this->getDefautConfig();
		}
		
		$post_param = $this->getParam();
		if(isset($post_param['service_name'])) {
			$param = array();
			$param['client_id']    = $cfg['client_id'];
			$param['secret_state'] = strtoupper(md5($cfg['client_id'].$cfg['secret_key'].'_kaikela@'));
			$param['token'] 	   = strtoupper(md5(time()));
			$param = array_merge($param, $post_param);
			ksort($param);
			$tmp_param = $param;
			$this->clearParamForFign($tmp_param);
			$signstr = $this->getSignStr($tmp_param);
			$sign	 = strtoupper(md5($signstr.'secret_key='.strtoupper(md5($cfg['client_id'].$cfg['secret_key']))));
			$param['sign'] = $sign;
			$param = $this->getFianlParam($param);
			
			$start_time = microtime(true);
			$curl_res = $this->my_curl($cfg['api_url'], json_encode($param), 'POST', $time_out, array('Content-Type: application/json;charset=utf-8'));
			$duration = microtime(true)-$start_time;
			if(200 == $curl_res[0]) {
				if($pret) {
					$json_arr = json_decode($curl_res[1], true);
					if($json_arr['success']) {
						$res['error'] = 0;
						$res['data']  = $json_arr['data'];
					} else {
						$res['msg'] = $json_arr['message'];
					}
				} else {
					$res['error'] = 0;
					$res['data']  = $curl_res[1];
				}
				Log::info('kapi_ok', $post_param['service_name'].'耗时：'.$duration.'s ');
			} else {
				$res['msg'] = $post_param['service_name'].'KAPI调用失败'.$curl_res[0].$curl_res[2];
				Log::error('kapi_error', $post_param['service_name'].'耗时：'.$duration.'s '.json_encode($curl_res));
			}
		} else {
			$res['msg'] = '未定义service_name';
		}
		return $res;
	}
	
	/**
	 * 清洗数组
	 * @param array $param
	 */
	private function clearParamForFign(&$param){
		foreach ($param as $k=>$v) {
			if(is_array($v)) {
				$this->clearParamForFign($param[$k]);
			} else {
				if ('' === $v || null === $v) {
					unset($param[$k]);
				}
			}
		}
	}
	
	/**
	 * 获取最终数组
	 * @param array $param
	 */
	private function getFianlParam($param) {
		ksort($param);
		if(is_array($param)) {
			foreach ($param as $k=>$par) {
				if(is_array($par)) {
					if($par['type'] == 'map' && empty($par['val'])) {
						$param[$k] = (object)$par['val'];
					} else {
						$param[$k] = $this->getFianlParam($par['val']);
					}
				}
			}
		}
		return $param;
	}
	
	/**
	 * 获得签名字符串
	 * @param array  $param
	 * @param string $secret_key
	 */
	private function getSignStr($param) {
		$str = '';
		foreach ($param as $k=>$v) {
			if(is_array($v)) {
				$str .= $k.'='.$this->arraytostr($v).'&';
			} else {
				$str .= $k.'='.$v.'&';
			}
		}
		
		return $str;
	}
	
	private function arraytostr($v){
		$tmp_str = '';
		if($v['type'] == 'list') {
			if(empty($v['val'])) {
				$tmp_str .= '[]';
			} else {
				asort($v['val']);
				if(is_array($v['val'][0])) {
					$tmp_arr = array();
					foreach ($v['val'] as $vv) {
						$tmp_arr[] = $this->arraytostr($vv);
					}
					asort($tmp_arr);
					$tmp_str .= implode('', $tmp_arr);
				} else {
					foreach ($v['val'] as $vv) {
						$tmp_str .= $vv;
					}
				}
			}
		} else if($v['type'] == 'map') {
			if(empty($v['val'])) {
				$tmp_str .= '{}';
			} else {
				ksort($v['val']);
				foreach ($v['val'] as $kk=>$vv) {
					if(is_array($vv)) {
						$tmp_str .= $kk.'='.$this->arraytostr($vv).'&';
					} else {
						$tmp_str .= $kk.'='.$vv.'&';
					}
				}
				$tmp_str = mb_substr($tmp_str, 0, -1, 'utf-8');
			}
		}
		
		return $tmp_str;
	}
	
	/**
	 * 设置请求参数
	 * @param array $param
	 * @return MstKapi
	 */
	public function setParam($param) {
		self::$param = $param;
		return $this;
	}
	
	/**
	 * 获取参数
	 * @return array
	 */
	public function getParam() {
		return self::$param;
	}
	
	private static function my_curl($url, $vars='', $method='GET', $timeout=2, $header=array()) {
		if(0 === stripos($url, 'http')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
			if(0 === stripos($url, 'https')) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				//curl_setopt($ch, CURLOPT_CAINFO, APPLICATION_PATH.'/application/library/cacert.pem');
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			}
	
			if('POST' === $method){
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
			}
	
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	
			$data = curl_exec($ch);
	
			$res[0] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$res[1] = $data;
			if($res[0] != 200){
				$res[2] = curl_error($ch);
			}
			curl_close($ch);
			return $res;
		} else {
			throw new \Exception('invalid url');
		}
	}

    /**
     * @param $serviceName
     * @param $params
     * @return []
     */
    public function getResultNew($serviceName, $params = [], $method = "POST", $config = [])
    {
        $reqParams = [
            'service_name' => $serviceName,
            'param'	=> $params
        ];

        $kapi = MstKapi::getInstance();
        $kapi->setParam($reqParams);
        $res = $this->getResultV2($config, 10, false, $method);

        //兼容java返回数据结构不一致
        if(isset($res['data'])) {
            $data = json_decode($res['data'], true);
            if(isset($data['data'])) $res['data'] = $data['data'];
            else $res['data'] = $data;
        }

        //返回未成功
        if(isset($data['success']) && !$data['success']) {
            $res['error'] = $data['nCode'] ?? 1;
            $res['msg'] = $data['message'] ?? '操作失败';
            return $res;
        }

        if($res['error'] != 0) {
            Log::error('kapi_error:'  . $serviceName . ' params:' .
                print_r($params, true) . ' res:' . print_r($res, true));
        }

        return $res;
    }
	
	
	/**
	 * Hide constructor, protected so only subclasses and self can use
	 */
	protected function __construct() {}
	
	function __destruct(){}
	
}