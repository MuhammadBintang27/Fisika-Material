@extends('admin.layouts.app')

@section('title', 'Detail Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Admin</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap administrator</p>
        </div>
        <a href="{{ route('admin.admin-management.index') }}" 
           class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <!-- Admin Profile Card -->
    <div class="bg-gradient-to-r {{ $admin->is_super_admin ? 'from-red-500 to-red-600' : 'from-blue-500 to-blue-600' }} rounded-xl p-8 text-white shadow-xl">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
            <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas {{ $admin->is_super_admin ? 'fa-user-shield' : 'fa-user-cog' }} text-4xl"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-3xl font-bold mb-2">{{ $admin->name }}</h2>
                <p class="text-xl opacity-90 mb-4">{{ $admin->email }}</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                    <span class="inline-block bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas {{ $admin->is_super_admin ? 'fa-crown' : 'fa-user' }} mr-2"></i>
                        {{ $admin->is_super_admin ? 'Super Administrator' : 'Administrator' }}
                    </span>
                    <span class="inline-block bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-calendar mr-2"></i>
                        Bergabung {{ $admin->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-3"></i>
                    Informasi Personal
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-user w-5 text-center mr-3 text-gray-400"></i>Nama Lengkap
                    </span>
                    <span class="text-gray-900 font-semibold">{{ $admin->name }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-envelope w-5 text-center mr-3 text-gray-400"></i>Email
                    </span>
                    <span class="text-gray-900 font-semibold">{{ $admin->email }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-shield-alt w-5 text-center mr-3 text-gray-400"></i>Level Akses
                    </span>
                    <span class="font-semibold {{ $admin->is_super_admin ? 'text-red-600' : 'text-blue-600' }}">
                        {{ $admin->is_super_admin ? 'Super Admin' : 'Regular Admin' }}
                    </span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-check-circle w-5 text-center mr-3 text-gray-400"></i>Status
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-circle text-green-400 text-xs mr-2"></i>
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-cog mr-3"></i>
                    Informasi Akun
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-calendar-plus w-5 text-center mr-3 text-gray-400"></i>Dibuat pada
                    </span>
                    <span class="text-gray-900 font-semibold">{{ $admin->created_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-edit w-5 text-center mr-3 text-gray-400"></i>Terakhir diupdate
                    </span>
                    <span class="text-gray-900 font-semibold">{{ $admin->updated_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-clock w-5 text-center mr-3 text-gray-400"></i>Relatif
                    </span>
                    <span class="text-gray-900 font-semibold">{{ $admin->updated_at->diffForHumans() }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-gray-600 font-medium">
                        <i class="fas fa-fingerprint w-5 text-center mr-3 text-gray-400"></i>ID Admin
                    </span>
                    <span class="text-gray-900 font-semibold font-mono">#{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-key mr-3"></i>
                Hak Akses & Permissions
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Admin Permissions -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-cog text-blue-600 mr-2"></i>
                        Akses Admin Dasar
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Dashboard & Analytics</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Kelola Artikel</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Kelola Alat & Peralatan</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Kelola Peminjaman</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Kelola Kunjungan</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Kelola Pengujian</span>
                        </div>
                    </div>
                </div>

                <!-- Super Admin Permissions -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-shield text-red-600 mr-2"></i>
                        Akses Super Admin
                    </h4>
                    <div class="space-y-3">
                        @if($admin->is_super_admin)
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Manajemen Admin</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Tambah Admin Baru</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Edit Admin Lain</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Hapus Admin Lain</span>
                        </div>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>Full System Access</span>
                        </div>
                        @else
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Manajemen Admin</span>
                        </div>
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Tambah Admin Baru</span>
                        </div>
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Edit Admin Lain</span>
                        </div>
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Hapus Admin Lain</span>
                        </div>
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Full System Access</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if(auth()->user()->isSuperAdmin())
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-tools mr-2 text-gray-600"></i>
            Aksi Admin
        </h3>
        <div class="flex flex-col sm:flex-row gap-3">
            @if(!($admin->is_super_admin && App\Models\User::where('is_super_admin', true)->count() === 1))
            <a href="{{ route('admin.admin-management.edit', $admin->id) }}" 
               class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white py-3 px-6 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-colors duration-300 shadow-md hover:shadow-lg font-medium flex items-center justify-center">
                <i class="fas fa-edit mr-2"></i>
                Edit Admin
            </a>
            @endif
            
            @if($admin->id !== auth()->id() && !($admin->is_super_admin && App\Models\User::where('is_super_admin', true)->count() === 1))
            <button onclick="confirmDelete({{ $admin->id }}, '{{ $admin->name }}')" 
                    class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white py-3 px-6 rounded-lg hover:from-red-600 hover:to-red-700 transition-colors duration-300 shadow-md hover:shadow-lg font-medium flex items-center justify-center">
                <i class="fas fa-trash mr-2"></i>
                Hapus Admin
            </button>
            @endif

            @if(($admin->is_super_admin && App\Models\User::where('is_super_admin', true)->count() === 1) || $admin->id === auth()->id())
            <div class="flex-1 bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-medium flex items-center justify-center cursor-not-allowed">
                <i class="fas fa-shield-alt mr-2"></i>
                @if($admin->is_super_admin && App\Models\User::where('is_super_admin', true)->count() === 1)
                    Super Admin Terakhir
                @else
                    Akun Anda Sendiri
                @endif
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

@if(auth()->user()->isSuperAdmin())
<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Konfirmasi Hapus Admin</h3>
            <p class="text-gray-500 text-center mb-6">
                Apakah Anda yakin ingin menghapus admin <strong id="adminName"></strong>?
                <span class="block text-red-500 text-sm mt-1">Tindakan ini tidak dapat dibatalkan.</span>
            </p>
            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@if(auth()->user()->isSuperAdmin())
@push('scripts')
<script>
function confirmDelete(adminId, adminName) {
    document.getElementById('adminName').textContent = adminName;
    document.getElementById('deleteForm').action = "{{ route('admin.admin-management.destroy', ':id') }}".replace(':id', adminId);
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush
@endif
