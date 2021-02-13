<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
  public function logout(Request $request)
  {
    Auth::user()->tokens()->where('id', Auth::user()->currentAccessToken()->id)->delete();

    return response()->json([
      'message' => 'Successfully logged out'
    ])->setStatusCode(200);
  }
}
