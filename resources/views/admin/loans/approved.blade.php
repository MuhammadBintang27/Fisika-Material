@extends('admin.layouts.app')

@section('title', 'Peminjaman Disetujui')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-8 text-white shadow-xl border border-green-500">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Peminjaman Disetujui</h1>
                <p class="text-green-100 text-lg">Kelola peminjaman alat laboratorium yang sudah disetujui</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.loans.pending') }}" 
                   class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-clock mr-2 group-hover:animate-pulse"></i>
                    Pending ({{ \App\Models\Peminjaman::where('status', 'PENDING')->count() }})
                </a>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Pencarian Peminjaman</h3>
        </div>
        <form method="GET" action="{{ route('admin.loans.approved') }}" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1 w-full">
                <input type="text" name="search" 
                       value="{{ request()->input('search') }}"
                       placeholder="Cari berdasarkan tracking code atau nama peminjam..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" 
                    class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg font-semibold">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center space-x-2 overflow-x-auto">
            <a href="{{ route('admin.loans.index') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-list mr-2"></i>Semua
            </a>
            <a href="{{ route('admin.loans.pending') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-clock mr-2"></i>Pending
            </a>
            <a href="{{ route('admin.loans.approved') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg">
                <i class="fas fa-check-circle mr-2"></i>Disetujui
            </a>
            <a href="{{ route('admin.loans.completed') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-check-double mr-2"></i>Selesai
            </a>
            <a href="{{ route('admin.loans.rejected') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-times-circle mr-2"></i>Ditolak
            </a>
        </div>
    </div>

    <!-- Loans List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Daftar Peminjaman Disetujui</h3>
                <span class="text-sm text-gray-500">{{ $loans->total() }} total peminjaman</span>
            </div>
            
            @if($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penelitian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                                <tr class="hover:bg-green-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-white">{{ substr($loan->namaPeminjam, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $loan->namaPeminjam }}</div>
                                                <div class="text-sm text-gray-500">{{ $loan->noHp }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full @if($loan->user_type === 'dosen') bg-blue-100 text-blue-800 @elseif($loan->user_type === 'mahasiswa') bg-green-100 text-green-800 @else bg-purple-100 text-purple-800 @endif">
                                            {{ $loan->user_type_label }}
                                        </span>
                                        <div class="text-sm text-gray-500 mt-1">{{ $loan->nip_nim }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $loan->judul_penelitian ?? 'N/A' }}</div>
                                        @if($loan->supervisor_name)
                                            <div class="text-sm text-gray-500">Pembimbing: {{ $loan->supervisor_name }}</div>
                                        @endif
                                        @if($loan->durasi_jam)
                                            <div class="text-sm text-gray-500">{{ $loan->durasi_jam }} jam</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if($loan->items->count() > 0)
                                                @foreach($loan->items->take(2) as $item)
                                                    <div class="mb-1">{{ $item->alat->nama }} ({{ $item->jumlah }})</div>
                                                @endforeach
                                                @if($loan->items->count() > 2)
                                                    <div class="text-xs text-gray-500">+{{ $loan->items->count() - 2 }} alat lainnya</div>
                                                @endif
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</div>
                                            <div class="text-gray-500">sampai</div>
                                            <div>{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full @if($loan->status === 'APPROVED') bg-green-100 text-green-800 @else bg-blue-100 text-blue-800 @endif">
                                            {{ $loan->status === 'ONGOING' ? 'BERLANGSUNG' : 'DISETUJUI' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.loans.show', $loan->id) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                            <form method="POST" action="{{ route('admin.loans.destroy', $loan->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Hapus
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
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-handshake text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada peminjaman disetujui</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada peminjaman alat yang disetujui</p>
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
</style>
@endsection
