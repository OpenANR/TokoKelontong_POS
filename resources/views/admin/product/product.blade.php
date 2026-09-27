@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-boxes" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Manajemen Inventaris</p>
                <h1 class="h3 mb-1">Daftar Produk</h1>
                <p class="text-muted mb-0">Kelola master data produk, informasi harga, dan ketersediaan stok toko kelontong.</p>
            </div>
        </div>
        <div class="heading-actions">
            <button class="btn btn-outline-secondary btn-sm" type="button">
                <i class="bi bi-download" aria-hidden="true"></i> Export
            </button>
            <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Produk
            </a>
        </div>
    </div>

    
    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title">
                    <i class="bi bi-box-seam" aria-hidden="true"></i>
                    <span>Tabel Produk</span>
                </h2>
                <p class="text-muted mb-0">Menampilkan seluruh data barang dagangan yang terdaftar.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input type="search" class="form-control form-control-sm table-search" placeholder="Cari nama / kode produk...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" style="width: 60px;">No</th>
                        <th scope="col">Kode Produk</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($product as $item)
                        <tr>
                            <td class="text-center text-muted fw-semibold">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <span class="badge text-bg-light border font-monospace text-primary">
                                    {{ $item->kode_produk }}
                                </span>
                            </td>
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" class="rounded border" style="width: 42px; height: 42px; object-fit: cover;">
                                @else
                                    <span class="badge text-bg-light border text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $item->nama_produk }}</span>
                            </td>
                            <td>
                                <span class="text-muted small text-truncate d-inline-block" style="max-width: 200px;" title="{{ $item->deskripsi }}">
                                    {{ $item->deskripsi }}
                                </span>
                            </td>
                            <td>
                                <span class="badge text-bg-secondary">{{ $item->kategori }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-primary">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($item->stok > 15)
                                    <span class="badge text-bg-success">{{ $item->stok }} pcs</span>
                                @elseif($item->stok > 0)
                                    <span class="badge text-bg-warning">{{ $item->stok }} pcs</span>
                                @else
                                    <span class="badge text-bg-danger">Habis</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('product.edit', $item->kode_produk) }}" class="btn btn-light btn-sm text-primary" title="Edit Produk">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('product.destroy', $item->kode_produk) }}" method="POST" class="d-inline js-delete-product-form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            class="btn btn-light btn-sm text-danger js-delete-product-btn"
                                            data-nama="{{ $item->nama_produk }}"
                                            title="Hapus Produk">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada data produk yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".js-delete-product-form").forEach(function (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            var btn = form.querySelector(".js-delete-product-btn");
            var nama = btn ? btn.getAttribute("data-nama") : "produk ini";

            Swal.fire({
                title: "Hapus Produk?",
                html: "Anda akan menghapus <strong>" + nama + "</strong> secara permanen. Tindakan ini tidak dapat dibatalkan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                reverseButtons: true,
                focusCancel: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush