<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
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
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Traits\PaymentTrait;
use PayPal\Api\InputFields;
use PayPal\Api\WebProfile;

class PaypalController extends Controller
{
    use PaymentTrait;

    private $_api_context;

    public function __construct()
    {
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function postPaymentWithpaypal(Request $request)
    {
        session()->flash('checkoutRequest', $request->all());

        $currency_code = env('APP_CURRENCY_Code', 'USD');

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = [];

        foreach (Cart::instance('default')->content() as $product) {

            $item = new Item();

            $item->setName($product->name)
                ->setCurrency($currency_code)
                ->setQuantity($product->qty)
                ->setPrice($product->price);

            array_push($items, $item);

        }

        // Add Discount To Paypal Details
        $discount_item = new Item();
        $discount_item->setName( __('frontend.discount') )
        ->setCurrency($currency_code)
        ->setQuantity(1)
        ->setPrice(( with_discount()->get('discount') * -1 ));

        array_push($items, $discount_item);

        $item_list = new ItemList();
        $item_list->setItems($items);

        $amountDetails = new Details();
        $amountDetails->setSubtotal(with_discount()->get('new_subtotal'));
        $amountDetails->setTax(with_discount()->get('new_tax'));

        $amount = new Amount();
        $amount->setCurrency($currency_code)
            ->setTotal(with_discount()->get('new_total'))
            ->setDetails($amountDetails);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Online Payment');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url()->route('status'))
            ->setCancelUrl(url()->route('status'));

        // No Shipping
        $inputFields = new InputFields();
        $inputFields->setNoShipping(1);
        $webProfile = new WebProfile();
        $webProfile->setName('test' . uniqid())->setInputFields($inputFields);
        $webProfileId = $webProfile->create($this->_api_context)->getId();


        $payment = new Payment();
        $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction))
        ->setExperienceProfileId($webProfileId);

        try {
            $payment->create($this->_api_context);
        } catch (\Exception $ex) {
            if (config()->get('app.debug')) {
                return redirect()->back()->with('error', __('frontend.connection_timeout'));
            } else {
                return redirect()->back()->with('error', __('frontend.error_occur_sorry_for_inconvenient'));
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        session()->flash('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
            return redirect()->away($redirect_url);
        }

    	return redirect()->back()->with( 'error', __('frontend.unknown_error_occurred') );
    }

    public function getPaymentStatus(Request $request)
    {
        $payment_id = session()->get('paypal_payment_id');

        session()->forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return redirect()->route('cart.index')->with('error', __('frontend.payment_failed'));
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            $checkoutRequest = new \Illuminate\Http\Request();

            $checkoutRequest->replace(session()->get('checkoutRequest'));

            $order = $this->make_order($checkoutRequest);

            $order->update([
                'is_paid' => true,
                'payment_method' => 'paypal',
            ]);

            return redirect()->route('checkout.finish')->with('success', __('frontend.order_completed_successfully'));

        }

		return redirect()->route('cart.index')->with('error', __('frontend.payment_failed'));
    }
}
