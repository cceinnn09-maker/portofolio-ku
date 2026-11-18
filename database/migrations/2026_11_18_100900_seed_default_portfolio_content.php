<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        // ============================================
        // PROFIL DEFAULT
        // ============================================
        // Jangan menimpa konten yang sudah diedit admin. Isi hanya kolom
        // yang masih kosong (mis. saat database lama belum punya kolom baru).
        $profileDefaults = [
            'nama_lengkap' => 'Nurhaina',
            'kelas' => 'XII PPLG',
            'kompetensi_keahlian' => 'Pengembangan Perangkat Lunak dan Gim (PPLG)',
            'deskripsi_singkat' => 'Berfokus khusus pada perancangan UI/UX Design dan antarmuka aplikasi digital yang solutif serta estetis.',
            'foto' => 'ennnaa.jpg',
            'email' => 'nurhaina.pplg@gmail.com',
            'github' => 'https://github.com/',
            'instagram' => 'https://www.instagram.com/ainnaanr__',
            'linkedin' => 'https://www.linkedin.com/',
            'tiktok' => 'https://www.tiktok.com/@iniii.ena',
            'alamat' => 'Banjarmasin, Kalimantan Selatan',
            'about_text' => 'Saya adalah siswi kelas PPLG di SMK Negeri 2 Banjarmasin. Berfokus mendalami bidang UI/UX Design, berpengalaman Praktik Latihan Kerja (PLK) di instansi pemerintahan, serta terbiasa berkolaborasi dalam tim untuk merancang sistem aplikasi.',
            'minat_teknologi' => 'Tertarik pada UI/UX Design & Product Design. Teknologi yang dikuasai: Figma, HTML, CSS, Bootstrap, dasar Laravel, dan MySQL.',
            'keahlian_utama' => 'UI/UX Wireframing & Design, User Research, dan Perancangan Layout Antarmuka.',
            'cita_cita' => 'Menjadi UI/UX Designer profesional yang menghadirkan pengalaman pengguna yang intuitif dan menarik.',
        ];

        $existingProfile = DB::table('profiles')->where('id', 1)->first();

        if ($existingProfile === null) {
            DB::table('profiles')->insert(
                ['id' => 1]
                + $profileDefaults
                + ['created_at' => $now, 'updated_at' => $now]
            );
        } else {
            $profileUpdates = [];

            foreach ($profileDefaults as $column => $value) {
                if (($existingProfile->{$column} ?? null) === null) {
                    $profileUpdates[$column] = $value;
                }
            }

            if ($profileUpdates !== []) {
                DB::table('profiles')
                    ->where('id', 1)
                    ->update($profileUpdates + ['updated_at' => $now]);
            }
        }

        // ============================================
        // RIWAYAT PENDIDIKAN
        // ============================================
        if (DB::table('educations')->count() === 0) {
            DB::table('educations')->insert([
                [
                    'jenjang' => 'TK',
                    'institusi' => 'TK AR-RAUDAH',
                    'periode' => null,
                    'keterangan' => 'Pendidikan anak usia dini.',
                    'urutan' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'jenjang' => 'SD',
                    'institusi' => 'SDN TELUK TIRAM 2',
                    'periode' => null,
                    'keterangan' => 'Sekolah dasar.',
                    'urutan' => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'jenjang' => 'SMP',
                    'institusi' => 'SMP NEGERI 4 BANJARMASIN',
                    'periode' => null,
                    'keterangan' => 'Sekolah menengah pertama.',
                    'urutan' => 3,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'jenjang' => 'SMK',
                    'institusi' => 'SMK NEGERI 2 BANJARMASIN',
                    'periode' => '2024 - Sekarang',
                    'keterangan' => 'Kompetensi Keahlian Pengembangan Perangkat Lunak dan Gim (PPLG).',
                    'urutan' => 4,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        // ============================================
        // SKILLS
        // ============================================
        if (DB::table('skills')->count() === 0) {
            $skills = [
                ['nama' => 'UI/UX Wireframing & Design', 'persentase' => 85, 'kategori' => 'hard', 'urutan' => 1],
                ['nama' => 'Layout & Visual Hierarchy', 'persentase' => 80, 'kategori' => 'hard', 'urutan' => 2],
                ['nama' => 'User Research & Flow', 'persentase' => 85, 'kategori' => 'hard', 'urutan' => 3],
                ['nama' => 'Color Theory & Typography', 'persentase' => 80, 'kategori' => 'hard', 'urutan' => 4],
                ['nama' => 'Kerjasama Tim & Kolaborasi', 'persentase' => 85, 'kategori' => 'soft', 'urutan' => 1],
                ['nama' => 'Problem Solving', 'persentase' => 80, 'kategori' => 'soft', 'urutan' => 2],
                ['nama' => 'Manajemen Waktu', 'persentase' => 80, 'kategori' => 'soft', 'urutan' => 3],
                ['nama' => 'Komunikasi Efektif', 'persentase' => 85, 'kategori' => 'soft', 'urutan' => 4],
            ];

            foreach ($skills as $skill) {
                DB::table('skills')->insert($skill + ['created_at' => $now, 'updated_at' => $now]);
            }
        }

        // ============================================
        // PENGALAMAN (PLK, ORGANISASI, LOMBA)
        // ============================================
        if (DB::table('experiences')->count() === 0) {
            DB::table('experiences')->insert([
                [
                    'judul' => 'Praktik Latihan Kerja (PLK)',
                    'posisi' => 'Peserta PLK',
                    'institusi' => 'Kantor Kelurahan',
                    'periode' => '2025',
                    'deskripsi' => 'Melaksanakan Praktik Latihan Kerja di Kantor Kelurahan. Selama PLK saya membantu pengelolaan administrasi perkantoran, penataan dan rekap data warga secara digital, pelayanan masyarakat di front office, serta penyusunan dokumen laporan. Pengalaman ini melatih kedisiplinan, ketelitian, tanggung jawab, dan kemampuan berkomunikasi dengan masyarakat maupun rekan kerja.',
                    'gambar' => null,
                    'jenis' => 'plk',
                    'urutan' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'judul' => 'Anggota Ekstrakurikuler Dance',
                    'posisi' => 'Anggota Ekstrakurikuler Dance (Modern Dance / Traditional Dance)',
                    'institusi' => 'SMK Negeri 2 Banjarmasin',
                    'periode' => '2024 - 2025',
                    'deskripsi' => 'Aktif berlatih koreografi, tampil dalam berbagai event/pensi sekolah, serta bekerja sama dalam tim untuk menyusun pertunjukan tari.',
                    'gambar' => null,
                    'jenis' => 'organisasi',
                    'urutan' => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'judul' => 'Lomba Kompetensi Desain Aplikasi',
                    'posisi' => 'Peserta',
                    'institusi' => 'Tingkat Pelajar',
                    'periode' => null,
                    'deskripsi' => 'Mengikuti lomba di bidang desain UI/UX dan pengembangan aplikasi tingkat pelajar, melatih kesiapan menyajikan karya serta berlatih menghadapi penilaian juri secara profesional.',
                    'gambar' => null,
                    'jenis' => 'lomba',
                    'urutan' => 3,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        // ============================================
        // ARTIKEL BLOG
        // ============================================
        if (DB::table('posts')->count() === 0) {
            DB::table('posts')->insert([
                [
                    'judul' => 'Pentingnya User Flow dalam Perancangan Aplikasi',
                    'slug' => 'pentingnya-user-flow-dalam-perancangan-aplikasi',
                    'kategori' => 'UI/UX Workflow',
                    'ringkasan' => 'Bagaimana menyusun alur pengguna (user flow) yang intuitif sebelum mulai membuat wireframe di Figma agar aplikasi nyaman digunakan.',
                    'konten' => 'Dalam proses pengembangan portofolio dan proyek aplikasi ini, tahapan riset pengguna dan perancangan alur (user flow) di Figma memegang peran yang sangat krusial. Sebagai seorang UI/UX Designer, fokus utama saya adalah memastikan bahwa setiap halaman aplikasi mudah dipahami, memiliki hierarki visual yang jelas, serta nyaman dipandang oleh pengguna.' . "\n\n" . 'User flow membantu saya memetakan langkah-langkah yang akan dilalui pengguna ketika menyelesaikan sebuah tugas. Dengan alur yang rapi, tim pengembang dapat memahami kebutuhan setiap halaman sebelum masuk ke tahap coding. Hal ini mengurangi revisi, menghemat waktu, dan membuat hasil akhir aplikasi lebih konsisten.' . "\n\n" . 'Beberapa hal yang saya terapkan saat menyusun user flow adalah: menentukan tujuan utama pengguna, membuat skenario perjalanan pengguna, menandai titik keputusan penting, dan menguji alur sederhana kepada teman sekelompok sebelum dilanjutkan ke desain high fidelity.',
                    'gambar' => null,
                    'penulis' => 'Nurhaina',
                    'tanggal' => '2026-11-16',
                    'published' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'judul' => 'Pengalaman Kerja Tim PPLG SMKN 2 Banjarmasin',
                    'slug' => 'pengalaman-kerja-tim-pplg-smkn-2-banjarmasin',
                    'kategori' => 'Kolaborasi Tim',
                    'ringkasan' => 'Cerita seru di balik layar saat berkolaborasi bersama tim kelompok dalam merancang sistem aplikasi berbasis web.',
                    'konten' => 'Bekerja dalam tim pengembangan perangkat lunak memberikan pengalaman nyata tentang bagaimana dinamika industri IT bekerja. Di jurusan PPLG SMK Negeri 2 Banjarmasin, proyek kelompok menuntut pembagian tugas yang jelas antara pemrogram, pengelola database, dan perancang antarmuka (UI/UX Designer).' . "\n\n" . 'Sebagai UI/UX Designer dalam tim, tantangan utama saya adalah menerjemahkan ide-ide abstrak dari rekan kelompok menjadi cetak biru (wireframe) yang terstruktur di Figma. Komunikasi yang intensif dengan anggota tim memastikan bahwa setiap fitur yang dirancang dapat diimplementasikan dengan baik.' . "\n\n" . 'Pengalaman kolaborasi ini mengajarkan saya arti penting dari toleransi, kedisiplinan tenggat waktu, dan saling melengkapi keahlian demi mencapai tujuan proyek yang solutif dan berkualitas tinggi.',
                    'gambar' => null,
                    'penulis' => 'Nurhaina',
                    'tanggal' => '2026-11-14',
                    'published' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        // ============================================
        // KONTEN WEBSITE (BISA DIUBAH DARI ADMIN)
        // ============================================
        $settings = [
            ['name' => 'site_title', 'label' => 'Judul Website', 'value' => 'Portofolio | Nurhaina', 'type' => 'text'],
            ['name' => 'hero_greeting', 'label' => 'Sapaan di Beranda', 'value' => 'Hallo, Saya', 'type' => 'text'],
            ['name' => 'hero_subtitle', 'label' => 'Subjudul Beranda', 'value' => 'Siswi SMK Negeri 2 Banjarmasin', 'type' => 'text'],
            ['name' => 'hero_description', 'label' => 'Deskripsi Singkat / Personal Branding', 'value' => 'Berfokus khusus pada perancangan UI/UX Design dan antarmuka aplikasi digital yang solutif serta estetis.', 'type' => 'textarea'],
            ['name' => 'about_intro', 'label' => 'Paragraf Tentang Saya', 'value' => 'Saya adalah siswi kelas PPLG di SMK Negeri 2 Banjarmasin. Berfokus mendalami bidang UI/UX Design, berpengalaman Praktik Latihan Kerja (PLK) di instansi pemerintahan, serta terbiasa berkolaborasi dalam tim untuk merancang sistem aplikasi.', 'type' => 'textarea'],
            ['name' => 'cv_note', 'label' => 'Catatan CV Digital', 'value' => 'Berikut CV digital saya. Kamu dapat melihatnya langsung atau mengunduhnya dalam format PDF.', 'type' => 'textarea'],
            ['name' => 'contact_note', 'label' => 'Catatan di Bagian Kontak', 'value' => 'Hubungi saya secara langsung melalui platform di bawah ini:', 'type' => 'text'],
            ['name' => 'footer_text', 'label' => 'Teks Footer', 'value' => '© 2026 Nurhaina Portfolio. All Rights Reserved.', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['name' => $setting['name']],
                $setting + ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    public function down(): void
    {
        // Konten default tidak dihapus otomatis agar perubahan pengguna tidak hilang.
    }
};
