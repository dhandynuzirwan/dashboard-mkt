<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto_profil',
        'kontrak_kerja',
        'nama_lengkap', // 🔥 TAMBAHAN BARU
        'nama_lengkap_ktp',
        'jobdesk_file',
        'sop_file',
        'no_hp',        // 🔥 TAMBAHAN BARU
        'nik',
        'tanggal_lahir',
        'tanggal_bergabung',
        'ktp_file',
        'ijasah_file',
        'pas_foto_file',
        'kk_file',
        'tanggal_kontrak_baru',
        'tanggal_kontrak_berakhir',
        'deal_sound_path',
        'pakta_integritas_file',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function penggajian()
    {
        return $this->hasOne(Penggajian::class);
    }
    
    // Relasi: 1 User bisa melakukan banyak Mutasi Barang
    public function itemLogs()
    {
        return $this->hasMany(ItemLog::class, 'user_id');
    }
}
