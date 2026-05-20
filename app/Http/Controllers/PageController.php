<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Laporan;
use App\Models\Pengumuman;
use App\Models\Proyek;          
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function beranda()
    {
        // Real-time stats from database
        $totalFasilitas = Fasilitas::count();
        $fasilitasBuka = Fasilitas::where('status', 'open')->count();
        $fasilitasRenovasi = Fasilitas::where('status', 'maintenance')->count();

        $totalLaporan = Laporan::count();
        $laporanMenunggu = Laporan::where('status', 'menunggu')->count();
        $laporanDiterima = Laporan::where('status', 'diterima')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();

        $recentLaporan = Laporan::latest()->take(5)->get();

        $facilities = Fasilitas::where('status', 'open')
                        ->latest()
                        ->take(8)
                        ->get();

        $pengumuman = Pengumuman::published()
            ->latest('tanggal')
            ->take(5)
            ->get();

        // Proyek Stats
        $totalProyek = Proyek::count();
        $proyekBerlangsung = Proyek::where('status', 'berlangsung')->count();
        $proyekSelesai = Proyek::where('status', 'selesai')->count();
        $proyekTerbaru = Proyek::latest()->take(4)->get();

        // Stats untuk info-strip
        $stats = [
            ['num' => $totalFasilitas, 'label' => 'Fasilitas'],
            ['num' => $totalProyek,    'label' => 'Proyek'],
            ['num' => $pengumuman->count(), 'label' => 'Pengumuman'],
        ];

        return view('pages.beranda', compact(
            'totalFasilitas', 'fasilitasBuka', 'fasilitasRenovasi',
            'totalLaporan', 'laporanMenunggu', 'laporanDiterima', 'laporanSelesai',
            'recentLaporan',
            'facilities', 'pengumuman',
            'stats',
            'proyekTerbaru', 'totalProyek', 'proyekBerlangsung', 'proyekSelesai'
        ));
    }

    public function proyek()
    {
        $proyek = Proyek::latest()->paginate(9);

        $statusMap = [
            'berlangsung' => ['dot' => '#1D9E75', 'class' => 'badge-berlangsung', 'label' => 'Berlangsung'],
            'perencanaan' => ['dot' => '#BA7517', 'class' => 'badge-perencanaan', 'label' => 'Perencanaan'],
            'selesai'     => ['dot' => '#888780', 'class' => 'badge-selesai',     'label' => 'Selesai'],
        ];

        return view('pages.proyek', compact('proyek', 'statusMap'));
    }

    // (rest methods remain the same)

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
        'fotos'       => 'nullable|array|max:5',
        'fotos.*'     => 'image|mimes:jpg,jpeg,png|max:15368',
    ]);

    $data = [
        'nama'       => $validated['nama'],
        'telepon'    => $validated['telepon'],
        'email'      => $validated['email'],
        'lokasi'     => $validated['lokasi'],
        'deskripsi'  => $validated['deskripsi'],
        'keterangan' => $validated['keterangan'] ?? null,
        'status'     => 'menunggu',
    ];

if ($request->hasFile('fotos')) {
    $paths = [];
    $path = public_path('images/laporan');
    $dir = public_path('images/laporan');
    if (!file_exists($dir)) mkdir($dir, 0755, true);

    foreach ($request->file('fotos') as $file) {
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        $paths[] = $filename;
    }
    $data['fotos'] = $paths;
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
            ['title' => 'Login ke panel admin',    'body' => 'Akses halaman admin melalui tombol <code>Login-Admin</code> dan login menggunakan akun yang telah diberikan oleh administrator sistem.'],
            ['title' => 'Perbarui konten website', 'body' => 'Edit data fasilitas, tambahkan foto, perbarui status, atau tambahkan pengumuman baru sesuai kebutuhan.'],
            ['title' => 'Publikasikan perubahan',  'body' => 'Simpan perubahan melalui panel admin dan data akan langsung tampil di website secara real-time.'],
        ];

        return view('pages.panduan', compact('wargaSteps', 'adminSteps'));
    }



    public function index()
    {
        $pengumuman = Pengumuman::latest('tanggal')->paginate(15);
        return view('admin.pengumuman.pain', compact('pengumuman'));
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

    public function fasilitasShow(Fasilitas $fasilitas)
{
    $fasilitas->load('photos');
    $photos = $fasilitas->allPhotos();

    return view('pages.fasilitas-detail', compact('fasilitas', 'photos'));
}

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$judul}\" berhasil dihapus.");
    }

}