@extends('admin.layouts.app')

@section('title', 'Manajemen Staf & Tenaga Ahli')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Staf & Tenaga Ahli</h1>
            <p class="text-gray-600 mt-1">Kelola data staf dan tenaga ahli laboratorium fisika</p>
        </div>
        <a href="{{ route('admin.staff.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            <span class="font-medium">Tambah Staf</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-slate-50 to-gray-100 rounded-lg p-6 shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Staf</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $staff->total() }}</p>
                </div>
                <div class="p-3 bg-blue-500 rounded-lg shadow-md">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 shadow-md border border-blue-200 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-700 text-sm font-medium">Ketua Laboratorium</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $staff->where('jabatan', 'Ketua Laboratorium')->count() }}</p>
                </div>
                <div class="p-3 bg-blue-600 rounded-lg shadow-md">
                    <i class="fas fa-user-tie text-white text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-lg p-6 shadow-md border border-emerald-200 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-700 text-sm font-medium">Tenaga Laboran</p>
                    <p class="text-3xl font-bold text-emerald-900">{{ $staff->where('jabatan', 'Tenaga Laboran')->count() }}</p>
                </div>
                <div class="p-3 bg-emerald-600 rounded-lg shadow-md">
                    <i class="fas fa-flask text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    @if($staff->count() > 0)
        <!-- Staff Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($staff as $member)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 overflow-hidden">
                    <!-- Card Header with Photo -->
                    <div class="bg-gray-50 p-6 pb-4">
                        <div class="flex flex-col items-center">
                            @if($member->gambar->first())
                                <div class="mb-4">
                                    <img src="{{ asset($member->gambar->first()->url) }}" 
                                         alt="{{ $member->nama }}" 
                                         class="w-24 h-24 rounded-full object-cover shadow-md">
                                </div>
                            @else
                                <div class="mb-4">
                                    <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center shadow-md">
                                        <i class="fas fa-user text-gray-500 text-2xl"></i>
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $member->jabatan == 'Ketua Laboratorium' 
                                   ? 'bg-blue-100 text-blue-800 border border-blue-200' 
                                   : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                                <i class="fas {{ $member->jabatan == 'Ketua Laboratorium' ? 'fa-user-tie' : 'fa-flask' }} mr-1 text-xs"></i>
                                {{ $member->jabatan }}
                            </span>
                        </div>

                        <!-- Additional Info (if available) -->
                        @if($member->email || $member->phone)
                            <div class="space-y-2 mb-4 text-sm text-gray-600">
                                @if($member->email)
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2 w-4"></i>
                                        <span class="truncate">{{ $member->email }}</span>
                                    </div>
                                @endif
                                @if($member->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $member->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-center space-x-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.staff.edit', $member->id) }}" 
                               class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300 text-center text-sm font-medium shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-300 text-center text-sm font-medium shadow-md hover:shadow-lg flex items-center justify-center">
                                    <i class="fas fa-trash mr-2"></i>
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
            <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                {{ $staff->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-gray-50 to-slate-100 rounded-lg shadow-md p-12 text-center border border-gray-200">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto shadow-md">
                        <i class="fas fa-users text-gray-500 text-5xl"></i>
                    </div>
                </div>
                
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Belum ada staf terdaftar</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Mulai membangun tim laboratorium fisika yang profesional dengan menambahkan staf dan tenaga ahli pertama Anda
                </p>
                
                <a href="{{ route('admin.staff.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-colors duration-300 shadow-md hover:shadow-lg inline-flex items-center">
                    <i class="fas fa-user-plus mr-3 text-lg"></i>
                    <span class="font-semibold">Tambah Staf Pertama</span>
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* Smooth transitions for interactive elements */
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