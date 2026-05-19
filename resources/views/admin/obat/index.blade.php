<x-layouts.app title="Data Obat">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Data Obat
        </h2>

        <a href="{{ route('obat.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 
                  bg-primary hover:bg-primary/90 
                  text-white text-sm font-semibold 
                  rounded-xl transition">
            <i class="fas fa-plus text-xs"></i>
            Tambah Obat
        </a>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2 border">
        <div class="card-body p-0">

            <div class="overflow-x-auto">
                <table class="table w-full">

                    {{-- Table Head --}}
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Obat</th>
                            <th class="px-6 py-4">Kemasan</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Stok</th>
                            <th class="px-6 py-4">Kelola Stok</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="text-sm text-slate-700">
                        @forelse($obats as $obat)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $obat->nama_obat }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold 
                                             rounded-full bg-green-100 text-green-600">
                                    {{ $obat->kemasan ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                @if($obat->isStokHabis())
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-600">
                                    <i class="fas fa-circle-exclamation"></i>
                                    Habis
                                </span>
                                @elseif($obat->isStokMenipis())
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-600">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    Menipis: {{ $obat->stok }}
                                </span>
                                @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-600">
                                    <i class="fas fa-circle-check"></i>
                                    {{ $obat->stok }}
                                </span>
                                @endif
                                <div class="text-[11px] text-slate-400 mt-1">Batas: {{ $obat->stok_minimum }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <form action="{{ route('obat.update-stok', $obat->id) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="tipe" class="select select-bordered select-sm rounded-lg">
                                        <option value="tambah">Tambah</option>
                                        <option value="kurang">Kurangi</option>
                                    </select>
                                    <input type="number" name="jumlah" min="1" value="1"
                                        class="input input-bordered input-sm w-20 rounded-lg">
                                    <button type="submit" class="btn btn-sm bg-[#2d4499] hover:bg-[#1e2d6b] text-white border-none rounded-lg">
                                        Simpan
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('obat.edit', $obat->id) }}" class="inline-flex items-center gap-1 px-4 py-2 
                                              bg-amber-500 hover:bg-amber-600 
                                              text-white text-xs font-semibold 
                                              rounded-lg transition">
                                        <i class="fas fa-pen text-xs"></i>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus obat ini?')" class="inline-flex items-center gap-1 px-4 py-2 
                                                   bg-red-500 hover:bg-red-600 
                                                   text-white text-xs font-semibold 
                                                   rounded-lg transition">
                                            <i class="fas fa-trash text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada data obat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</x-layouts.app>
