<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use App\ExpenseCategory;
use App\Report;

class ExpenseCategoriesController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $serviceAccountPath = 'D:/project/admin_bpbd/serviceAccount.json'; // Jalur absolut ke file

        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->withDatabaseUri('https://console.firebase.google.com/project/resqube-bcc0b/firestore/databases/-default-/data/~2Flaporan~2FM91A99MVCZ4DD6wL8KbN?hl=id'); // Ganti dengan URI database Firebase Anda

        $this->firestore = $factory->createFirestore()->database();
    }

    /**
     * Display a listing of reports from Firestore.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('expense_category_access')) {
            return abort(401);
        }
    
        $laporanRef = $this->firestore->collection('laporan');
        $query = $laporanRef;
    
        if ($request->filled('disasterType')) {
            $query = $query->where('disasterType', '==', $request->input('disasterType'));
        }
    
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = strtotime($request->input('startDate')) * 1000; // Convert to milliseconds
            $endDate = strtotime($request->input('endDate')) * 1000; // Convert to milliseconds
            $query = $query->where('timestamp', '>=', $startDate)->where('timestamp', '<=', $endDate);
        }
    
        $laporanDocuments = $query->documents();
        $laporanData = [];
    
        foreach ($laporanDocuments as $document) {
            if ($document->exists()) {
                $laporanData[] = array_merge($document->data(), ['id' => $document->id()]);
            }
        }
    
        return view('admin.expense_categories.index', compact('laporanData'));
    }
    
    
    public function create(Request $request)
    {
        // Ambil data laporan berdasarkan id dari request
        $laporanId = $request->get('laporan_id');
        if (!$laporanId) {
            return redirect()->back()->with('error', 'Laporan ID tidak ditemukan dalam permintaan.');
        }
    
        $laporanSnapshot = $this->firestore->collection('laporan')->document($laporanId)->snapshot();
    
        // Jika laporan tidak ditemukan, beri respon yang sesuai
        if (!$laporanSnapshot->exists()) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }
    
        $laporan = $laporanSnapshot->data();
        $laporan['id'] = $laporanId;  // Tambahkan ID dokumen ke data laporan
    
        return view('admin.expense_categories.create', compact('laporan'));
    }

    /**
     * Remove ExpenseCategory from Firestore.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('expense_category_delete')) {
            return abort(401);
        }
        
        // Hapus data dari Firestore
        $this->firestore->collection('laporan')->document($id)->delete();

        return redirect()->route('admin.expense_categories.index');
    }

    /**
     * Show details of a specific report from Firestore.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laporanSnapshot = $this->firestore->collection('laporan')->document($id)->snapshot();
    
        if (!$laporanSnapshot->exists()) {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $laporan = $laporanSnapshot->data();
    
        return view('admin.expense_categories.show', compact('laporan'));
    }

    public function store(Request $request)
    {
        $laporanId = $request->input('laporan_id');
        $laporanSnapshot = $this->firestore->collection('laporan')->document($laporanId)->snapshot();
        
        if (!$laporanSnapshot->exists()) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        // Ambil data laporan
        $laporanData = $laporanSnapshot->data();

        // Tambahkan field 'berita_created' jika belum ada
        if (!isset($laporanData['berita_created'])) {
            $this->firestore->collection('laporan')->document($laporanId)->set([
                'berita_created' => false,
            ], ['merge' => true]);
            // Refresh laporanData after setting the new field
            $laporanSnapshot = $this->firestore->collection('laporan')->document($laporanId)->snapshot();
            $laporanData = $laporanSnapshot->data();
        }

        // Cek apakah laporan sudah dijadikan berita sebelumnya
        if ($laporanData['berita_created']) {
            return redirect()->back()->with('error', 'Laporan ini sudah dijadikan berita sebelumnya.');
        }

        try {
            // Tambahkan berita baru ke koleksi 'berita'
            $this->firestore->collection('berita')->add([
                'deskripsi' => $request->input('deskripsi_berita'),
                'gambar' => $laporanData['imageUrl'],
                'jenis_bencana' => $laporanData['disasterType'],
                'waktu_pelaporan' => $laporanData['timestamp'],
            ]);

            // Tandai laporan sebagai sudah dijadikan berita
            $this->firestore->collection('laporan')->document($laporanId)->set([
                'berita_created' => true,
            ], ['merge' => true]);

            return redirect()->back()->with('success', 'Berita berhasil disimpan.');
        } catch (\Exception $e) {
            error_log('Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan berita. Terjadi kesalahan dalam penyimpanan data.');
        }
    }

    public function getData()
    {
        // Implementasi untuk mengambil data dari ExpenseCategoriesController
        // Misalnya, Anda bisa melakukan sesuatu seperti ini:
        $expenseCategoriesData = ExpenseCategory::all();
        return $expenseCategoriesData;
    }
}
