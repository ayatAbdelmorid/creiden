<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use GuzzleHttp\Client;

class Admin extends Model implements Authenticatable
{
    use Notifiable;
    use AuthenticableTrait;

        protected $guard = 'admin-api';

        protected $fillable = [
            'name', 'email', 'password','api_token',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        public function wordpressToken(){
            $client = new Client();
            // $res = $client->get('http://wrordpresscreiden.pro/index.php/wp-json/jwt-auth/v1/token', ['auth' =>  ['admin', 'admin123456']]);
            $res = $client->request('POST',  env('WP_URL','').'/index.php/wp-json/jwt-auth/v1/token', [
                 "form_params" => ["username"=> "admin","password"=>"12345678"]
            ]);
            $response_status=$res->getStatusCode(); // 200
            $response=json_decode($res->getBody(), true);
            return $response['token'];

        }
}
