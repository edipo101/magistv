<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Plan;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Helpers\PaginationHelper;

class DeviceController extends Controller
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
        $devices = Device::orderBy('account_id')->orderBy('created_at')->paginate(12);
        return view('list_devices', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->s;
        // return $request;
        if(is_null($search))
            return redirect()->route('accounts.index');
        $devices = Device::name($search)->orWhere->phone($search)->get();
        $devicesKeys = $devices->modelKeys();
        $accountsKeys = $devices->pluck('account.id')->unique()->values()->all();
        
        $accounts = Account::whereIn('id', $accountsKeys)->with(array('devices' => function($query) use ($devicesKeys) {
            $query->whereIn('id', $devicesKeys);
        }))->get();
        // $accounts = Account::whereIn('id', $accountsKeys)->with('devices')->get();

        session()->flash('search', $search);
        $accounts = PaginationHelper::paginate($accounts, 10);
        return view('list_accounts', compact('accounts', 'search'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $device = Device::find($id);
        $plans = Plan::all();
        return view('device_edit', compact('plans', 'device'));
        // return $device;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'plan_id' => 'required',
            'started_at' => 'required|date',
            'customer_name' => 'required',
            'phone' => 'required',            
            'an_account' => 'required',            
        ];

        if (!$request->calculate)
            $rules = Arr::add($rules, 'finished_at', 'required|date');

        $messages = [
            '*.required' => 'Este campo es obligatorio.',
        ];

        $validated = $request->validate($rules, $messages);

        // return [$rules, $request->all(), $id];

        $started_at = $request->started_at;
        $plan = Plan::find($request->plan_id);
        $an_account = (is_null($request->an_account) ? 0 : $request->an_account);

        if ($request->calculate)
            $finished_at = Carbon::create($started_at)->addMonths($plan->months);
        else
            $finished_at = $request->finished_at;

        $device = Device::find($id);
        $device->update([
            'name' =>  $request->customer_name,
            'phone' => $request->phone,
            'quantity' => $request->quantity,
            'plan_id' => $request->plan_id,
            'an_account' => $an_account,
            'additional_data' => $request->additional_data,
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
        $device = Device::find($id);
        $device->delete();
        return redirect()->back();
    }
}
