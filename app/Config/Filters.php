<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>>
     *
     * [filter_name => classname]
     * or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'role'          => \App\Filters\RoleFilter::class,
    ];

    /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'POST' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [
        'role:Admin,User,spmb,konten,Guru' => ['before' => ['admin/dasbor', 'admin/dasbor/*']],
        'role:Admin,User,spmb' => ['before' => [
            'admin/gelombang', 'admin/gelombang/*',
            'admin/jenis_dokumen', 'admin/jenis_dokumen/*',
            'admin/akun_pendaftar', 'admin/akun_pendaftar/*',
            'admin/konfigurasi/pendaftaran',
            'admin/konfigurasi/pembayaran',
            'admin/agama', 'admin/agama/*',
            'admin/hubungan', 'admin/hubungan/*',
            'admin/jenjang', 'admin/jenjang/*',
            'admin/pekerjaan', 'admin/pekerjaan/*'
        ]],
        'role:Admin,User,konten' => ['before' => [
            'admin/berita', 'admin/berita/*',
            'admin/kategori', 'admin/kategori/*',
            'admin/galeri', 'admin/galeri/*',
            'admin/kategori_galeri', 'admin/kategori_galeri/*',
            'admin/video', 'admin/video/*',
            'admin/agenda', 'admin/agenda/*',
            'admin/kategori_agenda', 'admin/kategori_agenda/*',
            'admin/fasilitas', 'admin/fasilitas/*',
            'admin/kategori_fasilitas', 'admin/kategori_fasilitas/*',
            'admin/ekstrakurikuler', 'admin/ekstrakurikuler/*',
            'admin/kategori_ekstrakurikuler', 'admin/kategori_ekstrakurikuler/*',
            'admin/download', 'admin/download/*',
            'admin/kategori_download', 'admin/kategori_download/*',
            'admin/portfolio', 'admin/portfolio/*',
            'admin/kategori_portfolio', 'admin/kategori_portfolio/*',
            'admin/prestasi', 'admin/prestasi/*',
            'admin/kategori_prestasi', 'admin/kategori_prestasi/*',
            'admin/client', 'admin/client/*',
            'admin/kategori_client', 'admin/kategori_client/*'
        ]],
        'role:Admin,User' => ['before' => [
            'admin/user', 'admin/user/*',
            'admin/staff', 'admin/staff/*',
            'admin/kategori_staff', 'admin/kategori_staff/*',
            'admin/siswa', 'admin/siswa/*',
            'admin/rombel', 'admin/rombel/*',
            'admin/menu', 'admin/menu/*',
            'admin/link_website', 'admin/link_website/*',
            'admin/akun', 'admin/akun/*',
            'admin/kelas', 'admin/kelas/*',
            'admin/program_pendidikan', 'admin/program_pendidikan/*',
            'admin/tahun', 'admin/tahun/*',
            'admin/konfigurasi', 'admin/konfigurasi/index', 'admin/konfigurasi/email', 'admin/konfigurasi/sekolah',
            'admin/konfigurasi/banner', 'admin/konfigurasi/unduh', 'admin/konfigurasi/seo', 'admin/konfigurasi/logo',
            'admin/konfigurasi/login', 'admin/konfigurasi/icon'
        ]]
    ];
}
