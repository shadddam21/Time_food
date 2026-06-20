@extends('layouts.restaurant')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan Restoran</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi restoran kamu</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Avatar --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-orange-500 flex items-center justify-center text-white text-2xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-lg">{{ $user->name }}</p>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                <span class="inline-block mt-1 px-2 py-0.5 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">Restoran</span>
            </div>
        </div>

        <form action="{{ route('pengaturan.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Restoran</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 bg-gray-50" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 bg-gray-50" required>
            </div>

            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition-colors text-sm mt-2">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
