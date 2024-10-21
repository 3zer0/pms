<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Item;
use App\Models\Delivery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserPrivilege;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Models\UserJurisdiction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generateQrCode()
    {
        $qrCode = QrCode::size(300)->generate('https://www.example.com');

        return view('qrcode', compact('qrCode'));
    }
}
