@extends('admin.layouts.app')

@section('title', 'Profil Laboratorium')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profil Laboratorium</h1>
            <p class="text-gray-600">Kelola informasi profil laboratorium</p>
        </div>
        <a href="{{ route('admin.about.edit') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Profil
        </a>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            @if($profil)
                <!-- Laboratory Name -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Nama Laboratorium</h2>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border-l-4 border-blue-500">
                        <p class="text-gray-700 font-medium">{{ $profil->namaLaboratorium }}</p>
                    </div>
                </div>

                <!-- About Laboratory -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Tentang Laboratorium</h2>
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $profil->tentangLaboratorium }}</p>
                    </div>
                </div>

                <!-- Vision -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Visi</h2>
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4 border-l-4 border-blue-500">
                        <p class="text-gray-700 leading-relaxed">{{ $profil->visi }}</p>
                    </div>
                </div>

                <!-- Mission -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Misi</h2>
                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 border-l-4 border-green-500">
                        @if($misis->count() > 0)
                            <ol class="list-decimal list-inside space-y-2">
                                @foreach($misis as $misi)
                                    <li class="text-gray-700">{{ $misi->pointMisi }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-gray-500 italic">Belum ada misi yang ditambahkan</p>
                        @endif
                    </div>
                </div>

                <!-- Preview Link -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Preview Website</h3>
                            <p class="text-sm text-gray-500">Lihat bagaimana profil ini ditampilkan di website</p>
                        </div>
                        <a href="{{ route('home') }}#visi-misi" 
                           target="_blank"
                           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Lihat di Website
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-info-circle text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Profil belum dibuat</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Buat profil laboratorium pertama Anda untuk menampilkan informasi di website</p>
                    <a href="{{ route('admin.about.edit') }}" 
                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Profil
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    @if($profil)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Visi</p>
                        <p class="text-lg font-semibold text-gray-900">1</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-100 to-green-200 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-list text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Misi</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $misis->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Terakhir Update</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $profil->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 
 