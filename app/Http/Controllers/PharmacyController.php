<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PharmacyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pharmacy::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validPharmacyData = $request->validate([
            'name' => ['string', 'required', 'min:3', 'max:255'],
            'location_id' => ['required', 'min:1', 'integer'],
        ]);

        $pharmacy = new Pharmacy();
        $pharmacy->name = $validPharmacyData['name'];
        $pharmacy->user_id = Auth::user()->id;
        $pharmacy->save();
        $pharmacy->refresh();

        $location = Location::find($validPharmacyData['location_id']);
        $location->pharmacy_id = $pharmacy->id;
        $location->save();

        $request->session()->flash('newPharmacyCreatedSuccessfully', 'New pharmacy created successfully');
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacy $pharmacy)
    {
        return $pharmacy;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Pharmacy $pharmacy)
    {
        return view('pharmacy.edit', [
            'pharmacy' => $pharmacy,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        #return $request;
        $response = Gate::inspect('update', $pharmacy);

        if ($response->allowed())
        {
            $validPharmacyData = $request->validate([
                'name' => ['string', 'required', 'min:3', 'max:255'],
                'location_id' => ['required', 'min:1', 'integer'],
            ]);

            $pharmacy->name = $validPharmacyData['name'];
            $pharmacy->save();
            $pharmacy->refresh();

            $location = Location::find($validPharmacyData['location_id']);
            $location->pharmacy_id = $pharmacy->id;
            $location->save();

            $request->session()->flash('pharmacyUpdatedSuccessfully', 'Pharmacy updated successfully');
            return redirect()->route('pharmacies.index');
        }
        else
        {
            abort(401, $response->message());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        request()->session()->flash('pharmacyDeleteSuccessfully', 'Pharmacy deleted successfully');
        return redirect()->route('pharmacies.index');
    }
}
