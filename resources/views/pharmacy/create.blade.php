<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add new pharmacy
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="container mx-auto py-4">
            <form accept-charset="UTF-8" enctype="multipart/form-data" method="POST" action="{{ route('pharmacies.store')  }}">
                @csrf

                <div class="flex flex-wrap my-3">
                    <label for="name" class="w-full">Pharmacy name:</label>
                    <input class="w-full p-2 rounded border" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name" autofocus>
                    @error('name')
                    <span>{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-wrap my-3">
                    <select name="location_id" class="border rounded p-2 w-full">
                        @php $locations = \App\Models\Location::all() @endphp
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->address }}</option>
                        @endforeach
                    </select>
                </div>


                @php
                $users = \App\Models\User::all();
                @endphp
                <div class="flex flex-wrap my-3">
                    <select name="user_id" class="border rounded p-2 w-full">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full">
                        <button type="submit" class="bg-blue-700 text-white font-bold text-lg p-2 rounded-lg">Add</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>