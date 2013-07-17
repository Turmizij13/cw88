<?php
require_once(Mage::getModuleDir('controllers','Mage_Checkout').DS.'CartController.php');
class Dono_Checkout_CartController extends Mage_Checkout_CartController
{
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
