<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;

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
            $query = $query->where('timestamp', '>=', $startDate);
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

    /**
     * Remove ExpenseCategory from Firestore.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('expense_category_delete')) {
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
            abort(404, 'Laporan not found');
        }
    
        $laporan = $laporanSnapshot->data();
    
        return view('admin.expense_categories.show', compact('laporan'));
    }
}
