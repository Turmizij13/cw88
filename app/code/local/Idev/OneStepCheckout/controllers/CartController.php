<?php
require_once  Mage::getModuleDir('controllers', 'Mage_Checkout').DS.'CartController.php';
class Idev_OneStepCheckout_CartController extends Mage_Checkout_CartController
{
    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {

        if ($returnUrl = $this->getRequest()->getParam('return_url')) {
            // clear layout messages in case of external url redirect
            if ($this->_isUrlInternal($returnUrl)) {
                $this->_getSession()->getMessages(true);
            }
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            //if config enabled, clear messages and redirect to checkout
            if(Mage::getStoreConfig('onestepcheckout/direct_checkout/redirect_to_cart')){

                $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                $allowedGroups = Mage::getStoreConfig('onestepcheckout/direct_checkout/group_ids');

                if(!empty($allowedGroups)){
                    $allowedGroups = explode(',',$allowedGroups);
                } else {
                    $allowedGroups = array();
                }

                if(!in_array($customerGroupId, $allowedGroups)){

                    $this->_getSession()->getMessages(true);
                    $this->_redirect('onestepcheckout', array('_secure'=>true));
                } else {
                    $this->_redirect('checkout/cart');
                }

            } else {
                $this->_redirect('checkout/cart');
            }


        }
        return $this;
    }
  	public function ajaxAddCartAction(){
   		$result = array('success'=>false,msg=>'','isHtml'=>false,'_html'=>'');
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }
            $product = $this->_initProduct();
            if (!$product) {
                $result['msg'] = $this->__('Product does not exist!');
            }else{
            	$cart->addProduct($product, $params);
            	$cart->save();
            	$this->_getSession()->setCartWasUpdated(true);
            	if (!$cart->getQuote()->getHasError()) {
                    $result['msg']= $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
                    $result['success']=true;
                }
            }
        }catch (Exception $e) {
            $result['msg'] = $this->__('Cannot add the item to shopping cart.'); 
            Mage::logException($e);
        }
        $this->getResponse()->setBody(json_encode($result));
   }
   public function ajaxViewCartAction(){
   		$this->loadLayout();
   		$this->getResponse()->setBody($this->getLayout()->getBlock('checkout.cart')->toHtml());
   }
}
