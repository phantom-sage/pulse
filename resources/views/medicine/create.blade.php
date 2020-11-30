<x-app-layout>
    <x-slot name="header">
        <h3>Add new medicine</h3>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="container mx-auto">
            <form enctype="multipart/form-data" method="POST" action="{{ route('medicines.store') }}">
                @csrf

                <div class="flex flex-wrap my-3">
                    <label for="trade_name" class="w-full">Trade name:</label>
                    <input class="w-full p-2 border rounded" type="text" name="trade_name" id="trade_name" required autofocus>
                    @error('trade_name') <span>{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-wrap my-3">
                    <label for="scientist_name" class="w-full">Scientist name:</label>
                    <input class="w-full p-2 border rounded" type="text" name="scientist_name" id="scientist_name">
                    @error('scientist_name') <span>{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-wrap my-3">
                    <label class="w-full" for="amount">Amount:</label>
                    <input class="w-full p-2 border rounded" type="number" name="amount" id="amount">
                    @error('amount') <span>{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-wrap my-3">
                    <label class="w-full" for="weight">Weight:</label>
                    <input class="w-full p-2 border rounded" type="number" name="weight" id="weight">
                    @error('weight') <span>{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-wrap my-3">
                    <label for="status" class="w-full">Status</label>
                    <select name="status" class="w-full p-2 rounded border">
                        <option value="N/A">N/A</option>
                        <option value="Available">Available</option>
                    </select>
                </div>

                <div class="flex flex-wrap my-3">
                    <label for="pharmacy">Pharmacy:</label>
                    <select id="pharmacy" name="pharmacy_id" class="w-full rounded border p-2">
                        @foreach(\Illuminate\Support\Facades\Auth::user()->pharmacies as $pharmacy)
                            <option value="{{ $pharmacy->id }}">{{ $pharmacy->name }}</option>
                        @endforeach
                    </select>
                </div>

                @php
                $companies = \App\Models\Company::all();
                @endphp
                <div class="flex flex-wrap my-3">
                    <label for="company">Pharmacy:</label>
                    <select id="company" name="company_id" class="w-full rounded border p-2">
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full">
                        <button class="border rounded-md bg-green-700 text-white p-3 text-lg font-bold" type="submit">Add</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
