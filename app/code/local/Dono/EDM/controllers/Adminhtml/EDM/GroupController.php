<?php
class Dono_EDM_Adminhtml_Edm_GroupController extends Mage_Adminhtml_Controller_Action{
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
	public function editAction(){
		if($id = $this->getRequest()->getParam('id')){
			$group = Mage::getModel('edm/group')->load($id);
			Mage::register('group', $group);
		}
		$this->loadLayout();
		$this->renderLayout();
	}
	public function saveAction(){
		try{
			if($post = $this->getRequest()->getPost()){
				$model = Mage::getModel('edm/group');
				if(isset($post['group_id'])){
					if(isset($post['group_name'])&&$post['group_name']){
						$model->load($post['group_id']);
						$model->setData('group_name',$post['group_name']);
						$model->setData('status',$post['status']);
						$model->save();
					}else{
						throw Exception('Group name can not be null!');
					}
				}else{
					if(isset($post['group_name'])){
						$model->load($post['group_name'],'group_name');
						if(!$model->getId()){
							$model->setData('group_name',$post['group_name']);
							$model->setData('status',$post['status']);
							$model->save();
						}else{
							throw Exception('Group name:%s already existed!',$post['group_name']);
						}
					}else{
						throw Exception('Group name can not be null!');
					}
				}	
			}
		}catch (Exception $e){
			
		}
		$this->_redirect('*/*/index');
	}
}