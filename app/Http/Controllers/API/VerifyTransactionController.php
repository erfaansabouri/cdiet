<?php

namespace App\Http\Controllers\API;

use App\Builders\TransactionVerifier;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyTransactionController extends Controller {
    private function verify ( Request $request , $gateway ) {
        $request->validate([
                               'token' => 'required' ,
                               $gateway . '_plan_id' => 'required' ,
                           ]);
        $user = Auth::user();
        $token = $request->get('token');
        $plan_id = $request->get($gateway . '_plan_id');
        $gateway_url = $this->getGatewayUrl($gateway , $plan_id , $token);
        $gateway_response = Http::withHeaders([
                                                  'X-Access-Token' => config('services.myket.x_access_token') ,
                                              ])
                                ->get($gateway_url);
        if ( $gateway_response->status() !== 200 ) {
            return util()->throwError('پرداخت با شکست مواجه شد!');
        }
        $plan = Plan::query()
                    ->throughGateway($gateway , $plan_id)
                    ->firstOrFail();
        $transaction_verifier = ( new TransactionVerifier() )->setToken($token)
                                                             ->setUser($user)
                                                             ->setPlan($plan)
                                                             ->setGateway(Transaction::GATEWAYS[ $gateway ]);
        if ( $transaction_verifier->verify() ) {
            $user->addCredit($plan->days);

            return util()->simpleSuccess('اعتبار با موفقیت به حساب شما افزوده شد!');
        }
        else {
            return util()->throwError('اعتبار قبلا به حساب شما افزوده شده است.');
        }
    }

    private function getGatewayUrl ( $gateway , $plan_id , $token ) {
        switch ( $gateway ) {
            case 'myket':
                return 'https://developer.myket.ir/api/applications/' . config('services.myket.package_name') . '/purchases/products/' . $plan_id . '/tokens/' . $token;
            case 'bazaar':
                return 'https://pardakht.cafebazaar.ir/devapi/v2/api/validate/' . config('services.bazaar.package_name') . '/inapp/' . $plan_id . '/purchases/' . $token . '?access_token=' . util()->bazaarAccessToken();
            // Add other gateways here if needed
            default:
                return '';
        }
    }

    /**
     * @OA\Post(
     *     path="/api/verify-transactions/myket",
     *     summary="Verify myket transaction",
     *     tags={"Verify transactions"},
     *     	 @OA\Parameter(
     *         description="purchase unique token",
     *         in="query",
     *         name="token",
     *         required=true,
     *         example="purchase_unique_token",
     *         @OA\Schema(type="string"),
     *     ),
     *     	 @OA\Parameter(
     *         description="myket_plan_id",
     *         in="query",
     *         name="myket_plan_id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function myket ( Request $request ) {
        return $this->verify($request , Transaction::GATEWAYS[ 'myket' ]);
    }

    /**
     * @OA\Post(
     *     path="/api/verify-transactions/bazaar",
     *     summary="Verify bazaar transaction",
     *     tags={"Verify transactions"},
     *     	 @OA\Parameter(
     *         description="purchase unique token",
     *         in="query",
     *         name="token",
     *         required=true,
     *         example="purchase_unique_token",
     *         @OA\Schema(type="string"),
     *     ),
     *     	 @OA\Parameter(
     *         description="bazaar_plan_id",
     *         in="query",
     *         name="bazaar_plan_id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function bazaar ( Request $request ) {
        return $this->verify($request , Transaction::GATEWAYS[ 'bazaar' ]);
    }
}
