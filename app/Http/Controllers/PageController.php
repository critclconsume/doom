<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Laporan;
use App\Models\Pengumuman;
use App\Http\Controllers\Admin;

class PageController extends Controller
{

public function beranda()
{
    $totalFasilitas = \App\Models\Fasilitas::count();
    $fasilitasBuka = \App\Models\Fasilitas::where('status', 'open')->count();
    $fasilitasRenovasi = \App\Models\Fasilitas::where('status', 'maintenance')->count();

    $totalLaporan = \App\Models\Laporan::count();
    $laporanMenunggu = \App\Models\Laporan::where('status', 'menunggu')->count();
    $laporanDiterima = \App\Models\Laporan::where('status', 'diterima')->count();
    $laporanSelesai = \App\Models\Laporan::where('status', 'selesai')->count();

    $recentLaporan = \App\Models\Laporan::latest()->take(5)->get();

    $facilities = \App\Models\Fasilitas::where('status', 'open')
                    ->latest()
                    ->take(8)
                    ->get();

    $pengumuman = \App\Models\Pengumuman::published()
        ->latest('tanggal')
        ->take(5)
        ->get();

    return view('pages.beranda', compact(
        'totalFasilitas', 
        'fasilitasBuka', 
        'fasilitasRenovasi',
        'totalLaporan', 
        'laporanMenunggu', 
        'laporanDiterima', 
        'laporanSelesai',
        'recentLaporan',
        'facilities',  
        'pengumuman'
    ));
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
        'nama'        => 'required|string|max:255',
        'telepon'     => 'required|string|max:20',
        'email'       => 'required|email|max:255',
        'lokasi'      => 'required|string|max:255',
        'deskripsi'   => 'required|string',
        'keterangan'  => 'nullable|string',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'nama'        => $validated['nama'],
        'telepon'     => $validated['telepon'],
        'email'       => $validated['email'],
        'lokasi'      => $validated['lokasi'],
        'deskripsi'   => $validated['deskripsi'],
        'keterangan'  => $validated['keterangan'] ?? null,
        'status'      => 'menunggu',
    ];

    // Photo Upload
    if ($request->hasFile('foto')) {
        $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->storeAs('public/laporan', $filename);
        $data['foto'] = 'laporan/' . $filename;
    }

    \App\Models\Laporan::create($data);

    return redirect()->route('beranda')
                     ->with('success', 'Laporan berhasil dikirim. Terima kasih atas partisipasinya!');
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



    public function index()
    {
        $pengumuman = Pengumuman::latest('tanggal')->paginate(15);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal'      => 'required|date',
            'is_published' => 'nullable|boolean',
        ], [
            'judul.required'   => 'Judul pengumuman wajib diisi.',
            'isi.required'     => 'Isi pengumuman wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
        ]);

        $validated['is_published'] = $request->has('is_published');

        Pengumuman::create($validated);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$validated['judul']}\" berhasil ditambahkan.");
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal'      => 'required|date',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$pengumuman->judul}\" berhasil diperbarui.");
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$judul}\" berhasil dihapus.");
    }

}