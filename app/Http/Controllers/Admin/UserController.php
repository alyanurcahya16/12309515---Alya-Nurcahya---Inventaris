<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OperatorsExport;

use Exception;

class UserController extends Controller
{
    /**
     * Display admin users (alias untuk index)
     */
    public function index()
    {
        $stats = [
            'users' => User::where('role', 'admin')->count(),
            'operators' => User::where('role', 'operator')->count(),
            'total_users' => User::count(),
            // Tambah stats lain sesuai kebutuhan
            'pending' => 0, // contoh
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function admins()
    {
        $users = User::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.users-admin', compact('users'));
    }

    /**
     * Display operator users
     */
    public function users()
    {
        $users = User::where('role', 'operator')
            ->latest()
            ->paginate(10);

        return view('admin.users-operator', compact('users'));
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'role'  => 'required|in:admin,operator',
            ]);

            $generatedPassword = $this->generateSecurePassword();

            $user = User::create([
                ...$validated,
                'password' => Hash::make($generatedPassword),
                'password_changed' => false,
            ]);

            return back()->with([
                'success' => 'User berhasil ditambahkan!',
                'generated_password' => $generatedPassword,
                'show_modal' => false, // tutup modal
            ]);

        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('show_modal', true)
                ->with('error', 'Data tidak valid!');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan user: ' . $e->getMessage())
                ->with('show_modal', true);
        }
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
                'role'     => 'required|in:admin,operator',
                'password' => 'nullable|min:8|confirmed',
            ]);

            // Handle password
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
                $validated['password_changed'] = true;
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return back()->with('success', 'User berhasil diupdate!');

        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('show_modal', true);
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        try {
            $generatedPassword = $this->generateSecurePassword();

            $user->update([
                'password' => Hash::make($generatedPassword),
                'password_changed' => false,
            ]);

            return back()->with([
                'success' => 'Password berhasil direset!',
                'generated_password' => $generatedPassword,
            ]);

        } catch (Exception $e) {
            return back()->with('error', 'Gagal reset password!');
        }
    }

    /**
     * Delete user (soft delete recommended)
     */
    public function destroy(User $user)
    {
        try {
            // Sekarang auth()->id() tidak merah
            if (Auth::id() === $user->id) {
                return back()->with('error', 'Tidak bisa hapus akun sendiri!');
            }

            $user->delete();
            return back()->with('success', 'User berhasil dihapus!');

        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus user!');
        }

    }

    /**
     * Generate secure random password
     */
    private function generateSecurePassword($length = 10)
    {
        $patterns = [
            Str::random(4), // random
            substr($request->email ?? 'user', 0, 3), // 3 huruf email
            rand(100, 999), // 3 digit angka
            Str::random(1, '0123456789!@#$%'), // special char
        ];

        return implode('', $patterns);
    }

// Tambahkan 2 method ini
public function exportExcel()
{
    return Excel::download(new UsersExport, 'admin-accounts-' . now()->format('Ymd') . '.xlsx');
}

public function exportPdf()
{
    $users = User::where('role', 'admin')->get();
    $pdf = Pdf::loadView('admin.exports.users-pdf', compact('users'));
    return $pdf->download('admin-accounts-' . now()->format('Ymd') . '.pdf');
}

public function exportOperatorsExcel()
{
    return Excel::download(new OperatorsExport, 'operators-' . now()->format('Ymd') . '.xlsx');
}

public function exportOperatorsPdf()
{
    $users = User::where('role', 'operator')->get();
    $pdf = Pdf::loadView('admin.exports.operators-pdf', compact('users'));
    return $pdf->download('operators-' . now()->format('Ymd') . '.pdf');
}
}
