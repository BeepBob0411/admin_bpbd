<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Google\Cloud\Core\GeoPoint;
use App\Http\Controllers\Controller;
use Google\Cloud\Firestore\FirestoreClient;

class IncomeCategoriesController extends Controller
{
    protected $database;

    public function __construct(FirestoreClient $database)
    {
        $this->database = $database;
    }

    public function index()
    {
        try {
            $incomeCategories = $this->database->collection('berita')->documents();
            return view('admin.income_categories.index', compact('incomeCategories'));
        } catch (\Exception $e) {
            return back()->withError('Gagal mengambil data kategori pendapatan. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.income_categories.create');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input di sini

            $data = [
                'id_berita' => uniqid(),
                'nama_bencana' => $request->nama_bencana,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'waktu_kejadian' => $request->waktu_kejadian,
                'lokasi_kejadian' => new GeoPoint($request->latitude, $request->longitude),
                'gambar_berita' => $request->gambar_berita,
                'deskripsi_berita' => $request->deskripsi_berita,
            ];

            $this->database->collection('berita')->add($data);

            return redirect()->route('admin.income_categories.index')->withSuccess('Berita berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withError('Gagal membuat kategori pendapatan. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $incomeCategoryRef = $this->database->collection('berita')->document($id);
            $incomeCategory = $incomeCategoryRef->snapshot()->data();

            return view('admin.income_categories.edit', compact('incomeCategory'));
        } catch (\Exception $e) {
            return back()->withError('Gagal mengambil kategori pendapatan untuk diedit. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input di sini

            $data = [
                'nama_bencana' => $request->nama_bencana,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'waktu_kejadian' => $request->waktu_kejadian,
                'lokasi_kejadian' => new GeoPoint($request->latitude, $request->longitude),
                'gambar_berita' => $request->gambar_berita,
                'deskripsi_berita' => $request->deskripsi_berita,
            ];

            $this->database->collection('berita')->document($id)->set($data);

            return redirect()->route('admin.income_categories.index')->withSuccess('Kategori pendapatan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withError('Gagal memperbarui kategori pendapatan. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->database->collection('berita')->document($id)->delete();

            return redirect()->route('admin.income_categories.index')->withSuccess('Kategori pendapatan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withError('Gagal menghapus kategori pendapatan. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    // Fungsi untuk membuat berita dari data laporan
    public function createBeritaFromLaporan(Request $request)
    {
        try {
            // Validasi input di sini jika diperlukan

            // Ambil data laporan dari koleksi "laporan"
            $laporan = $this->database->collection('laporan')->document($request->laporan_id)->snapshot()->data();

            // Buat data berita dari data laporan yang diambil
            $data = [
                'id_berita' => uniqid(),
                'nama_bencana' => $laporan['disasterType'],
                'tanggal_kejadian' => $laporan['timestamp']->toDate(),
                'waktu_kejadian' => $laporan['timestamp']->toTimeString(),
                'lokasi_kejadian' => new GeoPoint($laporan['location']->latitude(), $laporan['location']->longitude()),
                'gambar_berita' => $laporan['imageUrl'],
                'deskripsi_berita' => $laporan['description'],
            ];

            // Simpan data berita ke koleksi "berita"
            $this->database->collection('berita')->add($data);

            return redirect()->route('admin.income_categories.index')->withSuccess('Berita berhasil dibuat dari data laporan.');
        } catch (\Exception $e) {
            // Tangani kesalahan
            return back()->withError('Gagal membuat berita dari data laporan. Pesan Kesalahan: '.$e->getMessage());
        }
    }
}
