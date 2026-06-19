<x-app-layout>

    <div class="max-w-4xl py-6 mx-auto">

        <h2 class="mb-4 text-2xl font-bold">
            Tambah Makanan
        </h2>

        @if ($errors->any())
            <div style="background:#fee2e2;padding:10px;margin-bottom:20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label>Nama Makanan</label>
            <input type="text" name="nama" class="w-full border" required>
        </div>

        <br>

        <div>
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="w-full border"></textarea>
        </div>

        <br>

        <div>
            <label>Harga</label>
            <input type="number" name="harga" class="w-full border" required>
        </div>

        <br>

        <div>
            <label>Stok</label>
            <input type="number" name="stok" class="w-full border" required>
        </div>

        <br>

        <div>
            <label>Jenis</label>

            <select name="jenis" class="w-full border">
                <option value="real_food">
                    Real Food
                </option>

                <option value="gacha">
                    Gacha
                </option>
            </select>
        </div>

        <br>

        <div>
            <label>Alamat</label>

            <input type="text" name="alamat" class="w-full border" required>
        </div>

        <br>

        <div>
            <label>Jam Pickup</label>

            <input type="time" name="pickup_time" class="w-full border" required>
        </div>

        <br>

        <div>
            <label>Foto</label>

            <input type="file" name="foto">
        </div>

        <br>

        <button type="submit"
            style="background:#2563eb;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">
            Simpan
        </button>
        </form>

    </div>

</x-app-layout>
