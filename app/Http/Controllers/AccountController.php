<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Account;
use App\Models\Device;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $accounts = Account::orderByDesc('id')->get();
        $accounts = $accounts->filter(function(Account $account)
        {
            return $account->devices->count() > 0;
        });
        $accounts = PaginationHelper::paginate($accounts, 10);
        return view('list_accounts', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plans = Plan::all();
        return view('account_form', compact('plans'));
    }

    public function add_device(Account $account)
    {
        $plans = Plan::all();
        // return $account;
        return view('account_form', compact('plans', 'account'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $rules = [
            'username' => 'required',
            'passwd' => 'required',
            'plan_id' => 'required',
            'customer_name' => 'required',
            'phone' => 'required',
            'started_at' => 'required',
        ];

        if (!$request->calculate)
            $rules = Arr::add($rules, 'finished_at', 'required');
        // return $rules;

        $messages = [
            '*.required' => 'Este campo es obligatorio.'
        ];

        $validated = $request->validate($rules, $messages);

        // $started_at = Carbon::createFromFormat('d/m/Y', $request->started_at)->format('Y-m-d');
        $started_at = $request->started_at;
        $plan = Plan::find($request->plan_id);
        $an_account = (is_null($request->an_account) ? 0 : $request->an_account);

        if ($request->calculate)
            $finished_at = Carbon::create($started_at)->addMonths($plan->months);
        else
            $finished_at = $request->finished_at;

        $account = Account::create([
            'username' => $request->username,
            'password' => $request->passwd,
            'plan_id' => $request->plan_id,
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'active' => true
        ]);
        
        $device = Device::create([
            'name' =>  $request->customer_name,
            'phone' => $request->phone,
            'account_id' => $account->id,
            'quantity' => $request->quantity,
            'plan_id' => $request->plan_id,
            'an_account' => $an_account,
            'additional_data' => $request->additional_data,
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'active' => true
        ]);
        return redirect()->route('accounts.index');
    }

    public function store_add_device(Request $request)
    {
        // return $request;
        $rules = [
            'plan_id' => 'required',
            'customer_name' => 'required',
            'phone' => 'required',
            'started_at' => 'required',
        ];

        if (!$request->calculate)
            $rules = Arr::add($rules, 'finished_at', 'required');
        
        $messages = [
            '*.required' => 'Este campo es obligatorio.'
        ];
        // return 
        $validated = $request->validate($rules, $messages);
        
        // $started_at = Carbon::createFromFormat('d/m/Y', $request->started_at)->format('Y-m-d');
        $started_at = $request->started_at;
        $account = Account::find($request->account_id);
        $plan = Plan::find($request->plan_id);
        $an_account = (is_null($request->an_account) ? 0 : $request->an_account);

        if ($request->calculate)
            $finished_at = Carbon::create($started_at)->addMonths($plan->months);
        else
            // $finished_at = Carbon::createFromFormat('d/m/Y', $request->finished_at)->format('Y-m-d');
            $finished_at = $request->finished_at;
        
        $device = Device::create([
            'name' =>  $request->customer_name,
            'phone' => $request->phone,
            'account_id' => $account->id,
            'quantity' => $request->quantity,
            'plan_id' => $request->plan_id,
            'an_account' => $an_account,
            'additional_data' => $request->additional_data,
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'active' => true
        ]);
        return redirect()->route('accounts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $account = Account::find($id);
        $plans = Plan::all();
        $state = 'account_edition';
        return view('account_edit', compact('plans', 'account', 'state'));
        // return $account;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request;
        $rules = [
            'username' => 'required',
            'passwd' => 'required',
            'plan_id' => 'required',
            'started_at' => 'required',
        ];

        if (!$request->calculate)
            $rules = Arr::add($rules, 'finished_at', 'required');

        $messages = [
            '*.required' => 'Este campo es obligatorio.'
        ];

        $validated = $request->validate($rules, $messages);

        $started_at = $request->started_at;
        $plan = Plan::find($request->plan_id);

        if ($request->calculate)
            $finished_at = Carbon::create($started_at)->addMonths($plan->months);
        else
            $finished_at = $request->finished_at;

        $account = Account::find($id);
        $account->update([
            'username' => $request->username,
            'password' => $request->passwd,
            'plan_id' => $request->plan_id,
            'started_at' => $started_at,
            'finished_at' => $finished_at,
        ]);

        return redirect()->route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = Account::find($id);
        $account->devices()->delete();
        $account->delete();
        return redirect()->back();
    }
}
