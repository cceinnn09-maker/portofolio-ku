<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ==========================================
// HALAMAN PENGUNJUNG
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog/{id}', [HomeController::class, 'blogShow'])->name('blog.show');
Route::get('/download-cv', [HomeController::class, 'downloadCv'])->name('cv.download');

Route::post('/kirim-pesan', [HomeController::class, 'storeMessage'])->name('pesan.store');
Route::post('/kirim-testimoni', [HomeController::class, 'storeTestimonial'])->name('testimonial.store');

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

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');
})->middleware('guest');

// ==========================================
// ROUTE KHUSUS ADMIN
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // Profil / informasi pribadi
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // Konten website (settings)
    Route::post('/admin/settings', [AdminController::class, 'storeSetting'])->name('admin.settings.store');
    Route::put('/admin/settings/{id}', [AdminController::class, 'updateSetting'])->name('admin.settings.update');
    Route::delete('/admin/settings/{id}', [AdminController::class, 'destroySetting'])->name('admin.settings.delete');

    // Riwayat pendidikan
    Route::post('/admin/education', [AdminController::class, 'storeEducation'])->name('admin.education.store');
    Route::put('/admin/education/{id}', [AdminController::class, 'updateEducation'])->name('admin.education.update');
    Route::delete('/admin/education/{id}', [AdminController::class, 'destroyEducation'])->name('admin.education.delete');

    // Keahlian
    Route::post('/admin/skills', [AdminController::class, 'storeSkill'])->name('admin.skills.store');
    Route::put('/admin/skills/{id}', [AdminController::class, 'updateSkill'])->name('admin.skills.update');
    Route::delete('/admin/skills/{id}', [AdminController::class, 'destroySkill'])->name('admin.skills.delete');

    // Project
    Route::post('/admin/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::put('/admin/projects/{id}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/admin/projects/{id}', [AdminController::class, 'destroyProject'])->name('projects.delete');

    // Sertifikat & prestasi
    Route::post('/admin/certificates', [AdminController::class, 'storeCertificate'])->name('certificates.store');
    Route::put('/admin/certificates/{id}', [AdminController::class, 'updateCertificate'])->name('certificates.update');
    Route::delete('/admin/certificates/{id}', [AdminController::class, 'destroyCertificate'])->name('certificates.delete');

    // Pengalaman
    Route::post('/admin/experiences', [AdminController::class, 'storeExperience'])->name('admin.experiences.store');
    Route::put('/admin/experiences/{id}', [AdminController::class, 'updateExperience'])->name('admin.experiences.update');
    Route::delete('/admin/experiences/{id}', [AdminController::class, 'destroyExperience'])->name('admin.experiences.delete');

    // Blog
    Route::post('/admin/posts', [AdminController::class, 'storePost'])->name('admin.posts.store');
    Route::put('/admin/posts/{id}', [AdminController::class, 'updatePost'])->name('admin.posts.update');
    Route::delete('/admin/posts/{id}', [AdminController::class, 'destroyPost'])->name('admin.posts.delete');

    // Testimoni (admin)
    Route::post('/admin/testimonials', [AdminController::class, 'storeTestimonialAdmin'])->name('admin.testimonials.store');
    Route::put('/admin/testimonials/{id}', [AdminController::class, 'updateTestimonial'])->name('admin.testimonials.update');
    Route::delete('/admin/testimonials/{id}', [AdminController::class, 'destroyTestimonial'])->name('testimonial.delete');

    // Pesan masuk
    Route::delete('/admin/messages/{id}', [AdminController::class, 'destroyMessage'])->name('pesan.delete');
});
