<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500 text-white p-4 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ Auth::user()->role === 'admin' ? route('admin.transaksi.store') : route('kasir.transaksi.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Layer 1 - Data Penjualan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="text" value="{{ now()->format('d-m-Y H:i') }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kasir</label>
                            <input type="text" value="{{ Auth::user()->name }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bayar</label>
                            <input type="text" inputmode="numeric" id="input-bayar-display" value="{{ old('bayar') }}" oninput="handleBayarInput(this)" placeholder="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <input type="hidden" name="bayar" id="input-bayar" value="{{ old('bayar') }}">
                        </div>
                    </div>
                </div>

                <div class="page-card p-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Layer 2 - Detail Penjualan</h3>
                        <x-button color="success" x-data="" x-on:click="$dispatch('open-modal', 'modal-tambah-barang')">
                            <i class="fas fa-plus mr-2"></i> Tambah Barang
                        </x-button>
                    </div>

                    <div id="detail-items" class="space-y-2"></div>

                    <div class="mt-4 border-t pt-3 space-y-2">
                        <div class="flex items-center justify-between text-sm font-semibold text-gray-700">
                            <span>Total</span>
                            <span id="detail-total">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-semibold" id="kembalian-row">
                            <span class="text-gray-700">Kembalian</span>
                            <span id="detail-kembalian" class="text-gray-700">Rp 0</span>
                        </div>
                    </div>

                    <div id="detail-inputs"></div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="btn-primary px-4 py-2 rounded-lg">
                            Simpan Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-modal name="modal-tambah-barang" focusable>
        <div class="p-6 m-0">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Tambah Barang</h4>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                    <select id="modal-produk" class="mt-1 block w-full rounded border-gray-300"></select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input id="modal-jumlah" type="number" min="1" value="1" class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <x-button color="secondary" type="button" x-on:click="show = false">
                    Batal
                </x-button>
                <x-button color="primary" type="button" onclick="addItemToList()">
                    Tambah
                </x-button>
            </div>
        </div>
    </x-modal>

    <script>
        const produkList = @json($produkList);
        let transactionItems = [];

        function closeItemModal() {
            document.getElementById('modal-jumlah').value = 1;
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }

        function getTotal() {
            return transactionItems.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
        }

        function updateKembalian() {
            const total = getTotal();
            const bayar = Number(document.getElementById('input-bayar').value) || 0;
            const kembalian = bayar - total;
            const el = document.getElementById('detail-kembalian');

            el.textContent = formatCurrency(kembalian);
            el.classList.toggle('text-red-500', kembalian < 0);
            el.classList.toggle('text-gray-700', kembalian >= 0);
        }

        // Field Bayar: yang dilihat user pakai titik ribuan (500.000),
        // tapi yang dikirim ke server angka murni tanpa titik (500000)
        function handleBayarInput(el) {
            const raw = el.value.replace(/\D/g, ''); // buang semua selain angka
            const numberValue = raw ? parseInt(raw, 10) : 0;

            el.value = raw ? numberValue.toLocaleString('id-ID') : '';
            document.getElementById('input-bayar').value = numberValue;

            updateKembalian();
        }

        function renderItems() {
            const detailItems = document.getElementById('detail-items');
            const detailInputs = document.getElementById('detail-inputs');
            detailItems.innerHTML = '';
            detailInputs.innerHTML = '';

            if (transactionItems.length === 0) {
                detailItems.innerHTML = '<div class="rounded border border-dashed border-gray-300 p-3 text-sm text-gray-500">Belum ada barang yang dipilih.</div>';
                document.getElementById('detail-total').textContent = formatCurrency(0);
                updateKembalian();
                return;
            }

            let total = 0;

            transactionItems.forEach((item, index) => {
                const subtotal = item.harga * item.jumlah;
                total += subtotal;

                const row = document.createElement('div');
                row.className = 'flex flex-col md:flex-row md:items-center md:justify-between rounded border p-3';
                row.innerHTML = `
                    <div>
                        <p class="font-semibold text-gray-800">${item.name}</p>
                        <p class="text-sm text-gray-500">${item.jumlah} x ${formatCurrency(item.harga)}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-gray-700">${formatCurrency(subtotal)}</span>
                        <button type="button" onclick="removeItem(${index})" class="text-sm text-red-600">Hapus</button>
                    </div>
                `;
                detailItems.appendChild(row);

                const hiddenProduk = document.createElement('input');
                hiddenProduk.type = 'hidden';
                hiddenProduk.name = 'produk_id[]';
                hiddenProduk.value = item.product_id;
                detailInputs.appendChild(hiddenProduk);

                const hiddenJumlah = document.createElement('input');
                hiddenJumlah.type = 'hidden';
                hiddenJumlah.name = 'jumlah[]';
                hiddenJumlah.value = item.jumlah;
                detailInputs.appendChild(hiddenJumlah);
            });

            document.getElementById('detail-total').textContent = formatCurrency(total);
            updateKembalian();
        }

        function addItemToList() {
            const selectedProductId = document.getElementById('modal-produk').value;
            const qty = Number(document.getElementById('modal-jumlah').value);

            if (!selectedProductId || qty < 1) {
                return;
            }

            const product = produkList.find((item) => item.id === selectedProductId);
            if (!product) {
                return;
            }

            transactionItems.push({
                product_id: product.id,
                name: product.name,
                harga: product.harga,
                jumlah: qty
            });

            renderItems();
            closeItemModal();
        }

        function removeItem(index) {
            transactionItems.splice(index, 1);
            renderItems();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('modal-produk');
            select.innerHTML = '';

            produkList.forEach((product) => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.name} - ${formatCurrency(product.harga)}`;
                select.appendChild(option);
            });

            if (produkList.length > 0) {
                select.value = produkList[0].id;
            }

            renderItems();
        });
    </script>
</x-app-layout>