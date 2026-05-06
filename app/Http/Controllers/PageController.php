<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Laporan;
use App\Models\Pengumuman;

class PageController extends Controller
{
    public function beranda()
    {
        $stats = [
            ['num'   => 1,
             'label' => 'Total Fasilitas'],
            ['num'   => 1,
             'label' => 'Fasilitas Aktif'],
            ['num'   => 1,
             'label' => 'Laporan Diselesaikan'],
        ];

        $facilities = [
            'name' => 'Perpustakaan Umum',
            'addr' => 'Jl. Merdeka No. 5',
            'type' => 'Pendidikan',
            'status' => 'open',
            'photo' => 'assets/perpustakaan.jpg',
        ];

        // Pengumuman — only published, latest 5
        $pengumuman = [
            'tanggal' => '18',
            'month' => 'Apr',
            'title' => 'Renovasi Stadion Kota dimulai',
            'body' => 'Pengerjaan renovasi tribun dan lapangan utama telah resmi dimulai. Diperkirakan selesai Agustus 2025.',
        ];

        return view('pages.beranda', compact('stats', 'facilities', 'pengumuman'));
    }

    public function proyek()
    {
        $projects = [
            ['name' => 'Renovasi Stadion Kota',  'desc' => 'Peningkatan kapasitas tribun dan fasilitas penonton',  'status' => 'berlangsung'],
            ['name' => 'Pelebaran Jalan Utama',  'desc' => 'Jl. Sudirman — penambahan jalur sepeda dan trotoar',   'status' => 'berlangsung'],
            ['name' => 'Pembangunan Taman Baru', 'desc' => 'Area hijau baru di kawasan Kecamatan Timur',           'status' => 'perencanaan'],
            ['name' => 'Perbaikan Drainase Kota','desc' => 'Saluran air di pusat kota — selesai 2024',             'status' => 'selesai'],
            ['name' => 'Gedung Serbaguna',       'desc' => 'Pusat kegiatan warga RT/RW — selesai 2023',            'status' => 'selesai'],
        ];

        $statusMap = [
            'berlangsung' => ['dot' => '#1D9E75', 'class' => 'badge-berlangsung', 'label' => 'Berlangsung'],
            'perencanaan' => ['dot' => '#BA7517', 'class' => 'badge-perencanaan', 'label' => 'Perencanaan'],
            'selesai'     => ['dot' => '#888780', 'class' => 'badge-selesai',     'label' => 'Selesai'],
        ];

        return view('pages.proyek', compact('projects', 'statusMap'));
    }

    public function lapor()
    {
        $fasilitasOptions = Fasilitas::pluck('name');
        return view('pages.lapor', compact('fasilitasOptions'));
    }

    public function laporStore(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'telepon'   => 'required|string|max:20',
            'lokasi'    => 'required|string',
            'deskripsi' => 'required|string|max:2000',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'telepon.required'   => 'Nomor telepon wajib diisi.',
            'lokasi.required'    => 'Pilih fasilitas atau lokasi.',
            'deskripsi.required' => 'Deskripsi masalah wajib diisi.',
            'foto.image'         => 'File harus berupa gambar.',
            'foto.max'           => 'Ukuran foto maksimal 5 MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        Laporan::create([
            'nama'      => $validated['nama'],
            'telepon'   => $validated['telepon'],
            'lokasi'    => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'],
            'foto'      => $fotoPath,
            'status'    => 'menunggu',
        ]);

        return redirect()->route('lapor')->with('success', true);
    }

    public function panduan()
    {
        $wargaSteps = [
            ['title' => 'Lihat daftar fasilitas',      'body' => 'Buka halaman Beranda untuk melihat seluruh fasilitas publik yang tersedia, beserta status operasional dan lokasi masing-masing.'],
            ['title' => 'Periksa proyek pembangunan',  'body' => 'Klik menu Proyek untuk melihat daftar proyek yang sedang berjalan, dalam perencanaan, atau telah selesai di kota Anda.'],
            ['title' => 'Laporkan masalah fasilitas',  'body' => 'Temukan masalah? Klik tombol "Laporkan Masalah" di pojok kanan atas, isi formulir dengan nama, nomor telepon, lokasi, deskripsi masalah, dan foto jika ada, lalu kirim.'],
            ['title' => 'Laporan diteruskan ke dinas', 'body' => 'Setelah dikirim, laporan Anda secara otomatis diteruskan ke dinas terkait. Petugas akan menerima notifikasi dan menindaklanjuti laporan.'],
        ];

        $adminSteps = [
            ['title' => 'Login ke panel admin',    'body' => 'Akses halaman admin melalui <code>/admin</code> menggunakan akun yang telah diberikan oleh administrator sistem.'],
            ['title' => 'Perbarui konten website', 'body' => 'Edit data fasilitas, tambahkan foto, perbarui status, atau tambahkan pengumuman baru sesuai kebutuhan.'],
            ['title' => 'Publikasikan perubahan',  'body' => 'Simpan perubahan melalui panel admin dan data akan langsung tampil di website secara real-time.'],
        ];

        return view('pages.panduan', compact('wargaSteps', 'adminSteps'));
    }
}
