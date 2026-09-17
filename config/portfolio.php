<?php

// Semua konten portofolio dikumpulkan di sini supaya gampang diedit tanpa
// menyentuh markup Blade. Ganti nilai di bawah kalau ada update.

return [

    'hero' => [
        'name' => 'Muhammad Wira Margono',
        'class' => 'Full-Stack Developer & IT Engineer',
        'title' => 'The Code Weaver',
        'level' => 23,
        'guild' => 'PT. Syifa Global Group',
        'tagline' => 'Merancang sistem informasi rumah sakit, otomasi, dan solusi berbasis AI — dari ide sampai production, dengan fokus pada efisiensi dan keandalan.',
        'avatar_initial' => 'W',
        'location' => 'Banjarbaru, Kalimantan Selatan, Indonesia',
        'status' => 'Terbuka untuk kolaborasi & peluang baru',
    ],

    'links' => [
        'linkedin' => 'https://www.linkedin.com/in/wiramarr/',
        'github' => 'https://github.com/browir',
        'instagram' => 'https://instagram.com/wiramarr',
        'email' => 'm.wiramar@gmail.com',
        'cv' => null, // isi dengan URL/path CV kalau ada, mis. '/cv/wira-marr-cv.pdf'
    ],

    'about' => [
        'lore' => "Lulusan Teknik Informatika dengan IPK nyaris sempurna (3.92/4.00) dan predikat Lulusan Terbaik. Menjelajah dari pengembangan web full-stack, AI/Machine Learning, hingga operasional bisnis dan kepemimpinan teknis. Baik itu membangun aplikasi rumah sakit, merancang Decision Support System, maupun mengelola logistik bisnis end-to-end — fokusnya selalu sama: efisiensi, keandalan, dan kepuasan pengguna. Pernah menjadi Batch Representative untuk 100+ mahasiswa dan Founder bisnis rental sendiri, sehingga terbiasa mengelola stakeholder sekaligus turun langsung mengerjakan detail teknis.",
        'facts' => [
            ['label' => 'Kelas', 'value' => 'Full-Stack Developer'],
            ['label' => 'Sub-Kelas', 'value' => 'AI/ML Enthusiast'],
            ['label' => 'Senjata Utama', 'value' => 'Laravel & Vue.js'],
            ['label' => 'Sihir Sekunder', 'value' => 'Python & Machine Learning'],
        ],
    ],

    // Skill = "Stats" ala character sheet. value dalam persen (0-100) untuk progress bar.
    'stats' => [
        ['name' => 'PHP / Laravel', 'value' => 90],
        ['name' => 'JavaScript / Vue.js', 'value' => 80],
        ['name' => 'Tailwind CSS / Bootstrap', 'value' => 85],
        ['name' => 'MySQL & Database Design', 'value' => 82],
        ['name' => 'Python & Machine Learning', 'value' => 68],
        ['name' => 'Networking (TCP/IP, Cisco)', 'value' => 65],
    ],

    // Pengalaman kerja = "Quest Log"
    'quests' => [
        [
            'title' => 'Staff IT R&D',
            'giver' => 'PT. Syifa Global Group',
            'period' => 'Mei 2026 — Sekarang',
            'difficulty' => 'S-Rank',
            'description' => 'Merancang dan membangun SiLapor, aplikasi ticketing IT dan manajemen inventori terintegrasi yang digunakan di RSU Syifa Medika Banjarbaru dan cabang Barabai. Mengembangkan Document Control Management System (DCMS) untuk mendigitalkan manajemen rapat dan dokumen SOP di kedua cabang rumah sakit. Membangun sistem chatbot otomatis dengan n8n untuk Aurora Executive Clinic guna mempercepat pendaftaran pasien. Menangani troubleshooting aplikasi internal, hardware, dan jaringan untuk menjaga uptime operasional.',
            'rewards' => ['Laravel', 'n8n Automation', 'IT Infrastructure Support'],
        ],
        [
            'title' => 'Staff IT Programmer',
            'giver' => 'PT. Syifa Global Group',
            'period' => 'Feb 2026 — Mei 2026',
            'difficulty' => 'A-Rank',
            'description' => 'Bertanggung jawab merancang, mengembangkan, dan memelihara ekosistem software internal rumah sakit, sekaligus memastikan infrastruktur IT (aplikasi, hardware, jaringan) berjalan optimal. Mengembangkan dan troubleshooting SIMGOS V2, sistem manajemen inti RSU Syifa Medika Banjarbaru.',
            'rewards' => ['Troubleshooting', 'Web Development', 'Hospital Systems'],
        ],
        [
            'title' => 'Freelance Web Developer',
            'giver' => 'Pekerja Lepas',
            'period' => 'Agu 2025 — Feb 2026',
            'difficulty' => 'A-Rank',
            'description' => 'Bertanggung jawab penuh mengembangkan website custom sesuai tujuan bisnis dan kebutuhan fungsional klien. Aktif melakukan debugging dan troubleshooting sistem kompleks untuk meningkatkan performa dan stabilitas website. Berpartisipasi dalam siklus SDLC penuh untuk memastikan pengiriman proyek tepat waktu dan sesuai standar industri.',
            'rewards' => ['PHP', 'Tailwind CSS', 'SDLC'],
        ],
        [
            'title' => 'Computer Science Teaching Assistant',
            'giver' => 'SMPN 1 Martapura',
            'period' => 'Jul 2024 — Des 2024',
            'difficulty' => 'B-Rank',
            'description' => 'Membantu proses belajar-mengajar untuk 90 siswa di 3 kelas berbeda. Memberikan bimbingan teknis soal dasar pemrograman, aplikasi office, dan literasi digital. Menangani troubleshooting software dan hardware dasar di laboratorium komputer. Merancang dan membangun aplikasi khusus untuk mendukung digitalisasi sekolah.',
            'rewards' => ['Mentoring', 'Digitalisasi Sekolah', 'IT Troubleshooting'],
        ],
        [
            'title' => 'Founder',
            'giver' => 'Wirarent',
            'period' => 'Mei 2023 — Des 2024',
            'difficulty' => 'B-Rank',
            'description' => 'Mengelola operasional harian bisnis rental kostum, termasuk kontrol inventori dan laporan keuangan bisnis. Membangun hubungan kuat dengan komunitas melalui pelayanan pelanggan yang baik. Menerapkan strategi manajemen aset untuk menjaga kualitas produk dan efisiensi biaya operasional.',
            'rewards' => ['Business Management', 'Customer Satisfaction', 'Financial Reporting'],
        ],
    ],

    // Project = "Achievements"
    'achievements' => [
        [
            'title' => 'SiLapor',
            'badge' => 'shield',
            'description' => 'Aplikasi ticketing IT dan manajemen inventori terintegrasi, dipakai di dua cabang rumah sakit untuk melacak infrastruktur dan mendukung workflow.',
            'stack' => ['Laravel', 'MySQL', 'Tailwind'],
            'link' => '#',
        ],
        [
            'title' => 'DCMS (Document Control Management System)',
            'badge' => 'scroll',
            'description' => 'Mendigitalkan manajemen rapat dan mensentralisasi workflow dokumen SOP, menstandarkan operasional di dua cabang rumah sakit.',
            'stack' => ['Laravel', 'MySQL'],
            'link' => '#',
        ],
        [
            'title' => 'Chatbot Aurora Executive Clinic',
            'badge' => 'gear-bot',
            'description' => 'Sistem chatbot otomatis berbasis n8n untuk mempercepat pendaftaran pasien dan menghasilkan ringkasan data registrasi otomatis.',
            'stack' => ['n8n', 'Automation'],
            'link' => '#',
        ],
        [
            'title' => 'SIMGOS V2',
            'badge' => 'pulse',
            'period' => 'Feb 2026 — Mei 2026',
            'description' => 'Sistem manajemen inti rumah sakit RSU Syifa Medika Banjarbaru, dikembangkan dan terus disempurnakan untuk workflow klinis & administratif.',
            'stack' => ['Web Development', 'Troubleshooting'],
            'link' => '#',
        ],
        [
            'title' => 'SIMRS Version 2',
            'badge' => 'pulse',
            'period' => 'Jan 2026 — Feb 2026',
            'description' => 'Platform sistem informasi manajemen rumah sakit terinspirasi dari SIMRS yang dipakai di Indonesia, dibangun dengan Laravel dan Vue.js.',
            'stack' => ['Laravel', 'Vue.js'],
            'link' => '#',
        ],
        [
            'title' => 'Financial Analytics & Profit Sharing Dashboard',
            'badge' => 'chart',
            'period' => 'Des 2025 — Jan 2026',
            'description' => 'Dashboard finansial berbasis web untuk pencatatan pendapatan, distribusi profit, data shareholder, dan peramalan pendapatan bulanan memakai metode regresi linear.',
            'stack' => ['Laravel', 'Machine Learning'],
            'link' => '#',
        ],
        [
            'title' => 'SIMRS',
            'badge' => 'pulse',
            'period' => 'Des 2025',
            'description' => 'Platform manajemen rumah sakit terintegrasi untuk mendigitalkan alur pendaftaran dan informasi layanan, meningkatkan efisiensi operasional.',
            'stack' => ['Laravel', 'Tailwind CSS'],
            'link' => '#',
        ],
        [
            'title' => 'Decision Support System — Pemilihan Printer',
            'badge' => 'printer',
            'period' => 'Agu 2025 — Nov 2025',
            'description' => 'Menggunakan metode Simple Additive Weighting (SAW) untuk menentukan printer yang paling sesuai kebutuhan toko atau pemilik bisnis.',
            'stack' => ['PHP', 'SAW Method'],
            'link' => '#',
        ],
        [
            'title' => 'Decision Support System — Pemilihan Kambing Berkualitas',
            'badge' => 'paw',
            'period' => 'Sep 2025 — Nov 2025',
            'description' => 'Implementasi metode SMART sebagai panduan memilih kambing berkualitas tinggi, baik untuk penjualan maupun ternak/pembibitan.',
            'stack' => ['PHP', 'SMART Method'],
            'link' => '#',
        ],
        [
            'title' => 'Decision Support System — Pemilihan Kader Terbaik',
            'badge' => 'medal',
            'period' => 'Agu 2025 — Okt 2025',
            'description' => 'Menggunakan metode Simple Additive Weighting (SAW) untuk menentukan kader terbaik secara objektif.',
            'stack' => ['PHP', 'SAW Method'],
            'link' => '#',
        ],
        [
            'title' => 'Decision Support System — Pemilihan Ketua Kelas',
            'badge' => 'ballot',
            'period' => 'Sep 2024 — Des 2024',
            'description' => 'Menggunakan metode SAW dan Multi-Attribute Utility Theory (MAUT) untuk menentukan ketua kelas secara objektif di SMPN 1 Martapura.',
            'stack' => ['PHP', 'SAW & MAUT'],
            'link' => '#',
        ],
        [
            'title' => 'Portofolio Ini',
            'badge' => 'castle',
            'period' => null,
            'description' => 'Website portofolio bertema RPG fantasy ini sendiri — dibangun dengan Laravel + Tailwind, di-deploy ke Vercel.',
            'stack' => ['Laravel', 'Tailwind v4', 'Vite'],
            'link' => '#',
        ],
    ],

    // Pendidikan & sertifikasi = "Guild Hall"
    'education' => [
        [
            'title' => 'S1 Ilmu Komputer, Teknik Informatika',
            'place' => 'STMIK Banjarbaru',
            'period' => 'Sep 2021 — Agu 2025',
            'honors' => ['IPK 3.92 / 4.00', 'Best Graduate', 'Batch Representative', 'Head Of Class'],
        ],
    ],

    'certifications' => [
        ['name' => 'SmallTalk English Speaking Level Test', 'issuer' => 'SmallTalk2Me', 'year' => 'Feb 2026'],
        ['name' => 'C# (Basic)', 'issuer' => 'HackerRank', 'year' => 'Feb 2026'],
        ['name' => 'Python (Basic)', 'issuer' => 'HackerRank', 'year' => 'Feb 2026'],
        ['name' => 'JavaScript (Basic)', 'issuer' => 'HackerRank', 'year' => 'Feb 2026'],
        ['name' => 'CSS (Basic)', 'issuer' => 'HackerRank', 'year' => 'Feb 2026'],
        ['name' => 'Problem Solving (Basic)', 'issuer' => 'HackerRank', 'year' => 'Feb 2026'],
        ['name' => 'Narasumber Penelitian Mahasiswa', 'issuer' => 'STMIK Banjarbaru', 'year' => 'Jul 2025'],
        ['name' => 'Seminar Literasi Digital', 'issuer' => 'Kementerian Komunikasi dan Informatika RI', 'year' => 'Mei 2024'],
        ['name' => 'Microsoft Certified: Applied Microsoft Office', 'issuer' => 'Microsoft Partner', 'year' => 'Jul 2024'],
        ['name' => 'Junior Graphic Designer', 'issuer' => 'Badan Nasional Sertifikasi Profesi (BNSP)', 'year' => 'Mar 2024'],
    ],

];
