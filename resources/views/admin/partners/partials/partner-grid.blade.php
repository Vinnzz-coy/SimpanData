<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @forelse($partners as $partner)
        <div class="relative overflow-hidden transition-all duration-300 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:-translate-y-1 group">
            <div class="relative flex items-center justify-center p-6 border-b border-gray-100 aspect-video bg-gray-50">
                @if($partner->logo)
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama }}" class="object-contain w-full h-full">
                @else
                    <div class="flex items-center justify-center w-20 h-20 bg-gray-200 rounded-full">
                        <i class='text-4xl text-gray-400 bx bx-image'></i>
                    </div>
                @endif
            </div>
            <div class="p-5">
                <h3 class="mb-1 text-lg font-bold text-gray-900 line-clamp-1" title="{{ $partner->nama }}">{{ $partner->nama }}</h3>
                <p class="mb-3 text-sm text-gray-500 line-clamp-2">{{ $partner->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                <div class="flex items-center h-5 gap-2 mb-4 text-sm text-gray-600">
                    <i class='text-gray-400 bx bx-map'></i>
                    <span class="truncate">{{ $partner->alamat ?? '-' }}</span>
                </div>

                <div class="flex gap-2 pt-4 mt-auto border-t border-gray-100">
                    <a href="{{ route('admin.partners.edit', $partner->id) }}" class="flex-1 px-3 py-2 text-sm font-medium text-center text-indigo-600 transition-colors rounded-lg bg-indigo-50 hover:bg-indigo-100">
                        Edit
                    </a>
                    <button type="button"
                            data-delete-id="{{ $partner->id }}"
                            data-name="{{ $partner->nama }}"
                            class="flex-1 px-3 py-2 text-sm font-medium text-center text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="py-12 text-center col-span-full">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gray-50">
                <i class='text-3xl text-gray-400 bx bx-buildings'></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada data partner</h3>
            <p class="mt-1 text-gray-500">Silakan tambahkan partner baru.</p>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $partners->links() }}
</div>
