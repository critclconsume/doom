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
            <a href="{{ route('admin.laporan.index') }}" 
               class="px-5 py-2 text-sm font-medium text-teal-700 hover:bg-teal-100 rounded-lg transition">
                ← Kembali ke Daftar
            </a>
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
                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-4 whitespace-pre-wrap min-h-[140px]">
                        {{ $laporan->deskripsi }}
                    </div>
                </div>

                <!-- Photo -->
                @if($laporan->foto)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Foto Bukti</label>
                    <div class="border border-gray-200 rounded-xl overflow-hidden bg-black">
                        <img src="{{ Storage::url($laporan->foto) }}" 
                             alt="Foto Laporan"
                             class="w-full max-h-[520px] object-contain mx-auto">
                    </div>
                </div>
                @else
                <div class="bg-gray-100 border border-dashed border-gray-300 rounded-xl p-12 text-center">
                    <p class="text-gray-500">Tidak ada foto yang diunggah</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection