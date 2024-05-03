<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\HttpLog;

trait ClientHttp
{
    public function getBuyUrlService(): array
    {
        $urlWarehouseService    = config('alegra_services.URL_BUY_INGREDIENTS_SERVICE');

        return [
            'buyLogin'                    =>  $urlWarehouseService . 'api/login/',
            'buyIngredient'               =>  $urlWarehouseService . 'marker/'
        ];
    }

    public function getUrlOrderService(): array
    {
        $urlOrderService =  config('alegra_services.URL_ORDER_INGREDIENTS_SERVICE');
        return [
            'orderLogin'                    =>  $urlOrderService  . 'api/login/',
            'receiveIngredient'           =>  $urlOrderService . 'api/job/receive_ingredient'
        ];
     }

    public function sendHttp(string $url, array $params = [], string $method = 'POST', $authorization = []): array
    {
        try {
            $resp = ['status' => true, 'data' => [], 'msg' => 'ok', 'url' => $url];
            $body = json_encode($params);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60000); // Aumentar el tiempo de espera a 60 segundos (o cualquier valor adecuado)
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $headers = $authorization;
            $head    = [
                'Authorization:  Bearer ' . (isset($headers['token']) ? $headers['token'] : ''),
                'Content-Type: application/json'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                $resp['status'] = false;
                $resp['msg']    = curl_error($ch);
            }
            $resp['data'] = json_decode($response, true);
        } catch (\Throwable $e) {
            $resp['status'] = false;
            $resp['msg'] = 'error->' . $e->getMessage() . ' line->' . $e->getLine() . ' file->' . $e->getFile();
            return $resp;
        }
        $resp['code'] = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        // $resp['time'] = curl_getinfo($ch, CURLINFO_STARTTRANSFER_TIME);
        // $resp['time'] = round($resp['time'] * 1000);
        return $resp;
    }

    public function toLoginBuyService($isSistem = false)
    {
        $output['status'] = false;
        $output['msg']    = 'Usuario no logeado';

        $email = !$isSistem ? Auth::user()->email : config('alegra_services.EMAIL_SYSTEM');
        $autUser = ['email' =>$email, 'password' => 'test'];
        $login   = $this->sendHttp(
            $this->getBuyUrlService()['buyLogin'],
            $autUser,
            'POST',
            []
        );
        $this->saveHttpLog( $autUser , $login, 1, $login['status']??false , $this->getBuyUrlService()['buyLogin']);

        if ($login && isset($login['data']['status']) && $login['data']['status']) {
            $output['status'] = true;
            $output['token'] =  $login['data']['authorisation']['token'];
            $output['msg']   = 'login ok';
            return $output;
        }
    }


    public function toLoginOrderService($isSistem = false)
    {
        $output['status'] = false;
        $output['msg']    = 'Usuario no logeado';

        $password = !$isSistem ? Auth::user()->password : config('alegra_services.PASSWORD_SYSTEM');
        $email    = !$isSistem ? Auth::user()->email : config('alegra_services.EMAIL_SYSTEM');
        $autUser  = ['email' =>$email, 'password' => $password];
        $login    = $this->sendHttp(
            $this->getUrlOrderService()['orderLogin'],
            $autUser,
            'POST',
            []
        );
        $this->saveHttpLog( $autUser , $login, 1, $login['status']??false , $this->getBuyUrlService()['buyLogin']);

        if ($login && isset($login['data']['status']) && $login['data']['status']) {
            $output['status'] = true;
            $output['token'] =  $login['data']['authorisation']['token'];
            $output['msg']   = 'login ok';
            return $output;
        }
    }

    public function saveHttpLog($body, $response, $typeId, $statusId, $url, $logHttpId = false)
    {
        if ($logHttpId) {
            $dbLog = HttpLog::where('id', $logHttpId)->first();
            $dbLog->response = json_encode($response);
            $dbLog->status = $statusId;
        } else {
            $dbLog = new HttpLog();
            $dbLog->body = json_encode($body);
            $dbLog->type = $typeId;
            $dbLog->response = json_encode($response);
            $dbLog->url = $url;
            $dbLog->status = $statusId;
        }
        $dbLog->save();
    }
}
