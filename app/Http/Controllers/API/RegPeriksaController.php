<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegPeriksa;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class RegPeriksaController extends Controller
{
    /**
     * Get all registrasi periksa with filters
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = RegPeriksa::with(['patient', 'doctor', 'poli']);

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->byStatus($request->status);
            }

            // Filter berdasarkan status daftar
            if ($request->filled('status_daftar')) {
                $query->byStatusDaftar($request->status_daftar);
            }

            // Filter berdasarkan status lanjut
            if ($request->filled('status_lanjut')) {
                $query->byStatusLanjut($request->status_lanjut);
            }

            // Filter berdasarkan dokter
            if ($request->filled('dokter')) {
                $query->byDokter($request->dokter);
            }

            // Filter berdasarkan poli
            if ($request->filled('poli')) {
                $query->byPoli($request->poli);
            }

            // Filter berdasarkan status bayar
            if ($request->filled('status_bayar')) {
                $query->byStatusBayar($request->status_bayar);
            }

            // Filter berdasarkan tanggal
            if ($request->filled('tanggal')) {
                $query->byTanggalRegistrasi($request->tanggal);
            }

            // Filter berdasarkan range tanggal
            if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                $query->byRangeTanggal($request->tanggal_awal, $request->tanggal_akhir);
            }

            // Search berdasarkan nama pasien atau no rawat
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('no_rawat', 'like', "%{$search}%")
                        ->orWhere('no_reg', 'like', "%{$search}%")
                        ->orWhereHas('patient', function ($patientQuery) use ($search) {
                            $patientQuery->where('nama', 'like', "%{$search}%");
                        });
                });
            }

            $perPage = $request->get('per_page', 15);
            $regPeriksas = $query->orderBy('tgl_registrasi', 'desc')
                ->orderBy('jam_reg', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $regPeriksas,
                'message' => 'Data registrasi periksa berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data registrasi periksa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new registrasi periksa
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'no_reg' => 'required|string|max:8|unique:reg_periksa,no_reg',
                'no_rawat' => 'required|string|max:17|unique:reg_periksa,no_rawat',
                'tgl_registrasi' => 'required|date',
                'jam_reg' => 'required|date_format:H:i',
                'kd_dokter' => 'required|string|exists:dokter,kd_dokter',
                'no_rkm_medis' => 'required|string|exists:patients,no_rkm_medis',
                'kd_poli' => 'required|string|exists:poliklinik,kd_poli',
                'p_jawab' => 'required|string|max:100',
                'almt_pj' => 'required|string|max:200',
                'hubunganpj' => 'required|string|max:20',
                'biaya_reg' => 'required|numeric|min:0',
                'stts' => 'required|in:Belum,Sudah,Batal,Berkas Diterima,Dirujuk,Meninggal,Dirawat,Pulang Paksa',
                'stts_daftar' => 'required|in:-,Lama,Baru',
                'status_lanjut' => 'required|in:Ralan,Ranap',
                'kd_pj' => 'required|string|max:3',
                'status_bayar' => 'required|in:Sudah Bayar,Belum Bayar',
                'status_poli' => 'required|in:Lama,Baru',
            ]);

            // Hitung umur otomatis
            $patient = Patient::find($request->no_rkm_medis);
            $regPeriksa = new RegPeriksa($request->all());

            if ($patient && $patient->tanggal_lahir) {
                $umurData = $regPeriksa->hitungUmur($patient->tanggal_lahir, $request->tgl_registrasi);
                if ($umurData) {
                    $regPeriksa->umurdaftar = $umurData['umur'];
                    $regPeriksa->sttsumur = $umurData['satuan'];
                }
            }

            $regPeriksa->save();
            $regPeriksa->load(['patient', 'doctor', 'poli']);

            return response()->json([
                'success' => true,
                'data' => $regPeriksa,
                'message' => 'Registrasi periksa berhasil dibuat'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat registrasi periksa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific registrasi periksa
     */
    public function show(RegPeriksa $regPeriksa): JsonResponse
    {
        try {
            $regPeriksa->load(['patient', 'doctor', 'poli']);

            return response()->json([
                'success' => true,
                'data' => $regPeriksa,
                'message' => 'Data registrasi periksa berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data registrasi periksa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update registrasi periksa
     */
    public function update(Request $request, RegPeriksa $regPeriksa): JsonResponse
    {
        try {
            $request->validate([
                'no_reg' => 'required|string|max:8|unique:reg_periksa,no_reg,' . $regPeriksa->no_reg . ',no_reg',
                'no_rawat' => 'required|string|max:17|unique:reg_periksa,no_rawat,' . $regPeriksa->no_rawat . ',no_rawat',
                'tgl_registrasi' => 'required|date',
                'jam_reg' => 'required|date_format:H:i',
                'kd_dokter' => 'required|string|exists:dokter,kd_dokter',
                'no_rkm_medis' => 'required|string|exists:patients,no_rkm_medis',
                'kd_poli' => 'required|string|exists:poliklinik,kd_poli',
                'p_jawab' => 'required|string|max:100',
                'almt_pj' => 'required|string|max:200',
                'hubunganpj' => 'required|string|max:20',
                'biaya_reg' => 'required|numeric|min:0',
                'stts' => 'required|in:Belum,Sudah,Batal,Berkas Diterima,Dirujuk,Meninggal,Dirawat,Pulang Paksa',
                'stts_daftar' => 'required|in:-,Lama,Baru',
                'status_lanjut' => 'required|in:Ralan,Ranap',
                'kd_pj' => 'required|string|max:3',
                'status_bayar' => 'required|in:Sudah Bayar,Belum Bayar',
                'status_poli' => 'required|in:Lama,Baru',
            ]);

            // Hitung umur otomatis jika data pasien berubah
            if (
                $regPeriksa->no_rkm_medis !== $request->no_rkm_medis ||
                $regPeriksa->tgl_registrasi !== $request->tgl_registrasi
            ) {

                $patient = Patient::find($request->no_rkm_medis);
                if ($patient && $patient->tanggal_lahir) {
                    $umurData = $regPeriksa->hitungUmur($patient->tanggal_lahir, $request->tgl_registrasi);
                    if ($umurData) {
                        $request->merge([
                            'umurdaftar' => $umurData['umur'],
                            'sttsumur' => $umurData['satuan']
                        ]);
                    }
                }
            }

            $regPeriksa->update($request->all());
            $regPeriksa->load(['patient', 'doctor', 'poli']);

            return response()->json([
                'success' => true,
                'data' => $regPeriksa,
                'message' => 'Registrasi periksa berhasil diperbarui'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui registrasi periksa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete registrasi periksa
     */
    public function destroy(RegPeriksa $regPeriksa): JsonResponse
    {
        try {
            $regPeriksa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi periksa berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus registrasi periksa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hitung umur untuk pasien tertentu
     */
    public function hitungUmur(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'no_rkm_medis' => 'required|string|exists:patients,no_rkm_medis',
                'tanggal_registrasi' => 'required|date',
            ]);

            $patient = Patient::find($request->no_rkm_medis);
            $regPeriksa = new RegPeriksa();

            $umurData = $regPeriksa->hitungUmur($patient->tanggal_lahir, $request->tanggal_registrasi);

            return response()->json([
                'success' => true,
                'data' => $umurData,
                'message' => 'Umur berhasil dihitung'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung umur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistik registrasi periksa
     */
    public function getStatistik(Request $request): JsonResponse
    {
        try {
            $tanggalAwal = $request->get('tanggal_awal', Carbon::now()->startOfMonth());
            $tanggalAkhir = $request->get('tanggal_akhir', Carbon::now()->endOfMonth());

            $query = RegPeriksa::byRangeTanggal($tanggalAwal, $tanggalAkhir);

            $statistik = [
                'total_registrasi' => $query->count(),
                'pasien_baru' => $query->byStatusDaftar('Baru')->count(),
                'pasien_lama' => $query->byStatusDaftar('Lama')->count(),
                'rawat_jalan' => $query->byStatusLanjut('Ralan')->count(),
                'rawat_inap' => $query->byStatusLanjut('Ranap')->count(),
                'sudah_bayar' => $query->byStatusBayar('Sudah Bayar')->count(),
                'belum_bayar' => $query->byStatusBayar('Belum Bayar')->count(),
                'sudah_diperiksa' => $query->byStatus('Sudah')->count(),
                'belum_diperiksa' => $query->byStatus('Belum')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $statistik,
                'message' => 'Statistik berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data untuk dropdown/filter
     */
    public function getFilterData(): JsonResponse
    {
        try {
            $doctors = Doctor::where('status', 'Aktif')->get(['kd_dokter', 'nm_dokter']);
            $polis = Poli::where('status', 'Aktif')->get(['kd_poli', 'nm_poli']);
            $patients = Patient::orderBy('nama')->get(['no_rkm_medis', 'nama']);

            return response()->json([
                'success' => true,
                'data' => [
                    'doctors' => $doctors,
                    'polis' => $polis,
                    'patients' => $patients,
                ],
                'message' => 'Data filter berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data filter: ' . $e->getMessage()
            ], 500);
        }
    }
}
