<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 


class CustomerController extends Controller
{

    public function showLogin()
    {
        return view('login');
    }
    

    public function index()
    {
        $add_customer_details = Customer::all();

        foreach ($add_customer_details as $customer) {
            
            $dateDifferenceLast = Carbon::parse($customer->date)->diffInDays(Carbon::parse($customer->previous_date));
            $dateDifferencePrevious = $dateDifferenceLast * 2;
            
            $chargeFirstRange = $dateDifferenceLast * 20;
            $chargeSecondRange = $dateDifferencePrevious * 35;

            $lastMeterReading = $customer->meter_reading_value;
    
            
            $customer->chargeFirstRange = $chargeFirstRange;
            $customer->chargeSecondRange = $chargeSecondRange;

            $unitsFirstRange = $dateDifferenceLast;
            $unitsSecondRange = $dateDifferencePrevious;

            
            $unitsThirdRange = $lastMeterReading - ($unitsFirstRange + $unitsSecondRange);


            $perUnitChargeThirdRange = 40;
            $totalChargeThirdRange = 0;

            if ($unitsThirdRange > 0) {
                for ($i = 0; $i < $unitsThirdRange; $i++) {
                    $totalChargeThirdRange += $perUnitChargeThirdRange;
                    $perUnitChargeThirdRange++;
                }
            }

            
            $chargeFirstRange = $unitsFirstRange * 20;
            $chargeSecondRange = $unitsSecondRange * 35;

            $fixedCharge = 1500;

            $totalCharge = $fixedCharge + $chargeFirstRange + $chargeSecondRange + $totalChargeThirdRange;
            
        }

        return view('customers.index', compact('add_customer_details'));
    }



    public function showBillingDetails(Request $request)
    {
        $customerAccountNumber = $request->input('customer_account_number');

        $customer = Customer::where('customer_account_number', $customerAccountNumber)->first();

        if (!$customer) {
            return redirect()->back()->withErrors(['login_error' => 'Invalid customer account number.']);
        }

        $lastReadingDate = $customer->date;
        $previousReadingDate = $customer->previous_date;
        $lastMeterReading = $customer->meter_reading_value;
        $previousMeterReading = $customer->previous_meter_reading;

        $dateDifferenceLast = Carbon::parse($lastReadingDate)->diffInDays(Carbon::parse($previousReadingDate));
        $dateDifferencePrevious = $dateDifferenceLast * 2;

        $unitsFirstRange = $dateDifferenceLast;
        $unitsSecondRange = $dateDifferencePrevious;

        $fixedCharge = 1500;
        $perUnitChargeFirstRange = 20;
        $perUnitChargeSecondRange = 35;

        
        $unitsThirdRange = $lastMeterReading - ($unitsFirstRange + $unitsSecondRange);

        $perUnitChargeThirdRange = 40;
        $totalChargeThirdRange = 0;

        if ($unitsThirdRange > 0) {
            for ($i = 0; $i < $unitsThirdRange; $i++) {
                $totalChargeThirdRange += $perUnitChargeThirdRange;
                $perUnitChargeThirdRange++;
            }
        }

        // Calculate total charges
        $chargeFirstRange = $unitsFirstRange * $perUnitChargeFirstRange;
        $chargeSecondRange = $unitsSecondRange * $perUnitChargeSecondRange;

        $totalCharge = $fixedCharge + $chargeFirstRange + $chargeSecondRange + $totalChargeThirdRange;

        return view('billing_details', compact(
            'lastReadingDate', 'previousReadingDate', 'lastMeterReading', 'previousMeterReading',
            'fixedCharge', 'chargeFirstRange', 'chargeSecondRange', 'totalCharge'
        ));
    }

    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_account_number' => 'required|numeric',
            'date' => ['required', 'regex:/^\d{2}-\d{2}-\d{4}$/'],
            'meter_reading_value' => 'required|numeric',
        ]);

        
        $existingCustomer = DB::table('ceb_customers')
            ->where('customer_account_num', $validatedData['customer_account_number'])
            ->first();

        if (!$existingCustomer) {
            return redirect()->back()->withErrors(['login_error' => 'Invalid user account number.']);
        }

        if (!$validatedData['date'] || !Carbon::createFromFormat('d-m-Y', $validatedData['date'])) {
            return redirect()->back()->withErrors(['date_error' => 'Please enter date in correct format (dd-mm-YYYY)']);
        }
        
        
        $validatedData['date'] = Carbon::createFromFormat('d-m-Y', $validatedData['date'])->format('Y-m-d');

        
        $customerRecord = Customer::where('customer_account_number', $validatedData['customer_account_number'])
            ->first();

        if ($customerRecord) {
            
            $previousDate = $customerRecord->date;
            $previousMeterReading = $customerRecord->meter_reading_value;

            
            $customerRecord->update([
                'date' => $validatedData['date'],
                'meter_reading_value' => $validatedData['meter_reading_value']
            ]);

            
            $customerRecord->previous_date = $previousDate;
            $customerRecord->previous_meter_reading = $previousMeterReading;
        } 
        else {
            // Create a new record
            Customer::create($validatedData);
        }

        return redirect()->route('customers.index');
    }



}
