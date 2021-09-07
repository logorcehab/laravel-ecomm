<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Log;
use Validator;
use DateTime;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{

    public function index()
    {
        return view('customer.auth.login');
    }  
      

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput($request->all());
        //

        $customer = Customer::where('phone_number', $request->input('phone_number'))->first();
        if($customer === null)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone_number' => 'required|unique:customers',
            ]);
            if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput($request->all());           
            //
            $customer = Customer::create([
                'name'=>$request->input('name'),
                'phone_number' => $request->input('phone_number'),
                'customer_id' => \Str::random(8, true),
                'code' => rand(100000,999999),
                'code_changed_at'=> new DateTime('NOW')
            ]);
        }
        // TODO checkLastChanged()
        $customer->code = rand(100000,999999);
        $customer->code_changed_at = new DateTime('NOW');
        $customer->save();
        // TODO Send OTP to whatsapp
        return redirect()->route('customer.verify.index',$customer->customer_id)->withInput($request->all());
    }
    public function verification(Customer $customer){
        $customer = Customer::where('customer_id', $customer->customer_id)->first();
        return view('customer.auth.verify',[
            'customer_name'=>$customer->name,
            'customer_phone'=>$customer->phone_number,
            'customer_id'=>$customer->customer_id
        ]);
    }
    
    public function verify(Request $request, Customer $customer){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput($request->all());
        //
        $customer = Customer::where('customer_id', $customer->customer_id)->first();
        if ($customer === null) return redirect()->back()->withErrors(['customer'=>'Customer does not exist'])->withInput($request->all());
        if ($customer->code === 'null' || $this->getMinuteDiff($customer->code_changed_at) > 15) return redirect()->back()->withErrors(['code'=>'Code expired Re-Generate Code'])->withInput($request->all());
        if ($customer->code !== $request->input('code')) 
            return redirect()->back()->withErrors(['code'=>'Invalid Code'])->withInput($request->all());
        if ($customer->is_verified == false)
        {
            $customer->is_verified = true;
            $customer->save();
        }
        $customer->code = 'null';
        $customer->save();
        Auth::guard('customer')->login($customer);
        return redirect()->route('homepage');
    }
    
    private function getMinuteDiff (String $time_str)
    {
        $time = new DateTime($time_str);
        $mins = $time->diff(new DateTIme('NOW'))->days * 24 * 60;
        $mins+= $time->diff(new DateTIme('NOW'))->h *60;
        $mins+= $time->diff(new DateTIme('NOW'))->i;
        return $mins;
    }   

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect()->route('homepage');
    }
}