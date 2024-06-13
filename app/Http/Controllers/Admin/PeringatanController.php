<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use App\Http\Controllers\Controller;

class PeringatanController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $serviceAccountPath = 'D:/project/admin_bpbd/serviceAccount.json'; // Path to your service account file
        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->withDatabaseUri('https://console.firebase.google.com/u/0/project/resqube-bcc0b/firestore/databases/-default-/data/~2Fperingatan~2FsZ83ey7nEzo9buxZ87rs?hl=id'); // Replace with your Firebase database URI
        $this->firestore = $factory->createFirestore()->database();
    }

    public function index()
    {
        try {
            $peringatanRef = $this->firestore->collection('peringatan');
            $peringatanDocuments = $peringatanRef->documents();
            $peringatanData = [];
    
            foreach ($peringatanDocuments as $document) {
                if ($document->exists()) {
                    $peringatanData[] = array_merge($document->data(), ['id' => $document->id()]);
                }
            }
    
            // Mengirimkan data peringatan ke view dengan nama variabel yang benar
            return view('admin.incomes.index', compact('peringatanData'));
        } catch (\Exception $e) {
            Log::error('Error fetching data from Firebase: ' . $e->getMessage());
            return back()->withError('Failed to fetch data. Error: ' . $e->getMessage());
        }
    }
    

    public function show($id)
    {
        try {
            $peringatanRef = $this->firestore->collection('peringatan')->document($id);
            $snapshot = $peringatanRef->snapshot();

            if ($snapshot->exists()) {
                $peringatan = $snapshot->data();
                $peringatan['id'] = $id;

                return view('admin.peringatan.show', compact('peringatan'));
            } else {
                return back()->withError('Peringatan not found.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching peringatan from Firebase: ' . $e->getMessage());
            return back()->withError('Failed to fetch peringatan data. Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $peringatanRef = $this->firestore->collection('peringatan')->document($id);
            $snapshot = $peringatanRef->snapshot();

            if ($snapshot->exists()) {
                $peringatan = $snapshot->data();
                $peringatan['id'] = $id;

                return view('admin.peringatan.edit', compact('peringatan'));
            } else {
                return back()->withError('Peringatan not found.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching peringatan from Firebase: ' . $e->getMessage());
            return back()->withError('Failed to fetch peringatan data. Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'nama_bencana' => 'required|string',
                'isi_peringatan' => 'required|string',
                'waktu_peringatan' => 'required|string',
            ]);

            $this->firestore->collection('peringatan')->document($id)->update([
                ['path' => 'nama_bencana', 'value' => $request->nama_bencana],
                ['path' => 'isi_peringatan', 'value' => $request->isi_peringatan],
                ['path' => 'waktu_peringatan', 'value' => $request->waktu_peringatan],
            ]);

            $updatedPeringatan = $this->firestore->collection('peringatan')->document($id)->snapshot()->data();
            $updatedPeringatan['id'] = $id;

            return redirect()->route('admin.peringatan.index')->with('success', 'Peringatan successfully updated')->with('peringatan', $updatedPeringatan);
        } catch (\Exception $e) {
            Log::error('Error updating peringatan: ' . $e->getMessage());
            return back()->withError('Failed to update peringatan. Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $peringatanRef = $this->firestore->collection('peringatan')->document($id);
            $peringatanSnapshot = $peringatanRef->snapshot();

            if (!$peringatanSnapshot->exists()) {
                return back()->withError('Peringatan not found.');
            }

            $peringatanRef->delete();

            return redirect()->route('admin.peringatan.index')->with('success', 'Peringatan successfully deleted');
        } catch (\Exception $e) {
            Log::error('Error deleting peringatan: ' . $e->getMessage());
            return back()->withError('Failed to delete peringatan. Error: ' . $e->getMessage());
        }
    }
}
