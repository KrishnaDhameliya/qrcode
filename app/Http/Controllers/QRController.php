<?php

namespace App\Http\Controllers;

// require_once('vendor/autoload.php');

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use paytm\paytmchecksum\PaytmChecksum;

class QRController extends Controller
{
    public function generateQrCode()
    {
        QrCode::size(500)
            ->format('png')
            ->generate('by krishna', public_path('uploads/qrcode.png'));
        return view('qr-code');
    }

    public function index()
    {
        $paytmParams = array();

        /* body parameters */
        $paytmParams["body"] = array(

            /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
            "mid" => "oFYyuO97562526070135",

            /* Enter your order id which needs to be check status for */
            "orderId" => "OREDRID98765",
        );

        /**
         * Generate checksum by parameters we have in body
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
         */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "&ByH_xpzDatnkZRo");

        /* head parameters */
        $paytmParams["head"] = array(

            /* put generated checksum value here */
            "signature"    => $checksum
        );

        /* prepare JSON string for request */
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        $url = "https://securegw-stage.paytm.in/v3/order/status";

        /* for Production */
        // $url = "https://securegw.paytm.in/v3/order/status";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);

        print_r($response);
    }
    public function create()
    {
        $code = random_code();
        print_r($code);
    }
}
