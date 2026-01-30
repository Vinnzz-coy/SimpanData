@forelse ($peserta as $p)
    <tr class="peserta-row hover:bg-gray-50 transition-colors duration-150" 
        data-nama="{{ strtolower($p->nama) }}" 
        data-jenis="{{ strtolower($p->jenis_kegiatan) }}" 
        data-status="{{ strtolower($p->status) }}">
        <td class="px-4 py-3">{{ $peserta->firstItem() + $loop->index }}</td>
        <td class="px-4 py-3 font-medium text-gray-800">
            {{ $p->nama }}
        </td>
        <td class="px-4 py-3">
            @if($p->jenis_kegiatan == 'PKL')
                <span class="px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full">
                    PKL
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-700">
                    Magang
                </span>
            @endif
        </td>
        <td class="px-4 py-3">
            @if($p->status == 'Aktif')
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                    Aktif
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">
                    Selesai
                </span>
            @endif
        </td>
    </tr>
@empty
    <tr id="noDataRow">
        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
            Belum ada data peserta
        </td>
    </tr>
@endforelse
