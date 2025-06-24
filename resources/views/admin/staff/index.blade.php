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
           class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah Staf
        </a>
    </div>

    <!-- Staff List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            @if($staff->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($staff as $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        @if($member->gambar->first())
                                            <img src="{{ asset($member->gambar->first()->url) }}" alt="{{ $member->nama }}" class="w-12 h-12 rounded-lg object-cover mr-4">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $member->jabatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.staff.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
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
                <div class="text-center py-12">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada staf</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan staf pertama Anda</p>
                    <a href="{{ route('admin.staff.create') }}" 
                       class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Staf Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
 