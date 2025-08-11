@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Admin</h1>
            <p class="text-gray-600 mt-1">Perbarui informasi administrator</p>
        </div>
        <a href="{{ route('admin.admin-management.index') }}" 
           class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <!-- Current Admin Info Card -->
    <div class="bg-gradient-to-r {{ $admin->is_super_admin ? 'from-red-500 to-red-600' : 'from-blue-500 to-blue-600' }} rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas {{ $admin->is_super_admin ? 'fa-user-shield' : 'fa-user-cog' }} text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ $admin->name }}</h2>
                <p class="opacity-90">{{ $admin->email }}</p>
                <span class="inline-block bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium mt-2">
                    {{ $admin->is_super_admin ? 'Super Admin' : 'Regular Admin' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-edit mr-3"></i>
                Form Edit Admin
            </h2>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.admin-management.update', $admin->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Personal Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-user mr-2 text-gray-400"></i>Nama Lengkap
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors @error('name') border-red-500 ring-2 ring-red-200 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $admin->name) }}" 
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>Email
                        </label>
                        <input type="email" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors @error('email') border-red-500 ring-2 ring-red-200 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $admin->email) }}" 
                               placeholder="Masukkan alamat email"
                               required>
                        @error('email')
                            <p class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-yellow-800 mb-4 flex items-center">
                        <i class="fas fa-key mr-2"></i>
                        Ubah Password (Opsional)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors pr-12 @error('password') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Kosongkan jika tidak ingin mengubah">
                                <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-sm flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                            <p class="text-gray-500 text-xs">Minimal 8 karakter (kosongkan jika tidak ingin mengubah)</p>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors pr-12" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Konfirmasi password baru">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-user-shield mr-2 text-blue-600"></i>Tingkat Akses
                    </h3>
                    <div class="space-y-4">
                        <label class="flex items-start space-x-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-white hover:border-blue-300 transition-all {{ !$admin->is_super_admin ? 'bg-white border-blue-300' : '' }}">
                            <input type="radio" 
                                   name="admin_type" 
                                   value="regular" 
                                   class="mt-1 text-blue-600 focus:ring-blue-500" 
                                   {{ !$admin->is_super_admin ? 'checked' : '' }}>
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-user-cog text-blue-600 mr-2"></i>
                                    <span class="font-medium text-gray-900">Regular Admin</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-1">Akses ke semua fitur admin kecuali manajemen admin</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start space-x-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-white hover:border-red-300 transition-all {{ $admin->is_super_admin ? 'bg-white border-red-300' : '' }}">
                            <input type="radio" 
                                   name="admin_type" 
                                   value="super" 
                                   class="mt-1 text-red-600 focus:ring-red-500"
                                   {{ $admin->is_super_admin ? 'checked' : '' }}>
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-user-shield text-red-600 mr-2"></i>
                                    <span class="font-medium text-gray-900">Super Admin</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-1">Akses penuh ke semua fitur termasuk manajemen admin</p>
                            </div>
                        </label>
                    </div>
                    <input type="hidden" name="is_super_admin" id="is_super_admin" value="{{ $admin->is_super_admin ? '1' : '0' }}">
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white py-3 px-6 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-colors duration-300 shadow-md hover:shadow-lg font-medium flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Admin
                    </button>
                    <a href="{{ route('admin.admin-management.index') }}" 
                       class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors duration-300 shadow-md hover:shadow-lg font-medium flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        eye.className = 'fas fa-eye';
    }
}

// Handle radio button changes
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="admin_type"]');
    const hiddenInput = document.getElementById('is_super_admin');
    
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'super') {
                hiddenInput.value = '1';
            } else {
                hiddenInput.value = '0';
            }
        });
    });
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    // Only validate if password is provided
    if (password) {
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak sama!');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter!');
            return false;
        }
    }
});
</script>
@endpush
