<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Rules\MedicineStatus;

class MedicineController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except([
            'show_medicine_in_map',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $validMedicineData = $request->validate([
            'trade_name' => ['required', 'string', 'min:3', 'max:255', 'unique:medicines'],
            'scientist_name' => ['required', 'string', 'min:3', 'max:255', 'unique:medicines'],
            'amount' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'min:1'],
            'status' => ['required', 'string', new MedicineStatus($request->input('amount'))],
            'pharmacy_id' => ['required', 'min:1', 'integer'],
            'company_id' => ['required', 'min:1', 'integer'],
        ]);

        $medicine = new Medicine();
        $medicine->trade_name = $validMedicineData['trade_name'];
        $medicine->scientist_name = $validMedicineData['scientist_name'];
        $medicine->amount = $validMedicineData['amount'];
        $medicine->weight = $validMedicineData['weight'];
        $medicine->status = $validMedicineData['status'];
        $medicine->pharmacy_id = $validMedicineData['pharmacy_id'];
        $medicine->company_id = $validMedicineData['company_id'];
        $medicine->save();

        $request->session()->flash('newMedicineCreatedSuccessfully', 'New medicine created successfully.');
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        return $medicine;
    }

    /**
     * Show medicine in the map.
     *
     * @param Medicine $medicine
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show_medicine_in_map(Medicine $medicine)
    {
        return view('medicine.show-medicine-in-map', [
            'medicine' => $medicine,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicine $medicine)
    {
        return $medicine;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validMedicineData = $request->validate([
            'trade_name' => ['required', 'string', 'min:3', 'max:255', 'unique:medicines'],
            'scientist_name' => ['required', 'string', 'min:3', 'max:255', 'unique:medicines'],
            'amount' => ['required', 'numeric', 'min:1'],
            'weight' => ['required', 'numeric', 'min:1'],
        ]);
        $medicine->update($validMedicineData);
        $request->session()->flash('medicineUpdatedSuccessfully', 'Medicine updated successfully');
        return redirect()->route('medicines.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        request()->session()->flash('medicineDeletedSuccessfully', 'Medicine deleted successfully');
        return redirect()->route('medicines.index');
    }
}
