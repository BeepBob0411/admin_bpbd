<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class IncomeCategoriesController extends Controller
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

    public function index()
    {
        try {
            // Pagination setup
            $perPage = 10; // Number of reports per page
            $currentPage = request()->get('page', 1); // Current page, default is 1

            // Fetching berita data with pagination
            $beritaRef = $this->firestore->collection('berita')
                ->offset(($currentPage - 1) * $perPage)
                ->limit($perPage);
            $beritaDocuments = $beritaRef->documents();
            $totalBerita = $this->firestore->collection('berita')->documents()->size();

            $berita = [];
            foreach ($beritaDocuments as $document) {
                if ($document->exists()) {
                    $data = $document->data();
                    $data['id'] = $document->id();
                    $berita[] = $data;
                }
            }
            $beritaPaginator = new LengthAwarePaginator($berita, $totalBerita, $perPage, $currentPage);

            // Fetching laporan data
            $laporanData = $this->getLaporanData(); // Ensure this method is implemented correctly

            // Adding berita_created status to laporanData
            foreach ($laporanData as &$report) {
                $report['berita_created'] = false;
                foreach ($berita as $news) {
                    if (isset($news['laporan_id']) && $news['laporan_id'] === $report['id']) {
                        $report['berita_created'] = true;
                        break;
                    }
                }
            }
            return view('admin.income_categories.index', compact('beritaPaginator', 'laporanData'));        } catch (\Exception $e) {
            Log::error('Error fetching data from Firebase: ' . $e->getMessage());
            return back()->withError('Gagal mengambil data. Pesan Kesalahan: ' . $e->getMessage());
        }
    }

    private function getLaporanData()
    {
        try {
            $laporanRef = $this->firestore->collection('laporan');
            $laporanDocuments = $laporanRef->documents();
            $laporanData = [];

            foreach ($laporanDocuments as $document) {
                if ($document->exists()) {
                    $laporanData[] = array_merge($document->data(), ['id' => $document->id()]);
                }
            }

            return $laporanData;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function show($id)
    {
        try {
            $beritaRef = $this->firestore->collection('berita')->document($id);
            $snapshot = $beritaRef->snapshot();

            if ($snapshot->exists()) {
                $berita = $snapshot->data();
                $berita['id'] = $id;
                $berita['nama_bencana'] = $berita['nama_bencana'] ?? 'Nama Bencana Tidak Tersedia';
                $berita['tanggal_kejadian'] = $berita['tanggal_kejadian'] ?? 'Tanggal Tidak Tersedia';
                $berita['waktu_kejadian'] = $berita['waktu_kejadian'] ?? 'Waktu Tidak Tersedia';
                $berita['lokasi_kejadian'] = $berita['lokasi_kejadian'] ?? 'Lokasi Tidak Tersedia';
                $berita['deskripsi_berita'] = $berita['deskripsi_berita'] ?? 'Deskripsi Tidak Tersedia';

                Log::info('Berita data: ', $berita);

                return view('admin.income_categories.show', compact('berita'));
            } else {
                return back()->withError('Berita tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching berita from Firebase: ' . $e->getMessage());
            return back()->withError('Gagal mengambil data berita. Pesan Kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $beritaRef = $this->firestore->collection('berita')->document($id);
            $snapshot = $beritaRef->snapshot();

            if ($snapshot->exists()) {
                $berita = $snapshot->data();
                $berita['id'] = $id;
                $berita['tanggal_kejadian'] = $berita['tanggal_kejadian'] ?? '';

                return view('admin.income_categories.edit', compact('berita'));
            } else {
                return back()->withError('Berita tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching berita from Firebase: ' . $e->getMessage());
            return back()->withError('Gagal mengambil data berita. Pesan Kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'deskripsi_berita' => 'required|string',
            ]);

            $this->firestore->collection('berita')->document($id)->update([
                ['path' => 'deskripsi', 'value' => $request->deskripsi_berita],
            ]);

            $updatedBerita = $this->firestore->collection('berita')->document($id)->snapshot()->data();
            $updatedBerita['id'] = $id;

            return redirect()->route('admin.income_categories.index')->with('success', 'Deskripsi berita berhasil diperbarui')->with('berita', $updatedBerita);
        } catch (\Exception $e) {
            Log::error('Error updating berita: ' . $e->getMessage());
            return back()->withError('Gagal memperbarui deskripsi berita. Pesan Kesalahan: ' . $e->getMessage());
        }
    }

    public function loadMoreBerita(Request $request)
    {
        try {
            $perPage = 10;
            $currentPage = $request->get('page', 1);

            $beritaRef = $this->firestore->collection('berita')->offset(($currentPage - 1) * $perPage)->limit($perPage);
            $beritaDocuments = $beritaRef->documents();

            $berita = [];

            foreach ($beritaDocuments as $document) {
                if ($document->exists()) {
                    $data = $document->data();
                    $data['id'] = $document->id();
                    $berita[] = $data;
                }
            }

            $view = view('admin.income_categories._berita_partial', compact('berita'))->render();

            return response()->json($view);
        } catch (\Exception $e) {
            Log::error('Error fetching berita from Firebase: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load more berita. Error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Retrieve the document reference for the berita
            $beritaRef = $this->firestore->collection('berita')->document($id);
            $beritaSnapshot = $beritaRef->snapshot();
            
            if (!$beritaSnapshot->exists()) {
                return back()->withError('Berita tidak ditemukan.');
            }
            
            // Get the related laporan ID from the berita data
            $beritaData = $beritaSnapshot->data();
            $laporanId = $beritaData['laporan_id'] ?? null;

            // Delete the berita document
            $beritaRef->delete();

            // Update the laporan document to set 'berita_created' to false
            if ($laporanId) {
                $laporanRef = $this->firestore->collection('laporan')->document($laporanId);
                $laporanRef->set(['berita_created' => false], ['merge' => true]);
            }

            return redirect()->route('admin.income_categories.index')->with('success', 'Berita berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting berita: ' . $e->getMessage());
            return back()->withError('Gagal menghapus berita. Pesan Kesalahan: ' . $e->getMessage());
        }
    }
}
