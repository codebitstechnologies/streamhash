<?php

namespace App\Http\Controllers;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

use Setting;
use Log;
use Session;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\User;
use App\UserPayment;
use Auth;
use App\AdminVideo;
use App\PayPerView;

 
class PaypalController extends Controller {
   
    private $_api_context;
 
    public function __construct() {
       
        // setup PayPal api context

        $paypal_conf = config('paypal');

        $paypal_conf['client_id'] = envfile('PAYPAL_ID') ?  envfile('PAYPAL_ID') : $paypal_conf['client_id'];
        $paypal_conf['secret'] = envfile('PAYPAL_SECRET') ?  envfile('PAYPAL_SECRET') : $paypal_conf['secret'];
        $paypal_conf['settings']['mode'] = envfile('PAYPAL_MODE') ?  envfile('PAYPAL_MODE') : $paypal_conf['settings']['mode'];

        Log::info("PAYPAL CONFIGURATION".print_r($paypal_conf,true));
        
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));

        $this->_api_context->setConfig($paypal_conf['settings']);
   
    }


    public function pay(Request $request) {

        $total = Setting::get('amount') ? Setting::get('amount') : "1.00" ;

		$item = new Item();

		$item->setName(Setting::get('site_name')) // item name
				   ->setCurrency('USD')
			   ->setQuantity('1')
               ->setPrice($total);
	 
        $payer = new Payer();
        
        $payer->setPaymentMethod('paypal');

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item));
        $total = $total;
        $details = new Details();
        $details->setShipping('0.00')
            ->setTax('0.00')
            ->setSubtotal($total);


        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total)
        	->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Payment for the Request');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('/user/payment/status'))
                    ->setCancelUrl(url('/user/payment/status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                echo "Payment" . $payment."<br />";

                $err_data = json_decode($ex->getData(), true);
                echo "Error" . print_r($err_data);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {

            $user_payment = UserPayment::where('user_id' , $request->id)->first();
            $expiry_days = Setting::get('expiry_days' , 30);

            if($user_payment) {

                if($user_payment) {
                    $expiry_date = $user_payment->expiry_date;
                    $user_payment->expiry_date = date('Y-m-d', strtotime($expiry_date. "+".$expiry_days." days"));
                }
            } else {
                $user_payment = new UserPayment;
                $user_payment->expiry_date = date('Y-m-d H:i:s',strtotime("+".$expiry_days." days"));
            }

            $user_payment->payment_id  = $payment->getId();
            $user_payment->user_id = $request->id;
            $user_payment->save();

            $response_array = array('success' => true); 

            return redirect()->away($redirect_url);
        }

        return response()->json(Helper::null_safe($response_array) , 200);
                    
    }
    

    public function getPaymentStatus(Request $request) {

        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        
        // clear the session payment ID
     
        if (empty($request->PayerID) || empty($request->token)) {
        	
		  return back()->with('flash_error','Payment Failed!!');

		} 
            
     
        $payment = Payment::get($payment_id, $this->_api_context);
     
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
     
        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);
     
       // echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later
     
        if ($result->getState() == 'approved') { // payment made

            $payment = UserPayment::where('payment_id',$payment_id)->first();
            $payment->status = 1;
            $payment->amount = Setting::get('amount');

            $payment->save();

            

            if($payment) {
                if($user = User::find($payment->user_id)) {
                    $user->user_type = 1;
                    $user->save();
                }
            }

            Session::forget('paypal_payment_id');
            
            $response_array = array('success' => true , 'message' => "Payment Successful" ); 

            $responses = response()->json($response_array);

            $response = $responses->getData();

            // return back()->with('flash_success' , 'Payment Successful');

            return redirect()->route('user.profile')->with('response', $response);
       
        } else {

            return back()->with('flash_error' , 'Payment is not approved. Please contact admin');
        }
            
           
    }
   

    public function videoSubscriptionPay(Request $request) {

        // Load Video id
        $video = AdminVideo::where('id', $request->id)->first();

        $total = $video->amount;

        $item = new Item();

        $item->setName(Setting::get('site_name')) // item name
                   ->setCurrency('USD')
               ->setQuantity('1')
               ->setPrice($total);
     
        $payer = new Payer();
        
        $payer->setPaymentMethod('paypal');

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item));
        $total = $total;
        $details = new Details();
        $details->setShipping('0.00')
            ->setTax('0.00')
            ->setSubtotal($total);


        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Payment for the Request');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('/user/payment/video-status'))
                    ->setCancelUrl(url('/user/payment/video-status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                echo "Payment" . $payment."<br />";

                $err_data = json_decode($ex->getData(), true);
                echo "Error" . print_r($err_data);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {

            $user_payment = PayPerView::where('user_id' , Auth::user()->id)->where('amount',0)->first();

            if(empty($user_payment)) {
                $user_payment = new PayPerView;
            }
            $user_payment->expiry_date = date('Y-m-d H:i:s');
            $user_payment->payment_id  = $payment->getId();
            $user_payment->user_id = Auth::user()->id;
            $user_payment->video_id = $request->id;
            $user_payment->save();

            $response_array = array('success' => true); 

            return redirect()->away($redirect_url);
        }

        return response()->json(Helper::null_safe($response_array) , 200);
                    
    }
    

    public function getVideoPaymentStatus(Request $request) {

        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        
        // clear the session payment ID
     
        if (empty($request->PayerID) || empty($request->token)) {
            
          return back()->with('flash_error','Payment Failed!!');

        } 
            
     
        $payment = Payment::get($payment_id, $this->_api_context);
     
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
     
        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);
     
       // echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later
     
        if ($result->getState() == 'approved') { // payment made

            $payment = PayPerView::where('payment_id',$payment_id)->first();
            // $payment->status = 1;
            $payment->amount = $payment->adminVideo->amount;

            $payment->save();

            Session::forget('paypal_payment_id');
            
            $response_array = array('success' => true , 'message' => "Payment Successful" ); 

            $responses = response()->json($response_array);

            $response = $responses->getData();

            // return back()->with('response', $response);
            // ->with('flash_success' , 'Payment Successful');

            return redirect()->route('user.single' , $payment->video_id)->with('flash_success', $response);
       
        } else {

            return back()->with('flash_error' , 'Payment is not approved. Please contact admin');
        }
            
           
    }
   
}
