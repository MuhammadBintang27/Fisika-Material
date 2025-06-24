@extends('admin.layouts.app')

@section('title', 'Manajemen Kunjungan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Kunjungan</h2>
            <p class="text-gray-600">Daftar kunjungan yang diajukan guest</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kunjungan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->namaPengunjung }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->tujuan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->jumlahPengunjung }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($item->status === 'PENDING') bg-yellow-100 text-yellow-800
                                    @elseif($item->status === 'APPROVED') bg-green-100 text-green-800
                                    @elseif($item->status === 'REJECTED') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.kunjungan.show', $item->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.kunjungan.updateStatus', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="APPROVED">
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.kunjungan.updateStatus', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="REJECTED">
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.kunjungan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-700" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-calendar-check text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada kunjungan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kunjungan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $kunjungan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 
 