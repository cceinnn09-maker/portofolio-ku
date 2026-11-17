
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
// HALAMAN UTAMA PENGUNJUNG
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
// HALAMAN BLOG
// ==========================================

Route::get('/blog/{id}', function ($id) {
    return view('blog.detail', ['id' => $id]);
});


// ==========================================
// KIRIM PESAN PENGUNJUNG
// ==========================================

Route::post('/kirim-pesan', [AdminController::class, 'storeMessage'])
    ->name('pesan.store');


// ==========================================
// KIRIM TESTIMONI PENGUNJUNG
// ==========================================

Route::post('/admin/testimonial/store', [AdminController::class, 'storeTestimonial'])
    ->name('testimonial.store');


// ==========================================
// DOWNLOAD CV
// ==========================================

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


Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Coba login menggunakan email dan password
    if (Auth::attempt($credentials)) {

        // Perbarui session setelah login berhasil
        $request->session()->regenerate();

        // Arahkan langsung ke panel admin
        return redirect('/admin');
    }

    // Jika login gagal
    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');

})->middleware('guest');


// ==========================================
// ROUTE KHUSUS ADMIN
// ==========================================

Route::middleware('auth')->group(function () {

    // DASHBOARD ADMIN
    Route::get('/admin', function () {
        return redirect('/#kelola-karya');
    })->name('admin.dashboard');


    // LOGOUT
    Route::post('/logout', function (Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');

    })->name('logout');


    // ======================================
    // CRUD PROJECT
    // ======================================

    Route::post('/admin/store', [AdminController::class, 'storeProject'])
        ->name('projects.store');

    Route::put('/admin/update/{id}', [AdminController::class, 'updateProject'])
        ->name('projects.update');

    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroyProject'])
        ->name('projects.delete');


    // ======================================
    // UPDATE PROFIL
    // ======================================

    Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])
        ->name('profile.update');


    // ======================================
    // CRUD SERTIFIKAT
    // ======================================

    Route::post('/admin/certificate/store', [AdminController::class, 'storeCertificate'])
        ->name('certificates.store');

    Route::delete('/admin/certificate/delete/{id}', [AdminController::class, 'destroyCertificate'])
        ->name('certificates.delete');


    // ======================================
    // HAPUS TESTIMONI
    // ======================================

    Route::delete('/admin/testimonial/delete/{id}', [AdminController::class, 'destroyTestimonial'])
        ->name('testimonial.delete');

});
