<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-wrap p-4">
                @if(\Illuminate\Support\Facades\Auth::user()->role->name === 'administrator')
                    <!-- Admin user -->
                    <div class="mx-auto p-16 w-4/12 border rounded-3xl border-dashed border-gray-700">
                        <p class="text-center font-black">
                            Users: {{ \App\Models\User::count() }}
                        </p>
                    </div>
                    <div class="w-full my-3"></div>
                    <div class="mx-auto p-16 w-4/12 border rounded-3xl border-dashed border-gray-700">
                        <p class="text-center font-black">
                            Pharmacies: {{ \App\Models\Pharmacy::count() }}
                        </p>
                    </div>
                    <div class="w-full my-5"></div>
                    <hr class="bg-black h-1">
                    <div class="w-full">
                        <a class="float-right bg-green-600 text-white mx-auto border rounded-md px-4 py-2 text-xl font-semibold" href="{{ route('pharmacies.create') }}">
                            Add new pharmacy
                        </a>
                        <div class="clear-both"></div>
                    </div>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->role->name === 'pharmacist')
                        <!-- pharmacist user -->
                        @php
                            $pharmacies = \App\Models\Pharmacy::where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->get();
                        @endphp
                        @foreach($pharmacies as $pharmacy)
                            <div class="w-full my-4">
                                <table class="text-center w-full mx-auto border">
                                    <thead class="text-xl border rounded-lg">
                                        <tr>
                                            <th>Pharmacy name</th>
                                            <th>Number of medicines</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        <tr>
                                            <td>
                                                <span class="font-semibold block">{{ $pharmacy->name }}</span>
                                                <span class="text-sm text-gray-300 block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                                            </td>
                                            <td>
                                                {{ count($pharmacy->medicines) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('pharmacies.edit', $pharmacy) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                        <!-- contact us -->
                        <div class="w-full mb-4">
                            <a class="text-white bg-indigo-700 border rounded-md px-3 py-1 text-xl font-bold float-right" href="{{ route('contact.us') }}">Contact us</a>
                            <div class="clear-both"></div>
                        </div>
                        {{--
                            notification
                        --}}
                        <search-medicine></search-medicine>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
