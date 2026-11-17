
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Models\Project;
use App\Models\Profile;
use App\Models\Message;
use App\Models\Certificate;
use App\Models\Testimonial;
use App\Models\Skill;

// ==========================================
// HALAMAN UTAMA PORTOFOLIO
// ==========================================

Route::get('/', function () {
    return view('home', [
        'projects' => Project::all(),
        'profile' => Profile::first(),
        'skills' => Skill::all(),
        'certificates' => Certificate::all(),
        'messages' => Message::latest()->get(),
        'testimonis' => Testimonial::latest()->get()
    ]);
})->name('home');


// ==========================================
// HALAMAN DETAIL BLOG
// ==========================================

Route::get('/blog/{id}', function ($id) {
    return view('blog.detail', ['id' => $id]);
});


// ==========================================
// FITUR PENGUNJUNG
// ==========================================

// Kirim pesan pengunjung
Route::post('/kirim-pesan', [AdminController::class, 'storeMessage'])
    ->name('pesan.store');

// Kirim testimoni pengunjung
// Tidak memerlukan login admin
Route::post('/admin/testimonial/store', [AdminController::class, 'storeTestimonial'])
    ->name('testimonial.store');

// Download CV
Route::get('/download-cv', function () {
    $profile = Profile::first();

    if ($profile && $profile->file_cv) {
        $path = public_path('files/' . $profile->file_cv);

        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    return redirect()->back()->with('error', 'File CV belum tersedia.');
})->name('cv.download');


// ==========================================
// LOGIN ADMIN
// ==========================================

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Proses login
Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        // Setelah login langsung ke dashboard admin
        return redirect()->route('admin.index');
    }

    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');

})->middleware('guest');


// ==========================================
// LOGOUT ADMIN
// ==========================================

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');

})->name('logout')->middleware('auth');


// ==========================================
// ROUTE KHUSUS ADMIN
// ==========================================

Route::middleware('auth')->group(function () {

    // Dashboard Admin
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');


    // ======================================
    // CRUD PROYEK
    // ======================================

    Route::post('/admin/store', [AdminController::class, 'storeProject'])
        ->name('projects.store');

    Route::put('/admin/update/{id}', [AdminController::class, 'updateProject'])
        ->name('projects.update');

    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroyProject'])
        ->name('projects.delete');


    // ======================================
    // UPDATE PROFIL DAN CV
    // ======================================

    Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])
        ->name('profile.update');


    // ======================================
    // SERTIFIKAT DAN PRESTASI
    // ======================================

    Route::post('/admin/certificate/store', [AdminController::class, 'storeCertificate'])
        ->name('certificates.store');

    Route::delete('/admin/certificate/delete/{id}', [AdminController::class, 'destroyCertificate'])
        ->name('certificates.delete');


    // ======================================
    // TESTIMONI KHUSUS ADMIN
    // ======================================

    // Hapus testimoni
    Route::delete('/admin/testimonial/delete/{id}', [AdminController::class, 'destroyTestimonial'])
        ->name('testimonial.delete');

});
