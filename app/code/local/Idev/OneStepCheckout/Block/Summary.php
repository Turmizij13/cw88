<?php
/**
 *    OneStepCheckout summary block
 *    @author Jone Eide <mail@onestepcheckout.com>
 *    @copyright Jone Eide <mail@onestepcheckout.com>
 *
 */

class Idev_OneStepCheckout_Block_Summary extends Mage_Checkout_Block_Cart_Totals {

    public function __construct()
    {
        $this->getQuote()->collectTotals()->save();
    }

    public function getItems()
    {
        return $this->getQuote()->getAllVisibleItems();
    }
	/**
	 * (non-PHPdoc)
	 * @see Mage_Checkout_Block_Cart_Totals::getTotals()
	 * @author henryzxj
	 * @link donostudio.com
	 * @desc get more magento plugin from donostudio.com
	 * @todo if coupon code applied to shipping then dicount-total's order should after shipping-total
	 * 		 else should before shipping-total
	 */
    public function getTotals()
    {
        $totals = $this->getQuote()->getTotals();
        if(array_key_exists('discount', $totals)){
			$discount = $totals['discount'];
			if($code = $this->getQuote()->getCouponCode()){
				$coupon = Mage::getModel('salesrule/coupon')->load($code, 'code');
				$rule = Mage::getModel('salesrule/rule')->load($coupon->getRuleId());
				$keys = array_keys($totals);
				$discountKey = array_search('discount', $keys);
				$shippingKey = array_search('shipping', $keys);
				if(!($discountKey&&$shippingKey)) return $totals;
				if($rule->getApplyToShipping()){
					if($discountKey<$shippingKey){
						$keys[$discountKey] = 'shipping';
						$keys[$shippingKey] = 'discount';
					}			
				}else{
					if($discountKey>$shippingKey){
						$keys[$discountKey] = 'shipping';
						$keys[$shippingKey] = 'discount';
					}
				}
				$sortedTotals = array();
				foreach ($keys as $key){
					if(isset($totals[$key])){
						$sortedTotals[$key] = $totals[$key];
					}
				}
				$totals = $sortedTotals;
			}
        }
        return $totals;
    }

    public function getGrandTotal(){
        return $this->getQuote()->getGrandTotal();
    }
}