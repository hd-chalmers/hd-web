<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StreckController extends Controller
{
    public function print ()
    {
        $last = Account::whereActive(1)->where('uid', 'LIKE', 'USL%')->orderBy('uid', 'desc')->first();
        $last = (int) substr($last->uid ?? '000000', 3);
        return view('streck.print')->with('users', Account::whereActive(1)->where('print', '=', 'true')->orderBy('id')->get())
            ->with('last', $last)->with('inactive', Account::whereActive(0)->where('print', '=', 'true')->orderBy('id')->get());
    }

    public function getAccounts ()
    {
        return [
            'active'   => Account::whereActive(1)->orderBy('id')->get(),
            'inactive' => Account::whereActive(0)->orderBy('id')->get(),
        ];
    }

    public function newAccount (Request $request)
    {
        return DB::transaction(function () use ($request) {
            $account = new Account();
            $account->name = $request->input('name');
            $account->uid = $request->input('uid');
            $account->password = $request->input('password') ?? '';
            $account->active = $request->input('active') ?? TRUE;
            $account->print = $request->input('print') ?? TRUE;
            $account->balance = 0;
            $account->save();
            return $account;
        });
    }

    public function deleteAccount (Account $account)
    {
        $account->delete();
    }

    public function updateAccount (Request $request, Account $account)
    {
        return DB::transaction(function () use ($request, $account) {
            $account->name = $request->input('name');
            $account->uid = $request->input('uid');
            $account->password = $request->input('password');
            $account->active = $request->input('active');
            $account->print = $request->input('print');
            $account->save();
            return $account;
        });
    }
}
