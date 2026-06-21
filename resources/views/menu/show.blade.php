<x-app-layout>

    <div class="max-w-4xl py-6 mx-auto">

        <h2 class="text-2xl font-bold">
            {{ $food->nama }}
        </h2>

        <br>

        @if ($food->foto)
            <img src="{{ asset('storage/' . $food->foto) }}" width="300">
        @endif

        <br><br>

        <p>{{ $food->deskripsi }}</p>

        <br>

        <p>
            Harga: Rp {{ number_format($food->harga) }}
        </p>

        <p>
            Stok: {{ $food->stok }}
        </p>

        <p>
            Alamat: {{ $food->alamat }}
        </p>

        <p>
            Pickup: {{ $food->pickup_time }}
        </p>

        <br>

        <form action="{{ route('orders.store', $food) }}" method="POST">
            @csrf

            <label>Jumlah:</label>

            <input type="number" name="qty" value="1" min="1" max="{{ $food->stok }}">

            <button type="submit">
                Pesan Sekarang
            </button>
        </form>

    </div>

</x-app-layout>
