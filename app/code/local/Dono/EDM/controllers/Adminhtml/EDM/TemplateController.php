<?php
class Dono_EDM_Adminhtml_Edm_TemplateController extends Mage_Adminhtml_Controller_Action{
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
				$model = Mage::getModel('edm/template');
				if(isset($post['template_id'])){
					if(isset($post['template_name'])&&$post['template_name']){
						$model->load($post['template_id']);
						$model->setData($post);
						$model->save();
					}else{
						throw Exception('template_name can not be null!');
					}
				}else{
					if(isset($post['template_name'])){
						$model->setData($post);
						$model->save();
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