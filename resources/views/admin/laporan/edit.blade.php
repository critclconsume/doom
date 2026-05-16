@extends('admin.layout')

@section('title', 'Edit Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Header -->
        <div class="px-8 py-6 border-b flex items-center justify-between bg-teal-50">
            <div>
                <h1 class="text-2xl font-semibold text-teal-800">Proses Laporan</h1>
                <p class="text-teal-600 mt-1">ID Laporan: #{{ $laporan->id }}</p>
            </div>
            <a href="{{ route('admin.laporan.show', $laporan) }}" 
               class="px-5 py-2 text-sm font-medium text-teal-700 hover:bg-teal-100 rounded-lg transition">
                ← Kembali ke Detail
            </a>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.laporan.update', $laporan) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Status -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-500 mb-3">Status Laporan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="menunggu" 
                                   {{ $laporan->status === 'menunggu' ? 'checked' : '' }}>
                            <span class="status-badge status-menunggu">Menunggu</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="diterima" 
                                   {{ $laporan->status === 'diterima' ? 'checked' : '' }}>
                            <span class="status-badge status-diterima">Diterima</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="selesai" 
                                   {{ $laporan->status === 'selesai' ? 'checked' : '' }}>
                            <span class="status-badge status-selesai">Selesai</span>
                        </label>
                    </div>
                </div>

                <!-- Read-only Information -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pelapor</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            {{ $laporan->nama }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            {{ $laporan->telepon }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Lokasi</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            {{ $laporan->lokasi }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi Masalah</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-4 whitespace-pre-wrap min-h-[120px]">
                            {{ $laporan->deskripsi }}
                        </div>
                    </div>

                    @if($laporan->foto)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Foto Bukti</label>
                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-black">
                            <img src="{{ Storage::url($laporan->foto) }}" 
                                 alt="Foto Laporan"
                                 class="w-full max-h-[420px] object-contain mx-auto">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-8 py-6 border-t bg-gray-50 flex gap-3">
                <button type="submit" 
                        class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-3.5 rounded-xl font-medium transition">
                    Simpan Perubahan Status
                </button>
                
                <a href="{{ route('admin.laporan.show', $laporan) }}" 
                   class="flex-1 text-center bg-white border border-gray-300 hover:bg-gray-50 py-3.5 rounded-xl font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection