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
            <button class="btn btn-primary btn-sm" type="button">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Produk
            </button>
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
                                {{ asset('storage/ ', $item->gambar) ? $item->gambar : 'Tidak ada gambar' }}
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $item->nama_produk }}</span>
                            </td>
                            <td>
                                <span class="text-muted small text-truncate d-inline-block" style="max-width: 250px;" title="{{ $item->deskripsi }}">
                                    {{ $item->deskripsi }}
                                </span>
                            </td>
                            <td>
                                <span class="badge text-bg-secondary">{{ $p->kategori }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($p->stok > 15)
                                    <span class="badge text-bg-success">{{ $item->stok }} pcs</span>
                                @elseif($p->stok > 0)
                                    <span class="badge text-bg-warning">{{ $item->stok }} pcs</span>
                                @else
                                    <span class="badge text-bg-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
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