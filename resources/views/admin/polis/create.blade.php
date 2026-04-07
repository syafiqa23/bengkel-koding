<x-layouts.app title="Tambah Poli">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('polis.index') }}" class="inline-flex items-center justify-center w-9 h-9 
                  rounded-lg bg-slate-100 text-slate-500 
                  hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Poli
        </h2>
    </div>

    {{-- Card Form --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('polis.store') }}" method="POST">
                @csrf

                {{-- Input Nama Poli --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Poli <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                        name="nama_poli"
                        value="{{ old('nama_poli') }}"
                        placeholder="Masukkan nama poli..."
                        class="w-full px-4 py-3 rounded-lg border-2 focus:border-[#2d4499] focus:outline-none transition
                                  {{ $errors->has('nama_poli') ? 'border-red-500' : 'border-slate-200' }}"
                        required>

                    @error('nama_poli')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Keterangan --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Keterangan <span class="text-red-500">*</span>
                    </label>

                    <textarea name="keterangan"
                        rows="4"
                        placeholder="Masukkan keterangan poli..."
                        class="w-full px-4 py-3 rounded-lg border-2 focus:border-[#2d4499] focus:outline-none transition
                                     {{ $errors->has('keterangan') ? 'border-red-500' : 'border-slate-200' }}"
                        required>{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 
           rounded-lg text-white font-semibold text-sm
           shadow-sm transition duration-200
           hover:shadow-md active:scale-95"
                        style="background-color:#2f4bb2;"
                        onmouseover="this.style.backgroundColor='#263d91'"
                        onmouseout="this.style.backgroundColor='#2f4bb2'">

                        <i class="fas fa-floppy-disk text-sm"></i>
                        Simpan
                    </button>

                    <a href="{{ route('polis.index') }}"
                        class="inline-flex items-center px-5 py-2.5 
           rounded-lg bg-slate-100 hover:bg-slate-200 
           text-slate-600 font-semibold text-sm transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>