@extends('layouts.app')

@section('content')
<div class="lapor-container">
    <div class="lapor-card">
        <h1>Laporkan Masalah Fasilitas</h1>
        <p class="subtitle">Isi form di bawah ini dengan lengkap. Semua laporan akan ditindaklanjuti oleh Dinas Pekerjaan Umum.</p>

        <!-- Error Message -->
        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" class="lapor-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon <span class="required">*</span></label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                <small>Kami akan mengirimkan update status laporan ke email ini.</small>
            </div>

            <div class="form-group">
                <label>Lokasi Fasilitas <span class="required">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Taman Kota, Jl. Sudirman No.45" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Masalah <span class="required">*</span></label>
                <textarea name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" rows="3" placeholder="Contoh: Lampu jalan mati total, bangku rusak parah, dll">{{ old('keterangan') }}</textarea>
            </div>

<div class="form-group">
    <label>Foto Bukti <span class="optional">(Sangat dianjurkan)</span></label>
    <input type="file" name="fotos[]" accept="image/*" multiple class="file-input">
    <small>Pilih satu atau beberapa foto (maks. 5 foto, masing-masing 2MB)</small>
</div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <span>Kirim Laporan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection