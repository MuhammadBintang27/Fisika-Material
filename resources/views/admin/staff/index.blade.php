@extends('admin.layouts.app')

@section('title', 'Manajemen Staf & Tenaga Ahli')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Staf & Tenaga Ahli</h1>
            <p class="text-gray-600">Kelola data staf dan tenaga ahli laboratorium</p>
        </div>
        <a href="{{ route('admin.staff.create') }}" 
           class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Staf
        </a>
    </div>

    <!-- Staff List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            @if($staff->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($staff as $member)
                                <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 transition-all duration-200 transform hover:scale-[1.01]">
                                    <td class="px-6 py-4">
                                        @if($member->gambar->first())
                                            <img src="{{ asset($member->gambar->first()->url) }}" alt="{{ $member->nama }}" class="w-12 h-12 rounded-lg object-cover shadow-md hover:shadow-lg transition-shadow">
                                        @else
                                            <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center shadow-md hover:shadow-lg transition-all">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900 hover:text-purple-600 transition-colors">{{ $member->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $member->jabatan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.staff.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-blue-50">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-red-50">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $staff->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada staf</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Mulai dengan menambahkan staf pertama Anda untuk mengelola tim laboratorium</p>
                    <a href="{{ route('admin.staff.create') }}" 
                       class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Staf Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
 