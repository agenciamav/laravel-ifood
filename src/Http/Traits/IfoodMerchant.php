<?php

namespace Agenciamav\LaravelIfood\Http\Traits;

trait IfoodMerchant
{
    public function initializeIfoodMerchant()
    {
        $this->fillable[] = 'ifood_merchant_id';
        $this->fillable[] = 'ifood_authorization_code';
        $this->fillable[] = 'ifood_authorization_code_verifier';
        $this->fillable[] = 'ifood_access_token';
        $this->fillable[] = 'ifood_refresh_token';
    }

    public static function merchant(...$parameters)
    {
        // dd(request()->user()->currentTeam);

        // $merchant = static::newMerchant() ?: Merchant::merchantForModel(get_called_class());
    }
}
