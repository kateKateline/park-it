<x-layouts.admin title="Area Parkir">
    <div class="space-y-6">
        <!-- Header & Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Area Parkir</h1>
                <p class="text-gray-600 text-sm mt-1">Total: {{ $items->total() }} area</p>
            </div>
            <a href="{{ route('admin.area-parkir.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Area
            </a>
        </div>

        @include('admin.partials.index-search', [
            'action' => route('admin.area-parkir.index'),
            'placeholder' => 'Cari nama area atau keterangan...',
            'q' => $q,
        ])

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Nama Area</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Kapasitas</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Keterangan</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($items as $a)
                            <tr class="hover:bg-gray-50 {{ $a->is_tangguhkan ? 'bg-red-50/30' : '' }}">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $a->nama_area }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $a->kapasitas }} slot</td>
                                <td class="px-6 py-3 text-gray-600 text-xs">{{ Str::limit($a->keterangan, 50) }}</td>
                                <td class="px-6 py-3">
                                    @if ($a->is_tangguhkan)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Ditangguhkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.area-parkir.edit', $a) }}" class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition" title="Edit">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.area-parkir.destroy', $a) }}" method="POST" class="inline single-tangguhkan-form"
                                              data-name="{{ $a->nama_area }}" data-status="{{ $a->is_tangguhkan ? 'aktifkan' : 'tangguhkan' }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 {{ $a->is_tangguhkan ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' : 'bg-orange-50 text-orange-600 hover:bg-orange-100' }} rounded transition"
                                                    title="{{ $a->is_tangguhkan ? 'Aktifkan' : 'Tangguhkan' }}">
                                                <i class="fas {{ $a->is_tangguhkan ? 'fa-check-circle' : 'fa-ban' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada area parkir ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $items->links() }}
        </div>
    </div>

    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/50 px-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-6 shadow-xl">
            <h3 id="confirm-title" class="text-lg font-semibold text-gray-900">Konfirmasi</h3>
            <p id="confirm-message" class="mt-2 text-sm text-gray-600"></p>
            <div class="mt-6 flex items-center justify-end gap-2">
                <button type="button" id="confirm-cancel"
                        class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" id="confirm-ok"
                        class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const singleForms = Array.from(document.querySelectorAll('.single-tangguhkan-form'));
            const modal = document.getElementById('confirm-modal');
            const title = document.getElementById('confirm-title');
            const msg = document.getElementById('confirm-message');
            const btnCancel = document.getElementById('confirm-cancel');
            const btnOk = document.getElementById('confirm-ok');
            let pendingSubmit = null;

            const openModal = (header, message, submitFn) => {
                title.textContent = header;
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
                    const name = form.dataset.name || 'area ini';
                    const status = form.dataset.status;
                    const actionWord = status === 'tangguhkan' ? 'menangguhkan' : 'mengaktifkan';

                    openModal(
                        `Konfirmasi ${status.charAt(0).toUpperCase() + status.slice(1)}`,
                        `Anda yakin ingin ${actionWord} area "${name}"?`,
                        () => form.submit()
                    );
                });
            });

            btnCancel?.addEventListener('click', closeModal);
            btnOk?.addEventListener('click', () => { if (pendingSubmit) pendingSubmit(); closeModal(); });
            modal?.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        });
    </script>
</x-layouts.admin>