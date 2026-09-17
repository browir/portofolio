<?php

// Semua konten portofolio dikumpulkan di sini supaya gampang diedit tanpa
// menyentuh markup Blade. Ganti nilai placeholder di bawah dengan data aslimu.

return [

    'hero' => [
        'name' => 'Wira Marr',
        'class' => 'Full-Stack Developer',
        'title' => 'The Code Weaver',
        'level' => 24,
        'guild' => 'Freelance Adventurers Guild',
        'tagline' => 'Menempa aplikasi web dari reruntuhan bug dan tenggat waktu yang mustahil.',
        'avatar_initial' => 'W',
        'location' => 'Indonesia',
        'status' => 'Open to new quests (kerja/kolaborasi)',
    ],

    'links' => [
        'linkedin' => 'https://www.linkedin.com/in/wiramarr/',
        'github' => 'https://github.com/',
        'email' => 'you@example.com',
        'cv' => null, // isi dengan URL/path CV kalau ada, mis. '/cv/wira-marr-cv.pdf'
    ],

    'about' => [
        'lore' => "Dimulai dari rasa penasaran mengutak-atik halaman HTML sederhana, kini telah menempuh puluhan “dungeon” proyek — dari sistem internal perusahaan sampai aplikasi publik. Percaya bahwa kode yang baik itu seperti mantra yang rapi: jelas, teruji, dan tidak meledak saat dipanggil ulang di production.",
        'facts' => [
            ['label' => 'Kelas', 'value' => 'Backend / Full-Stack'],
            ['label' => 'Ras', 'value' => 'Problem Solver'],
            ['label' => 'Senjata Utama', 'value' => 'Laravel & PHP'],
            ['label' => 'Sihir Sekunder', 'value' => 'JavaScript & Tailwind'],
        ],
    ],

    // Skill = "Stats" ala character sheet. value dalam persen (0-100) untuk progress bar.
    'stats' => [
        ['name' => 'PHP / Laravel', 'value' => 90],
        ['name' => 'JavaScript', 'value' => 78],
        ['name' => 'Tailwind CSS', 'value' => 85],
        ['name' => 'MySQL / Database Design', 'value' => 80],
        ['name' => 'REST API', 'value' => 82],
        ['name' => 'Git & Deployment', 'value' => 75],
    ],

    // Pengalaman kerja = "Quest Log"
    'quests' => [
        [
            'title' => 'Senior Web Developer',
            'giver' => 'PT Contoh Teknologi',
            'period' => '2023 — Sekarang',
            'difficulty' => 'S-Rank',
            'description' => 'Memimpin pengembangan platform internal, refactor arsitektur legacy jadi modular, dan mentoring developer junior.',
            'rewards' => ['+15 Leadership', '+10 System Design', 'Achievement: Zero-Downtime Deploy'],
        ],
        [
            'title' => 'Web Developer',
            'giver' => 'PT Contoh Digital',
            'period' => '2021 — 2023',
            'difficulty' => 'A-Rank',
            'description' => 'Membangun dan memelihara beberapa aplikasi Laravel untuk klien, termasuk integrasi payment gateway dan API pihak ketiga.',
            'rewards' => ['+12 Laravel Mastery', '+8 API Integration'],
        ],
        [
            'title' => 'Junior Web Developer',
            'giver' => 'Studio Kreatif Contoh',
            'period' => '2020 — 2021',
            'difficulty' => 'B-Rank',
            'description' => 'Mengerjakan landing page dan company profile untuk berbagai klien menggunakan PHP native dan jQuery.',
            'rewards' => ['+10 Frontend Basics', 'Achievement: First Deploy'],
        ],
    ],

    // Project = "Achievements"
    'achievements' => [
        [
            'title' => 'Sistem Manajemen Inventori',
            'badge' => '🛡️',
            'description' => 'Aplikasi manajemen stok berbasis Laravel dengan laporan real-time dan multi-gudang.',
            'stack' => ['Laravel', 'MySQL', 'Tailwind', 'Alpine.js'],
            'link' => '#',
        ],
        [
            'title' => 'Platform Booking Online',
            'badge' => '⚔️',
            'description' => 'Sistem reservasi dengan kalender interaktif, notifikasi email, dan pembayaran online.',
            'stack' => ['Laravel', 'Livewire', 'MidtransAPI'],
            'link' => '#',
        ],
        [
            'title' => 'Dashboard Analitik',
            'badge' => '📜',
            'description' => 'Dashboard visualisasi data penjualan dengan grafik interaktif dan export laporan.',
            'stack' => ['Laravel', 'Chart.js', 'REST API'],
            'link' => '#',
        ],
        [
            'title' => 'Portofolio Ini',
            'badge' => '🏰',
            'description' => 'Website portofolio bertema RPG fantasy ini sendiri — dibangun dengan Laravel + Tailwind, di-deploy ke Vercel.',
            'stack' => ['Laravel', 'Tailwind v4', 'Vite'],
            'link' => '#',
        ],
    ],

    // Pendidikan & sertifikasi = "Guild Hall"
    'education' => [
        [
            'title' => 'S1 Teknik Informatika',
            'place' => 'Universitas Contoh',
            'period' => '2016 — 2020',
        ],
    ],

    'certifications' => [
        ['name' => 'Laravel Certified Developer', 'issuer' => 'Contoh Institute', 'year' => '2023'],
        ['name' => 'Certified JavaScript Developer', 'issuer' => 'Contoh Academy', 'year' => '2022'],
    ],

];
