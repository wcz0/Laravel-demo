<?php

namespace Tests\Unit;

use App\Http\Controllers\LoginController;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Http\Controllers\SendEmail;
use App\Http\Controllers\sendSms;
use Illuminate\Support\Facades\Cookie;
use Exception;
use Oauth;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // $this->assertTrue(true);
        $lc = new LoginController;
    }
}
