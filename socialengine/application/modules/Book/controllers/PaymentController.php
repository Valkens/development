<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: IndexController.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_PaymentController extends Core_Controller_Action_Standard
{
    public $paypalIpnUrl = 'https://www.sandbox.paypal.com';

    public function successAction() {}

    public function notifyAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $arrPost = $this->getRequest()->getPost();

        if ($this->_validateNotify($arrPost)) {
            $table = Engine_Api::_()->getDbtable('orders', 'book');

            $values['userid'] = 1;
            $values['total'] = $arrPost['mc_gross'];
            $values['date'] = date('Y.m.d H:i:s');

            $table->insert($values);
        }
    }

    private function _validateNotify($arrPost)
    {
        $postdata="";
        foreach ($arrPost as $key=>$value) {
            $postdata.=$key."=".urlencode($value)."&";
        }

        $postdata .= "cmd=_notify-validate";
        $curl = curl_init($this->paypalIpnUrl);
        curl_setopt ($curl, CURLOPT_HEADER, 0);
        curl_setopt ($curl, CURLOPT_POST, 1);
        curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 1);
        $response = curl_exec ($curl);
        curl_close ($curl);

        if ($response != 'VERIFIED' && !$this->sandbox)
            throw new Exception('Invalid IPN Transaction : ');
        elseif ($arrPost["mc_gross"] == "")
            throw new Exception('Invalid IPN mcgross : not set');
        elseif ($arrPost["payment_status"] != "Completed" && !$this->sandbox)
            throw new Exception('Invalid IPN payment_status : ' . $arrPost["payment_status"]);
        elseif ($arrPost["txn_id"] == "")
            throw new Exception('Invalid IPN txn_id : not set ');
        elseif ($arrPost["txn_type"] != "web_accept")
            throw new Exception('Invalid IPN wrong txn_type ');
        else
            return true;
    }
}
