<x-layouts.app title="Data Poli">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-slate-800">
            Data Poli
        </h2>

        <a href="{{ route('polis.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 
                   bg-[#2f4bb2] hover:bg-[#263d91] 
                   text-white text-sm font-medium 
                   rounded-lg shadow-sm transition">
            <i class="fas fa-plus text-xs"></i>
            Tambah Poli
        </a>
    </div>

    {{-- Alert --}}
    @if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 text-red-600 rounded-lg text-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">

                {{-- Head --}}
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama Poli</th>
                        <th class="px-6 py-4 text-left">Keterangan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-slate-200">
                    @forelse($polis as $poli)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $poli->nama_poli }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $poli->keterangan }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">

                                {{-- Edit (KUNING SESUAI GAMBAR) --}}
                                <a href="{{ route('polis.edit', $poli->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5
                                           bg-amber-400 hover:bg-amber-500
                                           text-white text-xs font-medium
                                           rounded-md shadow-sm transition">
                                    <i class="fas fa-pen text-xs"></i>
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('polis.destroy', $poli->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus poli ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-2
                                               bg-red-500 hover:bg-red-600
                                               text-white text-xs font-medium
                                               rounded-md shadow-sm transition">
                                        <i class="fas fa-trash text-xs"></i>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-12 text-slate-400 text-sm">
                            Belum ada data poli
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</x-layouts.app>