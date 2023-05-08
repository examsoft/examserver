<?php


namespace App\Http\Controllers\Common;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Libraries\Captcha;

class CommonController extends BaseController
{

    public function users()
    {
        try {
            $captcha = new Captcha();
            $data = $captcha->create();
        } catch (\Exception $e) {
            $data = $e->getMessage();
        }
        return $data;
    }


}
