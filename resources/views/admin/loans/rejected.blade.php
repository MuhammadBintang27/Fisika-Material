@extends('admin.layouts.app')

@section('title', 'Peminjaman Ditolak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peminjaman Ditolak</h1>
            <p class="text-gray-600">Kelola permintaan peminjaman alat laboratorium yang ditolak</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.loans.pending') }}" 
               class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                <i class="fas fa-clock mr-2"></i>
                Pending ({{ \App\Models\Peminjaman::where('status', 'PENDING')->count() }})
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.loans.rejected') }}" class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="text" name="search" 
                       value="{{ request()->input('search') }}"
                       placeholder="Cari berdasarkan tracking code atau nama peminjam..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.loans.index') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Semua
            </a>
            <a href="{{ route('admin.loans.pending') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Pending
            </a>
            <a href="{{ route('admin.loans.approved') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Disetujui
            </a>
            <a href="{{ route('admin.loans.completed') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Selesai
            </a>
            <a href="{{ route('admin.loans.rejected') }}" 
               class="px-4 py-2 rounded-lg font-medium bg-red-100 text-red-700">
                Ditolak
            </a>
        </div>
    </div>

    <!-- Loans List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            @if($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penelitian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Peminjaman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $loan->namaPeminjam }}</div>
                                            <div class="text-sm text-gray-500">{{ $loan->noHp }}</div>
                                            @if($loan->tujuanPeminjaman)
                                                <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($loan->tujuanPeminjaman, 50) }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full @if($loan->user_type === 'dosen') bg-blue-100 text-blue-800 @elseif($loan->user_type === 'mahasiswa') bg-green-100 text-green-800 @else bg-purple-100 text-purple-800 @endif">{{ $loan->user_type_label }}</span>
                                        <div class="text-sm text-gray-500 mt-1">{{ $loan->nip_nim }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium">{{ $loan->judul_penelitian ?? 'N/A' }}</div>
                                            @if($loan->supervisor_name)
                                                <div class="text-xs text-gray-500">Pembimbing: {{ $loan->supervisor_name }}</div>
                                            @endif
                                            @if($loan->durasi_jam)
                                                <div class="text-xs text-gray-500">{{ $loan->durasi_jam }} jam</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if($loan->items->count() > 0)
                                                @foreach($loan->items->take(2) as $item)
                                                    <div class="flex items-center space-x-2">
                                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                        <span>{{ $item->alat->nama }} ({{ $item->jumlah }})</span>
                                                    </div>
                                                @endforeach
                                                @if($loan->items->count() > 2)
                                                    <div class="text-xs text-gray-500 mt-1">+{{ $loan->items->count() - 2 }} alat lainnya</div>
                                                @endif
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</div>
                                            <div class="text-gray-500">s/d</div>
                                            <div>{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">REJECTED</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($loan->notes)
                                            <div class="text-sm text-gray-900 max-w-xs">
                                                <div class="line-clamp-2">{{ $loan->notes }}</div>
                                            </div>
                                        @else
                                            <span class="text-gray-500 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.loans.show', $loan->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.loans.destroy', $loan->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
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
                    {{ $loans->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-handshake text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada peminjaman</h3>
                    <p class="text-gray-500">Belum ada permintaan peminjaman alat</p>
                </div>
            @endif
        </div>
    </div>
</div>
<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 