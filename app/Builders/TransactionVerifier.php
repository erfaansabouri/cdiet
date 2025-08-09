<?php

namespace App\Builders;

use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;

class TransactionVerifier {
    private User   $user;
    private Plan   $plan;
    private string $gateway;
    private string $token;

    public function setUser ( User $user ): TransactionVerifier {
        $this->user = $user;

        return $this;
    }

    public function setPlan ( Plan $plan ): TransactionVerifier {
        $this->plan = $plan;

        return $this;
    }

    public function setGateway ( string $gateway ): TransactionVerifier {
        $this->gateway = $gateway;

        return $this;
    }

    public function setToken ( string $token ): TransactionVerifier {
        $this->token = $token;

        return $this;
    }

    public function verify () {
        $transaction = Transaction::query()
                                  ->firstOrCreate([ 'token' => $this->token ] , [
                                      'user_id' => $this->user->id ,
                                      'plan_id' => $this->plan->id ,
                                      'gateway' => $this->gateway ,
                                  ]);
        if ( $transaction->wasRecentlyCreated ) {
            $transaction->update([
                                     'verified_at' => now() ,
                                 ]);

            return true;
        }
        else {
            return false;
        }
    }
}
