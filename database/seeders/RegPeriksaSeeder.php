<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegPeriksa;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Poli;
use Carbon\Carbon;

class RegPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat data dokter contoh
        $dokter1 = Doctor::firstOrCreate(
            ['kd_dokter' => 'D001'],
            [
                'nm_dokter' => 'Dr. Ahmad Wijaya',
                'jk' => 'L',
                'tmp_lahir' => 'Jakarta',
                'tgl_lahir' => '1980-05-15',
                'gol_drh' => 'O',
                'agama' => 'Islam',
                'almt_tgl' => 'Jl. Sudirman No. 123',
                'no_telp' => '081234567890',
                'stts_nikah' => 'Menikah',
                'kd_sps' => 'SP001',
                'alumni' => 'Universitas Indonesia',
                'no_ijn_praktek' => 'IJN001',
                'status' => 'Aktif',
            ]
        );

        $dokter2 = Doctor::firstOrCreate(
            ['kd_dokter' => 'D002'],
            [
                'nm_dokter' => 'Dr. Siti Nurhaliza',
                'jk' => 'P',
                'tmp_lahir' => 'Bandung',
                'tgl_lahir' => '1985-08-20',
                'gol_drh' => 'A',
                'agama' => 'Islam',
                'almt_tgl' => 'Jl. Diponegoro No. 456',
                'no_telp' => '081234567891',
                'stts_nikah' => 'Menikah',
                'kd_sps' => 'SP002',
                'alumni' => 'Universitas Padjadjaran',
                'no_ijn_praktek' => 'IJN002',
                'status' => 'Aktif',
            ]
        );

        // Buat data poli contoh
        $poli1 = Poli::firstOrCreate(
            ['kd_poli' => 'P001'],
            [
                'nm_poli' => 'Poli Umum',
                'lantai' => '1',
                'status' => 'Aktif',
            ]
        );

        $poli2 = Poli::firstOrCreate(
            ['kd_poli' => 'P002'],
            [
                'nm_poli' => 'Poli Anak',
                'lantai' => '2',
                'status' => 'Aktif',
            ]
        );

        $poli3 = Poli::firstOrCreate(
            ['kd_poli' => 'P003'],
            [
                'nm_poli' => 'Poli Kandungan',
                'lantai' => '2',
                'status' => 'Aktif',
            ]
        );

        // Buat data pasien contoh jika belum ada
        $pasien1 = Patient::firstOrCreate(
            ['no_rkm_medis' => 'P001'],
            [
                'no_ktp' => '1234567890123456',
                'nama' => 'John Doe',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-15',
                'alamat' => 'Jl. Merdeka No. 123',
                'no_telepon' => '081234567890',
                'agama' => 'Islam',
                'status_perkawinan' => 'Belum Menikah',
                'pekerjaan' => 'Karyawan',
            ]
        );

        $pasien2 = Patient::firstOrCreate(
            ['no_rkm_medis' => 'P002'],
            [
                'no_ktp' => '1234567890123457',
                'nama' => 'Jane Smith',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-03-20',
                'alamat' => 'Jl. Asia Afrika No. 456',
                'no_telepon' => '081234567891',
                'agama' => 'Kristen',
                'status_perkawinan' => 'Menikah',
                'pekerjaan' => 'Ibu Rumah Tangga',
            ]
        );

        $pasien3 = Patient::firstOrCreate(
            ['no_rkm_medis' => 'P003'],
            [
                'no_ktp' => '1234567890123458',
                'nama' => 'Ahmad Rahman',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2020-06-10',
                'alamat' => 'Jl. Tunjungan No. 789',
                'no_telepon' => '081234567892',
                'agama' => 'Islam',
                'status_perkawinan' => 'Belum Menikah',
                'pekerjaan' => 'Pelajar',
            ]
        );

        // Buat data registrasi periksa contoh
        $regPeriksas = [
            [
                'no_reg' => 'REG001',
                'no_rawat' => 'RAWAT001',
                'tgl_registrasi' => Carbon::now()->subDays(1),
                'jam_reg' => '08:00:00',
                'kd_dokter' => 'D001',
                'no_rkm_medis' => 'P001',
                'kd_poli' => 'P001',
                'p_jawab' => 'John Doe',
                'almt_pj' => 'Jl. Merdeka No. 123',
                'hubunganpj' => 'Diri Sendiri',
                'biaya_reg' => 50000,
                'stts' => 'Sudah',
                'stts_daftar' => 'Baru',
                'status_lanjut' => 'Ralan',
                'kd_pj' => 'PJ1',
                'umurdaftar' => 34,
                'sttsumur' => 'Th',
                'status_bayar' => 'Sudah Bayar',
                'status_poli' => 'Baru',
            ],
            [
                'no_reg' => 'REG002',
                'no_rawat' => 'RAWAT002',
                'tgl_registrasi' => Carbon::now()->subDays(2),
                'jam_reg' => '09:30:00',
                'kd_dokter' => 'D002',
                'no_rkm_medis' => 'P002',
                'kd_poli' => 'P003',
                'p_jawab' => 'Jane Smith',
                'almt_pj' => 'Jl. Asia Afrika No. 456',
                'hubunganpj' => 'Diri Sendiri',
                'biaya_reg' => 75000,
                'stts' => 'Sudah',
                'stts_daftar' => 'Lama',
                'status_lanjut' => 'Ralan',
                'kd_pj' => 'PJ2',
                'umurdaftar' => 39,
                'sttsumur' => 'Th',
                'status_bayar' => 'Sudah Bayar',
                'status_poli' => 'Lama',
            ],
            [
                'no_reg' => 'REG003',
                'no_rawat' => 'RAWAT003',
                'tgl_registrasi' => Carbon::now(),
                'jam_reg' => '10:15:00',
                'kd_dokter' => 'D002',
                'no_rkm_medis' => 'P003',
                'kd_poli' => 'P002',
                'p_jawab' => 'Ahmad Rahman',
                'almt_pj' => 'Jl. Tunjungan No. 789',
                'hubunganpj' => 'Orang Tua',
                'biaya_reg' => 25000,
                'stts' => 'Belum',
                'stts_daftar' => 'Baru',
                'status_lanjut' => 'Ralan',
                'kd_pj' => 'PJ3',
                'umurdaftar' => 4,
                'sttsumur' => 'Th',
                'status_bayar' => 'Belum Bayar',
                'status_poli' => 'Baru',
            ],
        ];

        foreach ($regPeriksas as $regPeriksa) {
            RegPeriksa::firstOrCreate(
                ['no_reg' => $regPeriksa['no_reg']],
                $regPeriksa
            );
        }
    }
}
