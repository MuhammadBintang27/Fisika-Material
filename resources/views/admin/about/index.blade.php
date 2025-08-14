@extends('admin.layouts.app')

@section('title', 'Profil Laboratorium')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Profil Laboratorium</h1>
                <p class="text-blue-100 text-lg">Kelola informasi dan identitas laboratorium</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.about.edit') }}" 
                   class="px-6 py-3 bg-white/90 backdrop-blur-sm text-blue-700 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-white transition-all duration-300 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
        @if($profil)
                <!-- Laboratory Name -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-building text-blue-500 mr-3"></i>
                        Nama Laboratorium
                    </h2>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <p class="text-gray-700 font-medium text-lg">{{ $profil->namaLaboratorium }}</p>
                    </div>
                </div>

                <!-- About Laboratory -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-green-500 mr-3"></i>
                        Tentang Laboratorium
                    </h2>
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                        <p class="text-gray-700 leading-relaxed">{{ $profil->tentangLaboratorium }}</p>
                    </div>
                </div>

                <!-- Vision -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-eye text-purple-500 mr-3"></i>
                        Visi
                    </h2>
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <p class="text-gray-700 leading-relaxed">{{ $profil->visi }}</p>
                    </div>
                </div>

                <!-- Mission -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-list text-orange-500 mr-3"></i>
                        Misi
                    </h2>
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">
                        @if($misis->count() > 0)
                            <ol class="list-decimal list-inside space-y-3">
                                @foreach($misis as $misi)
                                    <li class="text-gray-700 text-lg">{{ $misi->pointMisi }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-gray-500 italic">Belum ada misi yang ditambahkan</p>
                        @endif
                    </div>
                </div>

                <!-- Preview Link -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-globe text-emerald-500 mr-2"></i>
                                    Preview Website
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Lihat bagaimana profil ini ditampilkan di website publik</p>
                            </div>
                            <a href="{{ route('home') }}#visi-misi" 
                               target="_blank"
                               class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-emerald-700 transition-all duration-300 flex items-center">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Lihat di Website
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-info-circle text-blue-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Profil Belum Dibuat</h3>
                    <p class="text-gray-500 mb-8 max-w-lg mx-auto text-lg">Buat profil laboratorium pertama Anda untuk menampilkan informasi di website publik</p>
                    <a href="{{ route('admin.about.edit') }}" 
                       class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold shadow-xl hover:shadow-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 inline-flex items-center text-lg">
                        <i class="fas fa-plus mr-3"></i>
                        Buat Profil Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    @if($profil)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-r from-purple-100 to-purple-200 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Visi Laboratorium</p>
                        <p class="text-2xl font-bold text-gray-900">1</p>
                        <p class="text-xs text-gray-500">Item tersedia</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-r from-orange-100 to-orange-200 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-list text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Misi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $misis->count() }}</p>
                        <p class="text-xs text-gray-500">Poin misi</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-r from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-emerald-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Terakhir Update</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $profil->updated_at->format('d M') }}</p>
                        <p class="text-xs text-gray-500">{{ $profil->updated_at->format('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 
 