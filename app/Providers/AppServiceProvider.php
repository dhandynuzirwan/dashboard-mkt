<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('autoLink', function ($text) {
            if (empty($text) || $text == 'Tidak Ada') return $text;

            // 1. Amankan teks dari tag HTML berbahaya (XSS Protection)
            $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

            // 2. Deteksi Email (Ubah jadi link mailto)
            $text = preg_replace(
                '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', 
                '<a href="https://mail.google.com/mail/?view=cm&fs=1&to=$1" class="text-primary fw-bold text-decoration-none" target="_blank" title="Kirim via Gmail"><i class="fas fa-envelope"></i> $1</a>', 
                $text
            );

            // 3. Deteksi Nomor Telepon / WA (Mendeteksi format 08xxx, 628xxx, +628xxx)
            $text = preg_replace_callback('/(\+?62|0)8[0-9]{7,12}/', function($matches) {
                $original = $matches[0];
                
                // Bersihkan angka dari simbol (hanya ambil angkanya saja)
                $wa_number = preg_replace('/[^0-9]/', '', $original);
                
                // Jika depannya 0, ganti jadi 62 untuk format API WhatsApp
                if (str_starts_with($wa_number, '0')) {
                    $wa_number = '62' . substr($wa_number, 1);
                }
                
                // Return berupa link API wa.me
                return '<a href="https://wa.me/' . $wa_number . '" class="text-success fw-bold text-decoration-none" target="_blank" title="Chat WA"><i class="fab fa-whatsapp"></i> ' . $original . '</a>';
            }, $text);

            return $text;
        });
    }
}
