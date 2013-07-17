<?php
class Dono_EDM_Adminhtml_Edm_CustomerController extends Mage_Adminhtml_Controller_Action{
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
	public function editAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
	public function saveAction(){
		try{
			if($post = $this->getRequest()->getPost()){
				$model = Mage::getModel('edm/customer');
				if(isset($post['customer_id'])){
					if(isset($post['email'])&&$post['email']){
						$model->load($post['customer_id']);
						$model->setData($post);
						$model->save();
					}else{
						throw Exception('Email can not be null!');
					}
				}else{
					if(isset($post['email'])){
						$model->load($post['email'],'email');
						if(!$model->getId()){
							$model->setData($post);
							$model->save();
						}else{
							throw Exception('Email name:%s already existed!',$post['email']);
						}
					}else{
						throw Exception('Email can not be null!');
					}
				}
			}
		}catch (Exception $e){
				
		}
		$this->_redirect('*/*/index');
	}
}