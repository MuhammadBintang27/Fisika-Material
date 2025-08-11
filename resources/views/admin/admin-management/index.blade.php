@extends('admin.layouts.app')

@section('title', 'Manajemen Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Admin</h1>
            <p class="text-gray-600 mt-1">Kelola akun administrator sistem</p>
        </div>
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.admin-management.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
            <i class="fas fa-user-plus mr-2"></i>
            <span class="font-medium">Tambah Admin</span>
        </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 shadow-lg border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">Total Admin</p>
                    <p class="text-3xl font-bold text-blue-800">{{ $admins->total() }}</p>
                </div>
                <div class="p-3 bg-blue-500 rounded-lg shadow-md">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 shadow-lg border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-medium">Super Admin</p>
                    <p class="text-3xl font-bold text-red-800">{{ $admins->where('is_super_admin', true)->count() }}</p>
                </div>
                <div class="p-3 bg-red-500 rounded-lg shadow-md">
                    <i class="fas fa-user-shield text-white text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 shadow-lg border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">Regular Admin</p>
                    <p class="text-3xl font-bold text-green-800">{{ $admins->where('is_super_admin', false)->count() }}</p>
                </div>
                <div class="p-3 bg-green-500 rounded-lg shadow-md">
                    <i class="fas fa-user-cog text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-md">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-green-400 hover:text-green-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 shadow-md">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Admin Cards -->
    @if($admins->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($admins as $admin)
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl hover:scale-105 transition-all duration-300 transform overflow-hidden">
            <!-- Card Header -->
            <div class="relative {{ $admin->is_super_admin ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-blue-500 to-blue-600' }} p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas {{ $admin->is_super_admin ? 'fa-user-shield' : 'fa-user-cog' }} text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">{{ $admin->name }}</h3>
                            <p class="text-sm opacity-90">{{ $admin->email }}</p>
                        </div>
                    </div>
                    @if($admin->is_super_admin)
                    <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs font-medium">
                        Super Admin
                    </span>
                    @else
                    <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs font-medium">
                        Admin
                    </span>
                    @endif
                </div>
            </div>

            <!-- Card Content -->
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar-alt w-4 h-4 mr-2"></i>
                        <span>Dibuat: {{ $admin->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock w-4 h-4 mr-2"></i>
                        <span>Terakhir update: {{ $admin->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if(auth()->user()->isSuperAdmin())
            <div class="flex border-t border-gray-100">
                <a href="{{ route('admin.admin-management.show', $admin->id) }}" 
                   class="flex-1 text-center py-3 text-blue-600 hover:bg-blue-50 transition-colors font-medium">
                    <i class="fas fa-eye mr-1"></i> Detail
                </a>
                @if(!($admin->is_super_admin && App\Models\User::where('is_super_admin', true)->count() === 1))
                <a href="{{ route('admin.admin-management.edit', $admin->id) }}" 
                   class="flex-1 text-center py-3 text-yellow-600 hover:bg-yellow-50 border-l border-gray-100 transition-colors font-medium">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                @endif
                @if($admin->id !== auth()->id() && !($admin->is_super_admin && App\Models\User::where('is_super_admin', true)->count() === 1))
                <button onclick="confirmDelete({{ $admin->id }}, '{{ $admin->name }}')" 
                        class="flex-1 text-center py-3 text-red-600 hover:bg-red-50 border-l border-gray-100 transition-colors font-medium">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
                @endif
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $admins->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-users text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Admin</h3>
        <p class="text-gray-500">Mulai dengan menambahkan admin pertama.</p>
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
