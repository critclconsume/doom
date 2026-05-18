@extends('admin.layout')

@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="px-8 py-6 border-b flex items-center justify-between bg-teal-50">
            <div>
                <h1 class="text-2xl font-semibold text-teal-800">Detail Laporan</h1>
                <p class="text-teal-600 mt-1">ID Laporan: #{{ $laporan->id }}</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('admin.laporan.index') }}"
                   class="px-5 py-2 text-sm font-medium text-teal-700 hover:bg-teal-100 rounded-lg transition">
                    ← Kembali ke Daftar
                </a>
                <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST"
                      onsubmit="return confirm('Hapus laporan dari {{ $laporan->nama }}? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" style="padding:8px 16px; font-size:13px;">
                        Hapus Laporan
                    </button>
                </form>
            </div>
        </div>

        <div class="p-8 space-y-8">

            <!-- Status Update Form -->
            <form action="{{ route('admin.laporan.update', $laporan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex justify-between items-start mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Ubah Status</label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="menunggu" {{ $laporan->status === 'menunggu' ? 'checked' : '' }}>
                                <span class="status-badge status-menunggu">Menunggu</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="diterima" {{ $laporan->status === 'diterima' ? 'checked' : '' }}>
                                <span class="status-badge status-diterima">Diterima</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="selesai" {{ $laporan->status === 'selesai' ? 'checked' : '' }}>
                                <span class="status-badge status-selesai">Selesai</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="ditolak" {{ $laporan->status === 'ditolak' ? 'checked' : '' }}>
                                <span class="status-badge status-ditolak">Ditolak</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-medium transition">
                        Simpan Status
                    </button>
                </div>
            </form>

            <!-- Report Information -->
            <div class="space-y-6">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pelapor</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">{{ $laporan->nama }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">{{ $laporan->telepon }}</div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Lokasi</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">{{ $laporan->lokasi }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi Masalah</label>
                    <div style="background:#F9FAFB; border:1px solid #E5E7EB; border-radius:8px; padding:14px 16px; min-height:140px; white-space:pre-wrap; text-align:left; display:block; vertical-align:top; font-size:14px; color:#1a1a18; line-height:1.6;">{{ $laporan->deskripsi }}</div>
                </div>

                <!-- Keterangan (if exists) -->
                @if($laporan->keterangan)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan Tambahan</label>
                    <div style="background:#F9FAFB; border:1px solid #E5E7EB; border-radius:8px; padding:14px 16px; white-space:pre-wrap; text-align:left; display:block; font-size:14px; color:#1a1a18; line-height:1.6;">{{ $laporan->keterangan }}</div>
                </div>
                @endif

                <!-- Photos -->
                @php
                    $allFotos = collect($laporan->fotos ?? []);
                    if ($allFotos->isEmpty() && $laporan->foto) {
                        $allFotos = collect([$laporan->foto]);
                    }
                @endphp

                @if($allFotos->isNotEmpty())
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">
                        Foto Bukti ({{ $allFotos->count() }} foto)
                    </label>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:12px;">
                        @foreach($allFotos as $foto)
                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-black">
        <img src="{{ asset('images/laporan/' . $laporan->foto) }}"
             alt="Foto Laporan"
             class="w-full max-h-[520px] object-contain mx-auto">
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div style="background:#F3F4F6; border:1px dashed #D1D5DB; border-radius:12px; padding:48px 16px; text-align:center;">
                    <p style="color:#6B7280; font-size:13px;">Tidak ada foto yang diunggah</p>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection