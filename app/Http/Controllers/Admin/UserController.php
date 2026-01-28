<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->query('q', '');

        $users = User::query()
            ->when($q !== '', fn ($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('username', 'like', "%{$q}%")
                ->orWhere('role', 'like', "%{$q}%")
            )
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'user' => $request->user(),
            'users' => $users,
            'q' => $q,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.users.form', [
            'user' => $request->user(),
            'model' => new User(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:tb_users,username'],
            'password' => ['required', 'string', 'min:3'],
            'role' => ['required', Rule::in(['admin', 'petugas', 'owner'])],
        ]);

        $data['password'] = Hash::make($data['password']);

        $created = User::create($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD User: membuat user #{$created->id} ({$created->username})",
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(Request $request, User $user)
    {
        return view('admin.users.form', [
            'user' => $request->user(),
            'model' => $user,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('tb_users', 'username')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:3'],
            'role' => ['required', Rule::in(['admin', 'petugas', 'owner'])],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD User: mengubah user #{$user->id} ({$user->username})",
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Tidak bisa menghapus akun yang sedang login.');
        }

        $id = $user->id;
        $username = $user->username;
        $user->delete();

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD User: menghapus user #{$id} ({$username})",
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}

