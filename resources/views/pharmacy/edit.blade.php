<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add new pharmacy
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="container mx-auto py-4">
            <form accept-charset="UTF-8" enctype="multipart/form-data"
                  method="POST"
                  action="{{ route('pharmacies.update', $pharmacy)  }}">
                @csrf
                @method('PUT')

                <div class="flex flex-wrap my-3">
                    <label for="name" class="w-full">Pharmacy name:</label>
                    <input class="w-full p-2" type="text" id="name" name="name" value="{{ $pharmacy->name }}" placeholder="Pharmacy name" autofocus>
                    @error('name')
                    <span>{{ $message }}</span>
                    @enderror
                </div>


                <div class="flex flex-wrap my-3">
                    <select name="location_id" class="w-full border rounded p-2">
                        @php $locations = \App\Models\Location::all() @endphp
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->address }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full">
                        <button type="submit" class="bg-blue-700 text-white font-bold text-lg p-2 rounded-sm">Update</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>