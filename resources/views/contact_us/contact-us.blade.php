<x-app-layout>
    <x-slot name="header">
        <h2>Sending email to pulse</h2>
    </x-slot>
    <div class="container mx-auto">
        <form class="max-w-4xl my-32 bg-white border rounded-md shadow-xl mx-auto py-3 px-4" enctype="multipart/form-data" method="POST" action="{{ route('send.email') }}">

            <div class="flex flex-wrap">

                <div class="w-full flex flex-wrap my-3">
                    <label for="name" class="w-full md:w-2/12">Name:</label>
                    <input class="w-full md:w-10/12 border rounded px-3 py-2" type="text" name="name" id="name" autofocus value="{{ \Illuminate\Support\Facades\Auth::user()->name }}">
                    @error('name') <span>{{ $message }}</span> @enderror
                </div>

                <div class="w-full flex flex-wrap my-3">
                    <label for="email" class="w-full md:w-2/12">Email-Address:</label>
                    <input class="w-full md:w-10/12 rounded border px-3 py-2" type="email" name="email" id="email" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}">
                    @error('email') <span>{{ $message }}</span> @enderror
                </div>

                <div class="w-full flex flex-wrap my-3">
                    <label for="message" class="w-full md:w-2/12">Message:</label>
                    <textarea class="w-full md:w-10/12 border rounded px-3 py-2" name="message" id="message"></textarea>
                </div>

                <div class="w-full">
                    <button class="border rounded font-bold text-3xl-center mx-auto block px-6 py-2 bg-blue-700 text-white text-center" type="submit">Send</button>
                </div>

            </div>

        </form>
    </div>
</x-app-layout>