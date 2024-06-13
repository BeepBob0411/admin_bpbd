<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory; // Import the Factory class from Kreait\Firebase namespace
use App\Http\Requests\Admin\StoreIncomesRequest;
use App\Http\Requests\Admin\UpdateIncomesRequest;
use App\Income; // Import the Income model
use Validator; // Import Validator for input validation

class IncomesController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $serviceAccountPath = 'D:/project/admin_bpbd/serviceAccount.json'; // Absolute path to your service account JSON file
        $firebaseDatabaseUri = 'https://console.firebase.google.com/project/resqube-bcc0b/firestore/databases/-default-/data/~2Flaporan~2FM91A99MVCZ4DD6wL8KbN?hl=id'; // Replace with your Firebase Database URI

        // Create the Firestore instance using Firebase Factory
        $firebaseFactory = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->withDatabaseUri($firebaseDatabaseUri);

        $this->firestore = $firebaseFactory->createFirestore()->database();
    }

    /**
     * Display a listing of Incomes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is authorized to view incomes using Gate
        if (!Gate::allows('income_access')) {
            return abort(401);
        }

        // Initialize an empty array to store incomes
        $incomes = [];

        try {
            // Get reference to the collection 'peringatan'
            $incomeRef = $this->firestore->collection('peringatan');

            // Query all documents in the 'peringatan' collection
            $query = $incomeRef->documents();

            // Iterate through documents and populate $incomes array
            foreach ($query as $document) {
                $incomeData = $document->data();
                $timestamp = $incomeData['waktu_peringatan'];
                
                // Convert Firestore Timestamp to PHP DateTime
                if ($timestamp instanceof Timestamp) {
                    $waktu_peringatan = $timestamp->toDateTime()->format('F j, Y \a\t H:i:s T');
                } else {
                    $waktu_peringatan = null;
                }

                $incomes[] = (object) [
                    'id' => $document->id(),
                    'nama_bencana' => $incomeData['nama_bencana'],
                    'isi_peringatan' => $incomeData['isi_peringatan'],
                    'waktu_peringatan' => $waktu_peringatan,
                ];
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage()); // Output error message for debugging
        }

        // Pass $incomes array to the view
        return view('admin.incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating new Income.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('income_create')) {
            return abort(401);
        }

        // Example: Fetch necessary data like categories or users
        $income_categories = \App\IncomeCategory::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.incomes.create', compact('income_categories', 'created_bies'));
    }

    /**
     * Store a newly created Income in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'nama_bencana' => 'required|string',
            'isi_peringatan' => 'required|string',
            'waktu_peringatan' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepare new income data
        $newIncome = [
            'nama_bencana' => $request->nama_bencana,
            'isi_peringatan' => $request->isi_peringatan,
            'waktu_peringatan' => $request->waktu_peringatan,
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        // Save data to Firestore
        try {
            $this->firestore->collection('peringatan')->add($newIncome);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage()); // Output error message for debugging
        }

        return redirect()->route('admin.incomes.index');
    }

    /**
     * Show the form for editing Income.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('income_edit')) {
            return abort(401);
        }

        // Example: Fetch income data by ID
        $income = Income::findOrFail($id);
        $income_categories = \App\IncomeCategory::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.incomes.edit', compact('income', 'income_categories', 'created_bies'));
    }

    /**
     * Update Income in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('income_edit')) {
            return abort(401);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'nama_bencana' => 'required|string',
            'isi_peringatan' => 'required|string',
            'waktu_peringatan' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update income data
        try {
            $incomeRef = $this->firestore->collection('peringatan')->document($id);
            $incomeRef->update([
                'nama_bencana' => $request->nama_bencana,
                'isi_peringatan' => $request->isi_peringatan,
                'waktu_peringatan' => $request->waktu_peringatan,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage()); // Output error message for debugging
        }

        return redirect()->route('admin.incomes.index');
    }

    /**
     * Display the specified Income.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('income_view')) {
            return abort(401);
        }

        // Example: Fetch income data by ID
        $income = Income::findOrFail($id);

        return view('admin.incomes.show', compact('income'));
    }

    /**
     * Remove the specified Income from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('income_delete')) {
            return abort(401);
        }

        // Example: Delete income record by ID
        try {
            $this->firestore->collection('peringatan')->document($id)->delete();
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage()); // Output error message for debugging
        }

        return redirect()->route('admin.incomes.index');
    }

    /**
     * Delete all selected Incomes at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('income_delete')) {
            return abort(401);
        }

        // Example: Delete multiple income records based on IDs
        try {
            $ids = $request->input('ids');
            foreach ($ids as $id) {
                $this->firestore->collection('peringatan')->document($id)->delete();
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage()); // Output error message for debugging
        }
    }
}
