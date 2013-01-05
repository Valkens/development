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
<<<<<<< HEAD
    public $paypalIpnUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    public function successAction()
    {
        Zend_Session::namespaceUnset('BookCart');
    }
=======
    public $paypalIpnUrl = 'https://www.sandbox.paypal.com';

    public function successAction() {}
>>>>>>> 64e68526d93c35157204ed114e4a6471a2ab4c87

    public function notifyAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

<<<<<<< HEAD
        $arrPost = $this->_request->getPost();

        if ($this->validateNotify()) {
            $arr = explode(':', $arrPost['item_number1']);
            $values['owner_id'] = $arr[1];
            $values['total'] = $arrPost['mc_gross'];
            $values['count'] = $arrPost['num_cart_items'];
            $values['date'] = date('Y-m-d H:i:s');

            $table = Engine_Api::_()->getDbtable('orders', 'book');
            $db = $table->getDefaultAdapter();

            $table->insert($values);

            $orderId = $db->lastInsertId();
            $table = Engine_Api::_()->getDbtable('orderdetails', 'book');

            for ($i = 1; $i <= $arrPost['num_cart_items']; $i++)
            {
                $detail['order_id'] = $orderId;
                $detail['book_id'] = $arrPost['item_number' . $i];
                $detail['quantity'] = $arrPost['quantity' . $i];

                $table->insert($detail);
            }
        }
    }

    public function validateNotify()
    {
        // STEP 1: Read POST data
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();

        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;

        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        file_put_contents(dirname(__FILE__) . '/res', $req);
        // STEP 2: Post IPN data back to paypal to validate
        $ch = curl_init($this->paypalIpnUrl);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if( !($res = curl_exec($ch)) ) {
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // STEP 3: Inspect IPN validation result and act accordingly
        if (strcmp ($res, "VERIFIED") == 0) {
            return true;
        }

        return false;
    }

=======
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
>>>>>>> 64e68526d93c35157204ed114e4a6471a2ab4c87
}
