import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/Layouts/AppLayout';

export default function Show({ patient }) {
    return (
        <AppLayout>
            <Head title={`Detail Pasien - ${patient.nm_pasien}`} />

            <div className="py-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div className="p-6">
                            <div className="flex justify-between items-center">
                                <div>
                                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                                        Detail Pasien
                                    </h2>
                                    <p className="text-gray-600 dark:text-gray-400 mt-1">
                                        {patient.nm_pasien} - {patient.no_rkm_medis}
                                    </p>
                                </div>
                                <div className="flex gap-2">
                                    <Link
                                        href={route('patients.index')}
                                        className="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                                            <path fillRule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06L10.94 8.25H3a.75.75 0 010-1.5h7.94L7.72 3.53a.75.75 0 011.06-1.06l4.5 4.5a.75.75 0 010 1.06l-4.5 4.5a.75.75 0 01-1.06 0z" clipRule="evenodd" />
                                        </svg>
                                        Kembali
                                    </Link>
                                    <Link
                                        href={route('patients.edit', patient.no_rkm_medis)}
                                        className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                            <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                                        </svg>
                                        Edit
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Patient Information */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {/* Basic Information */}
                        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    Informasi Dasar
                                </h3>
                                <div className="space-y-4">
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Nomor RM
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.no_rkm_medis}
                                            </p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                NIK
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.no_ktp || '-'}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Nama Lengkap
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.nm_pasien}
                                        </p>
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Jenis Kelamin
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.jk === 'L' ? 'Laki-laki' : 'Perempuan'}
                                            </p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Umur
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.umur}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Tempat Lahir
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.tmp_lahir}
                                            </p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Tanggal Lahir
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.tgl_lahir ? new Date(patient.tgl_lahir).toLocaleDateString('id-ID') : '-'}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Nama Ibu
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.nm_ibu}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Contact Information */}
                        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    Informasi Kontak
                                </h3>
                                <div className="space-y-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Alamat
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.alamat}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            No. Telepon
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.no_tlp || '-'}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Email
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.email || '-'}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Tanggal Daftar
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.tgl_daftar ? new Date(patient.tgl_daftar).toLocaleDateString('id-ID') : '-'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Additional Information */}
                        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    Informasi Tambahan
                                </h3>
                                <div className="space-y-4">
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Golongan Darah
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.gol_darah || '-'}
                                            </p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Status Perkawinan
                                            </label>
                                            <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                                {patient.stts_nikah || '-'}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Agama
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.agama || '-'}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Pekerjaan
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.pekerjaan || '-'}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Pendidikan
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.pnd || '-'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Family Information */}
                        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    Informasi Keluarga
                                </h3>
                                <div className="space-y-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Hubungan Keluarga
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.keluarga || '-'}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Nama Keluarga
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.namakeluarga}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Pekerjaan Keluarga
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.pekerjaanpj}
                                        </p>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Alamat Keluarga
                                        </label>
                                        <p className="mt-1 text-sm text-gray-900 dark:text-white">
                                            {patient.alamatpj}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
