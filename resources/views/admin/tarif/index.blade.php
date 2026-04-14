<x-layouts.admin title="Tarif Parkir">
    <div class="space-y-6">
        <!-- Header & Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tarif Parkir</h1>
                <p class="text-gray-600 text-sm mt-1">Total: {{ $tarif->total() }} tarif</p>
            </div>
            <a href="{{ route('admin.tarif.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Tarif
            </a>
        </div>

        @include('admin.partials.index-search', [
            'action' => route('admin.tarif.index'),
            'placeholder' => 'Cari jenis kendaraan...',
            'q' => $q,
        ])

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Jenis Kendaraan</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-700">Tarif / Jam</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($tarif as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $t->jenis_kendaraan }}</td>
                                <td class="px-6 py-3 text-right text-gray-900 font-semibold">Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.tarif.edit', $t) }}" class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.tarif.destroy', $t) }}" method="POST" class="inline single-delete-form"
                                              data-name="{{ $t->jenis_kendaraan }}">
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
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Tidak ada tarif ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $tarif->links() }}
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
                    const name = form.dataset.name || 'item ini';
                    openModal(`Anda yakin ingin menghapus tarif "${name}"?`, () => form.submit());
                });
            });
            btnCancel?.addEventListener('click', closeModal);
            btnOk?.addEventListener('click', () => { if (pendingSubmit) pendingSubmit(); closeModal(); });
            modal?.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        });
    </script>
</x-layouts.admin>