<?php
class MageProfis_PaypalExpress_Model_Observer 
{
    public function checkAgreements( $event )
    {
        $controller = $event->getControllerAction();
        $controller_name = $controller->getRequest()->getControllerName();
        $action_name = $controller->getRequest()->getActionName();
            $requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds();
            if ($requiredAgreements) {
                $postedAgreements = array_keys($controller->getRequest()->getPost('agreement', array()));
                if (array_diff($requiredAgreements, $postedAgreements)) {
                    Mage::getSingleton('paypal/session')->addError(Mage::helper('paypal')->__('Please agree to all the terms and conditions before placing the order.'));
                    Mage::app()->getResponse()->setRedirect(Mage::getUrl('*/*/review'))->sendResponse();
                    //$this->_redirect('*/*/review');
                    exit;
                }
            }
    }
}

