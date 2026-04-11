<x-layouts.admin title="Kendaraan">
    <div class="space-y-6">
        <!-- Header & Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kendaraan</h1>
                <p class="text-gray-600 text-sm mt-1">Total: {{ $items->total() }} kendaraan</p>
            </div>
            <a href="{{ route('admin.kendaraan.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Kendaraan
            </a>
        </div>

        @include('partials.flash')

        @include('admin.partials.index-search', [
            'action' => route('admin.kendaraan.index'),
            'placeholder' => 'Cari plat, jenis, warna, merk, atau pemilik...',
            'q' => $q,
        ])

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Plat Nomor</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Jenis</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Warna</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Merk</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Terdaftar</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($items as $k)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $k->plat_nomor }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->jenis_kendaraan }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->warna }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->merk }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $k->is_terdaftar ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $k->is_terdaftar ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.kendaraan.edit', $k) }}" class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.kendaraan.destroy', $k) }}" method="POST" class="inline single-delete-form"
                                              data-plate="{{ $k->plat_nomor }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada kendaraan ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            {{ $items->links() }}
        </div>
    </div>

    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/50 px-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
            <p id="confirm-message" class="mt-2 text-sm text-gray-600"></p>
            <div class="mt-6 flex items-center justify-end gap-2">
                <button type="button" id="confirm-cancel"
                        class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" id="confirm-ok"
                        class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const singleForms = Array.from(document.querySelectorAll('.single-delete-form'));

            const modal = document.getElementById('confirm-modal');
            const msg = document.getElementById('confirm-message');
            const btnCancel = document.getElementById('confirm-cancel');
            const btnOk = document.getElementById('confirm-ok');

            let pendingSubmit = null;

            const openModal = (message, submitFn) => {
                msg.textContent = message;
                pendingSubmit = submitFn;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                pendingSubmit = null;
            };

            singleForms.forEach((form) => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const plate = form.dataset.plate || 'kendaraan ini';
                    openModal(`Anda yakin ingin menghapus ${plate}?`, () => form.submit());
                });
            });

            btnCancel?.addEventListener('click', closeModal);
            btnOk?.addEventListener('click', () => {
                if (pendingSubmit) pendingSubmit();
                closeModal();
            });
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        });
    </script>
</x-layouts.admin>
