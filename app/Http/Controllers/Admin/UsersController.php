<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Google\Cloud\Firestore\FirestoreClient;

class UsersController extends Controller
{
    public function index()
    {
        if (!Gate::allows('user_access')) {
            return abort(401);
        }
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!Gate::allows('user_create')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $currency = \App\Currency::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.users.create', compact('roles', 'currency'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        try {
            $factory = (new Factory)->withServiceAccount(base_path('serviceAccount.json'));
            $firestore = $factory->createFirestore();
            Log::info('Firestore connection established successfully.');

            $usersCollection = $firestore->database()->collection('users');
            Log::info('Users collection reference obtained successfully.');

            $documentId = preg_replace('/[^a-zA-Z0-9_]/', '', strtolower($user->firstname . '_' . $user->lastname));
            $userDocument = $usersCollection->document($documentId);

            $userDocument->set([
                'nik' => $user->nik,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'phone' => $user->phone,
                'email' => $user->email,
            ]);
            Log::info('User document set successfully', ['documentId' => $documentId, 'nik' => $user->nik]);
        } catch (\Exception $e) {
            Log::error('Error setting user document in Firestore', ['message' => $e->getMessage()]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        if (!Gate::allows('user_edit')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $currency = \App\Currency::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user', 'roles', 'currency'));
    }

    public function update(UpdateUsersRequest $request, $id)
    {
        if (!Gate::allows('user_edit')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->update($request->all());

        try {
            $factory = (new Factory)->withServiceAccount(base_path('serviceAccount.json'));
            $firestore = $factory->createFirestore();
            Log::info('Firestore connection established successfully.');

            $usersCollection = $firestore->database()->collection('users');
            Log::info('Users collection reference obtained successfully.');

            $documentId = preg_replace('/[^a-zA-Z0-9_]/', '', strtolower($user->firstname . '_' . $user->lastname));
            $userDocument = $usersCollection->document($documentId);

            $userDocument->set([
                'nik' => $user->nik,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'phone' => $user->phone,
                'email' => $user->email,
            ], ['merge' => true]);
            Log::info('User document updated successfully', ['documentId' => $documentId, 'nik' => $user->nik]);
        } catch (\Exception $e) {
            Log::error('Error updating user document in Firestore', ['message' => $e->getMessage()]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function show($id)
    {
        if (!Gate::allows('user_view')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $expense_categories = \App\ExpenseCategory::where('created_by_id', $id)->get();
        $income_categories = \App\IncomeCategory::where('created_by_id', $id)->get();
        $currencies = \App\Currency::where('created_by_id', $id)->get();
        $incomes = \App\Income::where('created_by_id', $id)->get();
        $expenses = \App\Expense::where('created_by_id', $id)->get();

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'expense_categories', 'income_categories', 'currencies', 'incomes', 'expenses'));
    }

    public function destroy($id)
    {
        if (!Gate::allows('user_delete')) {
            return abort(401);
        }

        $user = User::findOrFail($id);

        try {
            // Initialize Firebase Factory
            $factory = (new Factory)->withServiceAccount(base_path('serviceAccount.json'));
            $firestore = $factory->createFirestore();
            $auth = $factory->createAuth();

            // Firestore: Delete user document from Firestore
            $usersCollection = $firestore->database()->collection('users');
            $query = $usersCollection->where('email', '=', $user->email);
            $documents = $query->documents();

            foreach ($documents as $document) {
                $document->reference()->delete();
            }

            // Firebase Authentication: Delete user from Firebase Authentication
            $authUser = $auth->getUserByEmail($user->email);
            $auth->deleteUser($authUser->uid);

            Log::info('User successfully deleted from Firestore and Firebase Authentication.', ['email' => $user->email]);

            // Delete user from local database
            $user->delete();

            Log::info('User successfully deleted from local database.', ['email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('Error deleting user from Firestore or Firebase Authentication', ['message' => $e->getMessage()]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        if (!Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                try {
                    // Initialize Firebase Factory
                    $factory = (new Factory)->withServiceAccount(base_path('serviceAccount.json'));
                    $firestore = $factory->createFirestore();
                    $auth = $factory->createAuth();

                    // Firestore: Delete user document from Firestore
                    $usersCollection = $firestore->database()->collection('users');
                    $query = $usersCollection->where('email', '=', $entry->email);
                    $documents = $query->documents();

                    foreach ($documents as $document) {
                        $document->reference()->delete();
                    }

                    // Firebase Authentication: Delete user from Firebase Authentication
                    $authUser = $auth->getUserByEmail($entry->email);
                    $auth->deleteUser($authUser->uid);

                    Log::info('User successfully deleted from Firestore and Firebase Authentication.', ['email' => $entry->email]);

                    // Delete user from local database
                    $entry->delete();

                    Log::info('User successfully deleted from local database.', ['email' => $entry->email]);
                } catch (\Exception $e) {
                    Log::error('Error deleting user from Firestore or Firebase Authentication', ['message' => $e->getMessage()]);
                }
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Users deleted successfully.');
    }
}
