<?php

class Openstream_GeoIP_Model_Observer
{
	private $CountryCodeToCurrencyCode = array(
		'US'  =>'USD',
		'CN'  =>'CNY',
		'AU'  =>'AUD',
		'HK'  =>'HKD',
		'GB'  =>'GBP',
		'CL'  =>'CLP',
		'MX'  =>'MXN',
		'ZA'  =>'ZAR',
	);
	
	 public function controllerFrontInitBefore($observer)
    {
		$session = Mage::getSingleton('core/session');
		$geoip = Mage::app()->getFrontController()->getRequest()->getParam('geoip');
		$response = Mage::app()->getFrontController()->getResponse();
		if(isset($geoip)){
			$session->setData('geoip',$geoip);
			$gip = $geoip;
		}else{
			$gip = $session->getData('geoip');
			if(!isset($gip)){
				$gip = 1;
			}
		}
		if(isset($gip)&&!$gip){
			return true;
		}
        $country = Mage::getModel('geoip/country');
		$code = $country->getCountry();
		
        
		$url = '';
		
		if(strtolower($code)==='cn'){
			$url = 'http://catwalk88.tmall.com/';	
		}else{
			$url = 'subscribe.html';
		}
		$response->setRedirect($url);
		$response->sendResponse();
	}

	public function controllerFrontSwitchCurrency($observer){
		$session = Mage::getSingleton('core/session');
		$country = Mage::getModel('geoip/country');
		$code = $country->getCountry();
		$autoCurrency = $session->getData('autocurrency');
		Mage::log('autocurrency:'.$autoCurrency);
		if(!$autoCurrency){
			Mage::log('autocurrency: skip');
		}else{
			Mage::log('autocurrency: process');
			if($currencyCode = $this->CountryCodeToCurrencyCode[$code]){
				Mage::app()->getStore()->setCurrentCurrencyCode($currencyCode);
			}else{
				Mage::app()->getStore()->setCurrentCurrencyCode(Mage::app()->getStore()->getBaseCurrencyCode());
			}
		}
	}

}
