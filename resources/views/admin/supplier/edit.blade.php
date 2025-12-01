@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Basic body & animation */
body { font-family: 'Poppins', sans-serif; color: #1e293b; }
.data-container { animation: fadeSlideIn 0.7s ease forwards; opacity: 0; transform: translateY(20px); }
@keyframes fadeSlideIn { to { opacity: 1; transform: translateY(0); } }

/* Page Title */
.page-title {
    font-weight: 700;
    font-size: 1.8rem;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
}

/* Card & Form */
.card { border: none; border-radius: 20px; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.06); padding: 2rem; }
.form-control { border-radius: 8px; border: 1px solid #cbd5e1; padding: 0.5rem 1rem; transition: all 0.3s ease; }
.form-control:focus { border-color: #2563eb; box-shadow: 0 0 6px rgba(37,99,235,0.2); }

/* Buttons */
.btn-submit {
    background: #1cc88a; color: white; border-radius: 8px;
    padding: 0.5rem 1.2rem; font-weight: 500; transition: all 0.3s ease;
}
.btn-submit:hover { background: #17a673; transform: translateY(-2px); }

.btn-back {
    background: #6b7280; color: white; border-radius: 8px;
    padding: 0.5rem 1.2rem; font-weight: 500; transition: all 0.3s ease;
}
.btn-back:hover { background: #4b5563; transform: translateY(-2px); }

/* Responsive Buttons for Mobile */
@media (max-width: 576px) {
    .form-actions {
        flex-direction: column !important;
        gap: 10px !important;
    }

    .form-actions a,
    .form-actions button {
        width: 100% !important;
        text-align: center;
    }
}

</style>

<div class="container py-5 data-container">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title"><i class="bi bi-pencil-square me-2"></i>Edit Supplier</h2>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                <input type="text" name="nama_supplier" id="nama_supplier"
                    class="form-control @error('nama_supplier') is-invalid @enderror"
                    value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                @error('nama_supplier')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat"
                    class="form-control @error('alamat') is-invalid @enderror"
                    rows="3" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" name="telepon" id="telepon"
                    class="form-control @error('telepon') is-invalid @enderror"
                    value="{{ old('telepon', $supplier->telepon) }}" required>
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4 flex-wrap gap-2 form-actions">
                <a href="{{ route('admin.supplier.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// SweetAlert Success Alerts
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 1800
});
@endif
</script>
@endsection
