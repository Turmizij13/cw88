<?php

/**
 * This class wraps the Template email sending functionality
 * If SMTP Pro is enabled it will send emails using the given 
 * configuration.
 *
 * @author Ashley Schroder (aschroder.com)
 */
 
class Dono_EDM_Model_Email_Template extends Mage_Core_Model_Email_Template {
	
    public function send($email, $name=null, array $variables = array()) {
    	if (false&&!Mage::helper('smtppro')->isEnabled()) {
        	 return parent::send($email, $name, $variables);
		} 
		$emails = array_values((array)$email);
        $names = is_array($name) ? $name : (array)$name;
        $names = array_values($names);
        foreach ($emails as $key => $email) {
            if (!isset($names[$key])) {
                $names[$key] = substr($email, 0, strpos($email, '@'));
            }
        }

        $variables['email'] = reset($emails);
        $variables['name'] = reset($names);
        
        $mail = $this->getMail();
        

       	
        
        foreach ($emails as $key => $email) {
            $mail->addTo($email, '=?utf-8?B?' . base64_encode($names[$key]) . '?=');
        }
        

        $this->setUseAbsoluteLinks(true);
        $text = $this->getProcessedTemplate($variables, true);

        if($this->isPlain()) {
            $mail->setBodyText($text);
        } else {
            $mail->setBodyHTML($text);
        }

        $mail->setSubject('=?utf-8?B?'.base64_encode($this->getProcessedTemplateSubject($variables)).'?=');
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());

		if (method_exists($mail, "setReplyTo")) {
			$mail->setReplyTo('henryzxj1989@gmail.com', 'gmail');
		} else {
        	$mail->addHeader('Reply-To', 'zxj2020@sina.cn');
		}
		$transport = Mage::helper('edm')->getTransport($this->getDesignConfig()->getStore());
        try {
		    
        	Mage::log('About to send email');
	        $mail->send($transport); // Zend_Mail warning..
		    Mage::log('Finished sending email');
	        $this->_mail = null;
        }
        catch (Exception $e) {
        	Mage::logException($e);
            return false;
        }

        return true;
    }
}
