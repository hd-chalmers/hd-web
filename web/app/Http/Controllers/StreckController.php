<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class StreckController extends Controller
{
    public function print() {
        $last = Account::whereActive(1)->where('uid', 'LIKE', 'USL%')->orderBy('uid', 'desc')->first();
        $last = (int)substr($last->uid, 3);
        return view('streck.print')->with('users', Account::whereActive(1)->orderBy('id')->get())
            ->with('last', $last)->with('inactive', Account::whereActive(0)->orderBy('id')->get());
    }
}
