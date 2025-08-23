@extends('admin.layouts.app')

@section('title', 'Manajemen Staf & Tenaga Ahli')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Staf & Tenaga Ahli</h1>
                <p class="text-blue-100 text-lg">Kelola data staf dan tenaga ahli laboratorium fisika</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.staff.create') }}" 
                   class="bg-white hover:bg-gray-100 text-blue-700 px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-plus mr-2 group-hover:animate-pulse"></i>
                    Tambah Staf
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Staf</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $staff->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Ketua Laboratorium</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $staff->where('jabatan', 'Ketua Laboratorium')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-user-tie text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Tenaga Laboran</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $staff->where('jabatan', 'Tenaga Laboran')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-flask text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    @if($staff->count() > 0)
        <!-- Staff Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($staff as $member)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden hover:-translate-y-1 group">
                    <!-- Card Header with Photo -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 pb-4">
                        <div class="flex flex-col items-center">
                            @if($member->gambar->first())
                                <div class="mb-4">
                                    <img src="{{ url('storage/' . $member->gambar->first()->url) }}" 
                                         alt="{{ $member->nama }}" 
                                         class="w-24 h-24 rounded-full object-cover shadow-lg ring-4 ring-white group-hover:ring-blue-200 transition-all duration-300">
                                </div>
                            @else
                                <div class="mb-4">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center shadow-lg ring-4 ring-white group-hover:ring-blue-200 transition-all duration-300">
                                        <i class="fas fa-user text-white text-2xl"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 pt-2">
                        <div class="text-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $member->nama }}
                            </h3>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium shadow-sm
                                {{ $member->jabatan == 'Ketua Laboratorium' 
                                   ? 'bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-800 border border-indigo-300' 
                                   : 'bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800 border border-emerald-300' }}">
                                <i class="fas {{ $member->jabatan == 'Ketua Laboratorium' ? 'fa-user-tie' : 'fa-flask' }} mr-1.5 text-xs"></i>
                                {{ $member->jabatan }}
                            </span>
                        </div>

                        <!-- Additional Info (if available) -->
                        @if($member->email || $member->phone)
                            <div class="space-y-2 mb-4 text-sm text-gray-600">
                                @if($member->email)
                                    <div class="flex items-center bg-gray-50 rounded-lg p-2">
                                        <i class="fas fa-envelope text-gray-400 mr-2 w-4"></i>
                                        <span class="truncate">{{ $member->email }}</span>
                                    </div>
                                @endif
                                @if($member->phone)
                                    <div class="flex items-center bg-gray-50 rounded-lg p-2">
                                        <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $member->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-center space-x-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.staff.edit', $member->id) }}" 
                               class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 text-center text-sm font-medium shadow-md hover:shadow-lg flex items-center justify-center group">
                                <i class="fas fa-edit mr-2 group-hover:animate-pulse"></i>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 text-center text-sm font-medium shadow-md hover:shadow-lg flex items-center justify-center group">
                                    <i class="fas fa-trash mr-2 group-hover:animate-pulse"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-100">
                {{ $staff->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-gray-50 to-slate-100 rounded-xl shadow-lg p-12 text-center border border-gray-200">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-users text-blue-600 text-5xl"></i>
                    </div>
                </div>
                
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Belum ada staf terdaftar</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Mulai membangun tim laboratorium fisika yang profesional dengan menambahkan staf dan tenaga ahli pertama Anda
                </p>
                
                <a href="{{ route('admin.staff.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl inline-flex items-center group">
                    <i class="fas fa-user-plus mr-3 text-lg group-hover:animate-pulse"></i>
                    <span class="font-semibold">Tambah Staf Pertama</span>
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* Smooth transitions for interactive elements */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    .transition-transform {
        transition-property: transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    .transition-colors {
        transition-property: color, background-color, border-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    .transition-shadow {
        transition-property: box-shadow;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endsection