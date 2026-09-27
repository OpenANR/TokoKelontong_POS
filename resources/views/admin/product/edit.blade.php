@extends('layouts.admin')

@php
    $product = $product ?? $produk ?? null;
@endphp

@section('title', 'Edit Produk: ' . ($product->nama_produk ?? 'Ubah Data'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/product-form.css') }}">
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <!-- Page Header -->
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon">
                <i class="bi bi-pencil-square" aria-hidden="true"></i>
            </span>
            <div>
                <p class="eyebrow mb-1">Manajemen Inventaris &bull; Produk</p>
                <h1 class="h3 mb-1">Edit Produk</h1>
                <p class="text-muted mb-0">Perbarui rincian informasi data, harga jual, stok, atau pergantian foto produk kelontong.</p>
            </div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('product.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <strong>Terdapat beberapa kesalahan pengisian form:</strong>
            </div>
            <ul class="mb-0 ps-4 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Section -->
    <form action="{{ route('product.update', $product->kode_produk) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          id="productEditForm" 
          class="needs-validation" 
          novalidate>
        @csrf
        @method('PUT')

        <div class="row g-3 g-xl-4">
            <!-- Left Column: Core Product Info -->
            <div class="col-12 col-xl-8">
                <!-- Panel 1: Data Identitas Produk -->
                <div class="product-form-panel">
                    <div class="product-form-header">
                        <div>
                            <h2 class="section-title">
                                <i class="bi bi-box-seam" aria-hidden="true"></i>
                                <span>Informasi Umum Produk</span>
                            </h2>
                            <p>Data dasar dan kategori barang toko kelontong.</p>
                        </div>
                        <span class="badge text-bg-light border font-monospace text-primary">
                            {{ $product->kode_produk ?? 'PRD' }}
                        </span>
                    </div>

                    <!-- Nama Produk -->
                    <div class="mb-3">
                        <label class="form-label" for="nama_produk">
                            <span>Nama Produk <span class="required-mark">*</span></span>
                            <span class="text-muted small fw-normal">Wajib diisi</span>
                        </label>
                        <input type="text"
                               name="nama_produk"
                               id="nama_produk"
                               class="form-control @error('nama_produk') is-invalid @enderror"
                               placeholder="Contoh: Beras Ramos Wangi 5 Kg / Teh Botol Sosro 350ml"
                               value="{{ old('nama_produk', $product->nama_produk ?? '') }}"
                               required
                               autofocus>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Nama produk harus diisi.</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <!-- Kode Produk (Readonly/Unique Identifier) -->
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label" for="kode_produk">
                                <span>Kode Produk</span>
                                <span class="badge text-bg-primary font-monospace">
                                    <i class="bi bi-lock-fill me-1"></i>Terkunci
                                </span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-upc-scan"></i>
                                </span>
                                <input type="text"
                                       name="kode_produk"
                                       id="kode_produk"
                                       maxlength="8"
                                       class="form-control font-monospace bg-body-tertiary @error('kode_produk') is-invalid @enderror"
                                       value="{{ old('kode_produk', $product->kode_produk ?? '') }}"
                                       readonly>
                            </div>
                            <div class="form-hint">Kode produk merupakan pengenal unik permanen di sistem POS.</div>
                            @error('kode_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori Produk (Enum: Makanan, Minuman) -->
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">
                                <span>Kategori Produk <span class="required-mark">*</span></span>
                            </label>
                            <div class="category-selector-grid">
                                <label class="mb-0">
                                    <input type="radio"
                                           name="kategori"
                                           value="Makanan"
                                           class="category-radio-input"
                                           {{ old('kategori', $product->kategori ?? 'Makanan') === 'Makanan' ? 'checked' : '' }}
                                           required>
                                    <div class="category-card category-food">
                                        <div class="category-card-icon">
                                            <i class="bi bi-egg-fried"></i>
                                        </div>
                                        <div class="category-card-text">
                                            <span class="category-card-title">Makanan</span>
                                            <span class="category-card-desc">Sembako, snack, mie</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="mb-0">
                                    <input type="radio"
                                           name="kategori"
                                           value="Minuman"
                                           class="category-radio-input"
                                           {{ old('kategori', $product->kategori ?? '') === 'Minuman' ? 'checked' : '' }}>
                                    <div class="category-card category-drink">
                                        <div class="category-card-icon">
                                            <i class="bi bi-cup-straw"></i>
                                        </div>
                                        <div class="category-card-text">
                                            <span class="category-card-title">Minuman</span>
                                            <span class="category-card-desc">Air mineral, kopi, susu</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="mb-0">
                        <label class="form-label" for="deskripsi">
                            <span>Deskripsi Produk <span class="required-mark">*</span></span>
                            <span class="text-muted small fw-normal" id="deskripsiCounter">0 karakter</span>
                        </label>
                        <textarea name="deskripsi"
                                  id="deskripsi"
                                  rows="4"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Tuliskan deskripsi lengkap produk, varian, ukuran, kemasan, atau catatan kadaluarsa..."
                                  required>{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Deskripsi produk wajib diisi.</div>
                        @enderror
                    </div>
                </div>

                <!-- Panel 2: Harga & Stok -->
                <div class="product-form-panel">
                    <div class="product-form-header">
                        <div>
                            <h2 class="section-title">
                                <i class="bi bi-cash-coin" aria-hidden="true"></i>
                                <span>Harga & Stok Inventaris</span>
                            </h2>
                            <p>Perbarui harga jual kasir dan ketersediaan stok fisik di rak toko.</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Harga Jual -->
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="harga">
                                <span>Harga Jual (Rp) <span class="required-mark">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text font-monospace fw-bold text-primary">Rp</span>
                                <input type="number"
                                       name="harga"
                                       id="harga"
                                       min="0"
                                       step="1"
                                       class="form-control font-monospace fw-bold @error('harga') is-invalid @enderror"
                                       placeholder="0"
                                       value="{{ old('harga', $product->harga ?? '') }}"
                                       required>
                            </div>
                            <div class="helper-row">
                                <span class="price-live-badge" id="hargaPreview">
                                    <i class="bi bi-tag-fill me-1"></i> Rp 0
                                </span>
                                <div class="quick-chip-group">
                                    <button type="button" class="quick-chip" data-add-price="1000">+1rb</button>
                                    <button type="button" class="quick-chip" data-add-price="5000">+5rb</button>
                                    <button type="button" class="quick-chip" data-add-price="10000">+10rb</button>
                                    <button type="button" class="quick-chip" data-add-price="50000">+50rb</button>
                                </div>
                            </div>
                            @error('harga')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Harga produk wajib diisi angka valid.</div>
                            @enderror
                        </div>

                        <!-- Jumlah Stok -->
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="stok">
                                <span>Jumlah Stok <span class="required-mark">*</span></span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       name="stok"
                                       id="stok"
                                       min="0"
                                       step="1"
                                       class="form-control font-monospace fw-bold @error('stok') is-invalid @enderror"
                                       placeholder="0"
                                       value="{{ old('stok', $product->stok ?? 0) }}"
                                       required>
                                <span class="input-group-text">pcs / unit</span>
                            </div>
                            <div class="helper-row">
                                <span class="stock-status-pill text-bg-secondary" id="stokStatus">
                                    <i class="bi bi-box-seam me-1"></i> Siap Input
                                </span>
                                <div class="quick-chip-group">
                                    <button type="button" class="quick-chip" data-add-stock="5">+5</button>
                                    <button type="button" class="quick-chip" data-add-stock="10">+10</button>
                                    <button type="button" class="quick-chip" data-add-stock="25">+25</button>
                                    <button type="button" class="quick-chip" data-add-stock="50">+50</button>
                                </div>
                            </div>
                            @error('stok')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Jumlah stok produk wajib diisi.</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Image & Actions -->
            <div class="col-12 col-xl-4">
                <!-- Panel 3: Foto Produk -->
                <div class="product-form-panel">
                    <div class="product-form-header">
                        <div>
                            <h2 class="section-title">
                                <i class="bi bi-image" aria-hidden="true"></i>
                                <span>Foto Produk</span>
                            </h2>
                            <p>Visual produk untuk display kasir & katalog.</p>
                        </div>
                    </div>

                    <!-- Current Image Display -->
                    @if(!empty($product->gambar))
                        <div class="current-image-box">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-bold text-muted">Foto Saat Ini</span>
                                <span class="badge text-bg-success"><i class="bi bi-check2 me-1"></i>Tersimpan</span>
                            </div>
                            <div class="current-image-thumbnail">
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk ?? 'Foto Produk' }}">
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="small text-muted text-truncate" style="max-width: 170px;" title="{{ $product->gambar }}">
                                    <i class="bi bi-file-earmark-image me-1"></i>{{ basename($product->gambar) }}
                                </span>
                                <span class="badge text-bg-light border text-muted">Storage</span>
                            </div>
                        </div>
                    @else
                        <div class="current-image-box">
                            <div class="current-image-placeholder">
                                <i class="bi bi-image"></i>
                                <span class="small">Belum ada foto yang diunggah</span>
                            </div>
                        </div>
                    @endif

                    <!-- Dropzone for New/Replacement Image -->
                    <div class="upload-dropzone" id="dropzoneArea">
                        <input type="file"
                               name="gambar"
                               id="gambarInput"
                               class="file-input-hidden"
                               accept="image/png, image/jpeg, image/jpg, image/webp">
                        <div class="upload-icon-wrapper">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-title">{{ !empty($product->gambar) ? 'Ganti Foto Produk' : 'Pilih atau Seret Foto ke Sini' }}</div>
                        <div class="upload-subtitle">Format didukung: PNG, JPG, JPEG, WEBP (Maks. 2 MB)</div>
                        <div class="upload-btn-fake">
                            <i class="bi bi-folder2-open"></i> Telusuri File Baru
                        </div>
                    </div>

                    <div class="form-hint mt-2">
                        <i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengubah foto yang sudah ada.
                    </div>

                    <!-- Preview Container for New Upload -->
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <div class="preview-img-box">
                            <img src="" id="imagePreviewImg" alt="Preview Gambar Baru">
                        </div>
                        <div class="preview-meta">
                            <div class="preview-meta-info">
                                <span class="preview-file-name" id="previewFileName">filename.png</span>
                                <span class="preview-file-size" id="previewFileSize">0 KB</span>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="btnRemoveImage" title="Batal ganti foto">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    @error('gambar')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Panel 4: Tombol Aksi Simpan -->
                <div class="product-form-panel">
                    <div class="product-form-header">
                        <div>
                            <h2 class="section-title">
                                <i class="bi bi-floppy2" aria-hidden="true"></i>
                                <span>Aksi & Perubahan</span>
                            </h2>
                            <p>Simpan perubahan data produk.</p>
                        </div>
                    </div>

                    <div class="summary-status-list">
                        <div class="summary-status-item">
                            <span>Status Produk:</span>
                            <span class="badge text-bg-success">Aktif di Kasir POS</span>
                        </div>
                        <div class="summary-status-item">
                            <span>Kategori:</span>
                            <strong id="summaryKategori">{{ $product->kategori ?? 'Makanan' }}</strong>
                        </div>
                        <div class="summary-status-item">
                            <span>Stok Terdata:</span>
                            <strong id="summaryStok">{{ $product->stok ?? 0 }} pcs</strong>
                        </div>
                        @if(!empty($product->created_at))
                            <div class="summary-status-item">
                                <span>Didaftarkan:</span>
                                <small class="text-muted">{{ $product->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        @endif
                        @if(!empty($product->updated_at))
                            <div class="summary-status-item">
                                <span>Terakhir Update:</span>
                                <small class="text-muted">{{ $product->updated_at->format('d M Y, H:i') }}</small>
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary py-2">
                            <i class="bi bi-x-circle me-1"></i> Batal & Kembali
                        </a>
                    </div>
                </div>

                <!-- Panel 5: Tips Inventaris -->
                <div class="tips-panel">
                    <div class="tips-header">
                        <i class="bi bi-lightbulb-fill"></i>
                        <span>Catatan Inventaris</span>
                    </div>
                    <ul class="tips-list">
                        <li>Perubahan harga langsung berpengaruh pada transaksi baru di kasir.</li>
                        <li>Pastikan stok diperbarui sesuai dengan barang fisik riil di gudang / etalase toko.</li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Elements
    var form = document.getElementById("productEditForm");
    var hargaInput = document.getElementById("harga");
    var hargaPreview = document.getElementById("hargaPreview");
    var stokInput = document.getElementById("stok");
    var stokStatus = document.getElementById("stokStatus");
    var deskripsiTextarea = document.getElementById("deskripsi");
    var deskripsiCounter = document.getElementById("deskripsiCounter");
    var gambarInput = document.getElementById("gambarInput");
    var dropzoneArea = document.getElementById("dropzoneArea");
    var imagePreviewContainer = document.getElementById("imagePreviewContainer");
    var imagePreviewImg = document.getElementById("imagePreviewImg");
    var previewFileName = document.getElementById("previewFileName");
    var previewFileSize = document.getElementById("previewFileSize");
    var btnRemoveImage = document.getElementById("btnRemoveImage");
    var summaryKategori = document.getElementById("summaryKategori");
    var summaryStok = document.getElementById("summaryStok");
    var kategoriRadios = document.querySelectorAll('input[name="kategori"]');

    // 2. Format Currency Rupiah
    function formatRupiah(value) {
        var num = parseInt(value, 10);
        if (isNaN(num) || num < 0) {
            return "Rp 0";
        }
        return "Rp " + num.toLocaleString("id-ID");
    }

    function updateHarga() {
        if (hargaInput && hargaPreview) {
            hargaPreview.innerHTML = '<i class="bi bi-tag-fill me-1"></i> ' + formatRupiah(hargaInput.value);
        }
    }

    if (hargaInput) {
        hargaInput.addEventListener("input", updateHarga);
        updateHarga();
    }

    // Quick price chips
    var priceChips = document.querySelectorAll("[data-add-price]");
    priceChips.forEach(function (chip) {
        chip.addEventListener("click", function () {
            var current = parseInt(hargaInput.value, 10) || 0;
            var add = parseInt(this.getAttribute("data-add-price"), 10) || 0;
            hargaInput.value = current + add;
            updateHarga();
        });
    });

    // 3. Stok Status Pill & Quick Chips
    function updateStok() {
        if (!stokInput || !stokStatus) return;
        var qty = parseInt(stokInput.value, 10) || 0;

        if (summaryStok) {
            summaryStok.textContent = qty + " pcs";
        }

        if (qty <= 0) {
            stokStatus.className = "stock-status-pill text-bg-danger";
            stokStatus.innerHTML = '<i class="bi bi-x-circle me-1"></i> Stok Habis';
        } else if (qty <= 10) {
            stokStatus.className = "stock-status-pill text-bg-warning";
            stokStatus.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i> Stok Sedikit';
        } else {
            stokStatus.className = "stock-status-pill text-bg-success";
            stokStatus.innerHTML = '<i class="bi bi-check2-circle me-1"></i> Stok Aman';
        }
    }

    if (stokInput) {
        stokInput.addEventListener("input", updateStok);
        updateStok();
    }

    // Quick stock chips
    var stockChips = document.querySelectorAll("[data-add-stock]");
    stockChips.forEach(function (chip) {
        chip.addEventListener("click", function () {
            var current = parseInt(stokInput.value, 10) || 0;
            var add = parseInt(this.getAttribute("data-add-stock"), 10) || 0;
            stokInput.value = current + add;
            updateStok();
        });
    });

    // 4. Category Radio Tracker for Summary
    kategoriRadios.forEach(function (radio) {
        radio.addEventListener("change", function () {
            if (this.checked && summaryKategori) {
                summaryKategori.textContent = this.value;
            }
        });
    });

    // 5. Deskripsi Character Counter
    if (deskripsiTextarea && deskripsiCounter) {
        var updateCounter = function () {
            var length = deskripsiTextarea.value.length;
            deskripsiCounter.textContent = length + " karakter";
        };
        deskripsiTextarea.addEventListener("input", updateCounter);
        updateCounter();
    }

    // 6. Image Preview & Dropzone Handling
    function handleFiles(files) {
        if (!files || !files.length) return;
        var file = files[0];

        if (!file.type.match(/^image\//)) {
            alert("Harap pilih file gambar (JPG, PNG, WEBP)!");
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert("Ukuran gambar melebihi batas 2 MB!");
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            imagePreviewImg.src = e.target.result;
            previewFileName.textContent = file.name;
            previewFileSize.textContent = (file.size / 1024).toFixed(1) + " KB";
            imagePreviewContainer.classList.add("active");
        };
        reader.readAsDataURL(file);
    }

    if (gambarInput) {
        gambarInput.addEventListener("change", function () {
            handleFiles(this.files);
        });
    }

    if (dropzoneArea) {
        ["dragenter", "dragover"].forEach(function (eventName) {
            dropzoneArea.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzoneArea.classList.add("dragover");
            }, false);
        });

        ["dragleave", "drop"].forEach(function (eventName) {
            dropzoneArea.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzoneArea.classList.remove("dragover");
            }, false);
        });

        dropzoneArea.addEventListener("drop", function (e) {
            var dt = e.dataTransfer;
            var files = dt.files;
            if (files && files.length) {
                gambarInput.files = files;
                handleFiles(files);
            }
        }, false);
    }

    if (btnRemoveImage) {
        btnRemoveImage.addEventListener("click", function () {
            gambarInput.value = "";
            imagePreviewImg.src = "";
            imagePreviewContainer.classList.remove("active");
        });
    }

    // 7. Confirmation Before Update (SweetAlert2)
    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (!form.checkValidity()) {
                form.classList.add("was-validated");
                return;
            }

            Swal.fire({
                title: "Simpan Perubahan Produk?",
                text: "Perubahan data produk ini akan langsung diperbarui di sistem.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, Simpan Perubahan",
                cancelButtonText: "Batal",
                confirmButtonColor: "#0d6efd",
                cancelButtonColor: "#6c757d",
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }
});
</script>
@endpush