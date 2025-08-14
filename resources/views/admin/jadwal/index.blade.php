@extends('admin.layouts.app')
@section('title', 'Kelola Jadwal Kunjungan')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Kelola Jadwal Kunjungan</h1>
                <p class="text-blue-100 text-lg">Atur ketersediaan jadwal kunjungan per jam</p>
            </div>
            <div class="flex items-center space-x-3">
                <input type="month" id="month-selector" value="{{ $currentMonth }}"
                       class="px-4 py-3 border border-blue-300 rounded-xl text-gray-700 bg-white/90 backdrop-blur-sm shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50">
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
        <div class="grid grid-cols-7 gap-1 mb-4">
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Minggu</div>
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Senin</div>
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Selasa</div>
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Rabu</div>
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Kamis</div>
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Jumat</div>
            <div class="text-center text-sm font-semibold text-gray-600 py-3 bg-gray-50 rounded-lg">Sabtu</div>
        </div>
        
        <div id="calendar-grid" class="grid grid-cols-7 gap-2">
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-blue-500 text-xl mb-2"></i>
                <p class="text-gray-500">Memuat kalender...</p>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            Keterangan Status Jadwal
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg border border-green-200 min-h-[3rem]">
                <div class="w-4 h-4 bg-green-500 border border-green-600 rounded-full shadow-sm flex-shrink-0"></div>
                <span class="text-sm font-medium text-green-700">Tersedia</span>
            </div>
            <div class="flex items-center space-x-3 p-3 bg-red-50 rounded-lg border border-red-200 min-h-[3rem]">
                <div class="w-4 h-4 bg-red-500 border border-red-600 rounded-full shadow-sm flex-shrink-0"></div>
                <span class="text-sm font-medium text-red-700">Dinonaktifkan</span>
            </div>
            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-200 min-h-[3rem]">
                <div class="w-4 h-4 bg-blue-500 border border-blue-600 rounded-full shadow-sm flex-shrink-0"></div>
                <span class="text-sm font-medium text-blue-700">Sudah Dibooking</span>
            </div>
            <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200 min-h-[3rem]">
                <div class="w-4 h-4 bg-yellow-500 border border-yellow-600 rounded-full shadow-sm flex-shrink-0"></div>
                <span class="text-sm font-medium text-yellow-700">Selesai (✓)</span>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div id="schedule-modal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-cog text-blue-500 mr-3"></i>
                            Pengaturan Jadwal
                        </h3>
                        <p class="text-gray-600 mt-1" id="modal-date"></p>
                    </div>
                    <button onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-all">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="schedule-list" class="space-y-3">
                    <!-- Schedule items will be populated by JavaScript -->
                </div>
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button onclick="closeScheduleModal()" 
                            class="px-6 py-3 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300 font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentMonth = '{{ $currentMonth }}';
let selectedDate = null;

document.addEventListener('DOMContentLoaded', function() {
    loadCalendar();
    document.getElementById('month-selector').addEventListener('change', function() {
        currentMonth = this.value;
        loadCalendar();
    });
});

// Add CSS styles for better visual appearance
const styles = `
    <style>
        .schedule-dot {
            transition: all 0.3s ease;
        }
        .schedule-dot:hover {
            transform: scale(1.2);
        }
        .calendar-day:hover .schedule-dot {
            transform: scale(1.1);
        }
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .notification-enter {
            transform: translateX(100%);
            opacity: 0;
        }
        .notification-enter-active {
            transform: translateX(0);
            opacity: 1;
        }
        .switch-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .switch-thumb {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
`;

document.head.insertAdjacentHTML('beforeend', styles);

function loadCalendar() {
    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = `
        <div class="col-span-7 text-center py-8">
            <i class="fas fa-spinner fa-spin text-blue-500 text-xl mb-2"></i>
            <p class="text-gray-500">Memuat kalender...</p>
        </div>
    `;

    fetch(`/admin/jadwal/calendar-data?month=${currentMonth}&_=${new Date().getTime()}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal memuat kalender');
        return response.json();
    })
    .then(data => {
        calendarGrid.innerHTML = '';
        
        // Debug: log data untuk tanggal 14
        const day14Data = data.find(day => day.day === 14);
        if (day14Data) {
            console.log('Data untuk tanggal 14:', day14Data);
            console.log('Schedules untuk tanggal 14:', day14Data.schedules);
        }

        // Calculate the first day of the month (0 = Sunday, 6 = Saturday)
        const firstDayOfMonth = new Date(`${currentMonth}-01`).getDay();
        
        // Add empty placeholders before the 1st
        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'border border-gray-200 rounded-lg h-28 bg-gray-50';
            calendarGrid.appendChild(emptyDiv);
        }

        // Render each day
        data.forEach(day => {
            const dayDiv = document.createElement('div');
            const isPast = day.isPast;
            const isToday = day.isToday;
            
            // Base styling
            let dayClasses = 'p-3 text-center cursor-pointer rounded-lg border transition-all duration-300 h-28 flex flex-col justify-between';
            
            if (isPast && !day.hasBookings) {
                dayClasses += ' border-gray-200 bg-gray-50 cursor-not-allowed opacity-60';
            } else if (isToday) {
                dayClasses += ' border-blue-300 bg-blue-50 hover:bg-blue-100 shadow-md';
            } else {
                dayClasses += ' border-gray-200 bg-white hover:bg-gray-50 hover:shadow-md';
            }
            
            dayDiv.className = dayClasses;
            
            // Only add click handler for future dates or dates with bookings
            if (day.hasBookings || !isPast) {
                dayDiv.onclick = () => openScheduleModal(day.date);
            }

            // Day number
            const dayNumber = document.createElement('div');
            dayNumber.className = `text-sm font-bold ${isToday ? 'text-blue-600' : (isPast ? 'text-gray-400' : 'text-gray-900')}`;
            dayNumber.textContent = day.day;
            dayDiv.appendChild(dayNumber);

            // Time slot indicators
            const indicators = document.createElement('div');
            indicators.className = 'flex justify-center flex-wrap gap-1 mt-2';

            // Define the 7 time slots (matching database jamMulai)
            const timeSlots = [
                '08:00:00', '09:00:00', '10:00:00', '11:00:00', 
                '13:00:00', '14:00:00', '15:00:00'
            ];

            // Map schedules to time slots by jamMulai
            const scheduleMap = {};
            day.schedules.forEach(schedule => {
                scheduleMap[schedule.jamMulai] = schedule;
            });

            // Render indicators for each time slot
            timeSlots.forEach(time => {
                const schedule = scheduleMap[time];
                const indicator = document.createElement('div');
                indicator.className = 'w-2.5 h-2.5 rounded-full border shadow-sm schedule-dot';
                
                if (!schedule) {
                    // No schedule exists - default to available (green)
                    indicator.className += ' bg-green-500 border-green-600';
                    indicator.title = 'Tersedia';
                } else if (!schedule.isActive) {
                    // Schedule exists but disabled
                    indicator.className += ' bg-red-500 border-red-600';
                    indicator.title = 'Dinonaktifkan';
                } else if (schedule.kunjungan) {
                    // Schedule has booking
                    if (schedule.kunjungan.isCompleted) {
                        indicator.className += ' bg-yellow-500 border-yellow-600';
                        indicator.title = `Selesai - ${schedule.kunjungan.namaPengunjung}`;
                    } else {
                        indicator.className += ' bg-blue-500 border-blue-600';
                        indicator.title = `Dibooking - ${schedule.kunjungan.namaPengunjung}`;
                    }
                } else {
                    // Schedule exists and active, no booking
                    indicator.className += ' bg-green-500 border-green-600';
                    indicator.title = 'Tersedia';
                }
                
                indicators.appendChild(indicator);
            });

            dayDiv.appendChild(indicators);
            dayDiv.classList.add('calendar-day');
            calendarGrid.appendChild(dayDiv);
        });

        // Add empty placeholders for remaining grid cells
        const totalCells = data.length + firstDayOfMonth;
        const remainingCells = (7 - (totalCells % 7)) % 7;
        for (let i = 0; i < remainingCells; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'border border-gray-200 rounded-lg h-28 bg-gray-50';
            calendarGrid.appendChild(emptyDiv);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        calendarGrid.innerHTML = `
            <div class="col-span-7 text-center py-8">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl mb-2"></i>
                <p class="text-red-500 font-medium">Gagal memuat kalender</p>
                <p class="text-gray-500 text-sm">Silakan coba lagi</p>
            </div>
        `;
    });
}

function openScheduleModal(date) {
    selectedDate = date;
    document.getElementById('modal-date').textContent = formatDate(date);
    
    // Show modal immediately with loading state
    const scheduleList = document.getElementById('schedule-list');
    scheduleList.innerHTML = `
        <div class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-blue-500 text-xl mb-2"></i>
            <p class="text-gray-500">Memuat pengaturan jadwal...</p>
        </div>
    `;
    document.getElementById('schedule-modal').classList.remove('hidden');
    
    fetch(`/admin/jadwal/schedule-settings?date=${date}`)
    .then(response => {
        if (!response.ok) throw new Error('Gagal memuat pengaturan jadwal');
        return response.json();
    })
    .then(data => {
        renderScheduleList(data.schedules);
    })
    .catch(error => {
        console.error('Error:', error);
        scheduleList.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl mb-2"></i>
                <p class="text-red-500 font-medium">Gagal memuat pengaturan jadwal</p>
                <p class="text-gray-500 text-sm">Silakan coba lagi</p>
                <button onclick="openScheduleModal('${date}')" class="mt-3 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

function closeScheduleModal() {
    document.getElementById('schedule-modal').classList.add('hidden');
    selectedDate = null;
}

function renderScheduleList(schedules) {
    const container = document.getElementById('schedule-list');
    container.innerHTML = '';
    schedules.forEach(schedule => {
        const item = createScheduleItem(schedule);
        container.appendChild(item);
    });
}

function createScheduleItem(schedule) {
    const div = document.createElement('div');
    div.className = 'flex items-center justify-between p-4 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all duration-300';
    
    const info = document.createElement('div');
    info.className = 'flex-1';
    
    const timeLabel = document.createElement('div');
    timeLabel.className = 'font-bold text-gray-900 text-lg flex items-center';
    timeLabel.innerHTML = `<i class="fas fa-clock text-blue-500 mr-2"></i>${schedule.timeLabel}`;
    info.appendChild(timeLabel);
    
    if (schedule.kunjungan) {
        const bookingInfo = document.createElement('div');
        bookingInfo.className = 'text-sm text-gray-600 mt-1 flex items-center';
        const status = schedule.kunjungan.isCompleted ? '<i class="fas fa-check-circle text-green-500 mr-1"></i>' : '<i class="fas fa-user text-blue-500 mr-1"></i>';
        bookingInfo.innerHTML = status + schedule.kunjungan.namaPengunjung;
        info.appendChild(bookingInfo);
    }
    
    div.appendChild(info);
    
    const toggle = document.createElement('div');
    toggle.className = 'flex items-center space-x-4';
    
    if (!schedule.isBooked) {
        const switchBtn = document.createElement('button');
        switchBtn.className = `relative inline-flex h-7 w-12 items-center rounded-full transition-all duration-300 shadow-sm switch-button ${schedule.isActive ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-300 hover:bg-gray-400'}`;
        switchBtn.onclick = () => toggleSchedule(schedule.id, !schedule.isActive);
        
        const switchThumb = document.createElement('span');
        switchThumb.className = `inline-block h-5 w-5 transform rounded-full bg-white transition-transform duration-300 shadow-md switch-thumb ${schedule.isActive ? 'translate-x-6' : 'translate-x-1'}`;
        switchBtn.appendChild(switchThumb);
        toggle.appendChild(switchBtn);
        
        const statusText = document.createElement('span');
        statusText.className = `text-sm font-semibold ${schedule.isActive ? 'text-green-600' : 'text-gray-500'}`;
        statusText.innerHTML = schedule.isActive ? '<i class="fas fa-check mr-1"></i>Aktif' : '<i class="fas fa-times mr-1"></i>Nonaktif';
        toggle.appendChild(statusText);
    } else {
        const statusBadge = document.createElement('span');
        statusBadge.className = 'px-4 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200';
        statusBadge.innerHTML = '<i class="fas fa-calendar-check mr-1"></i>Sudah Dibooking';
        toggle.appendChild(statusBadge);
    }
    
    div.appendChild(toggle);
    return div;
}

function toggleSchedule(scheduleId, isActive) {
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch(`/admin/jadwal/toggle-availability`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ scheduleId, isActive })
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal mengubah jadwal');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success notification
            showNotification('Jadwal berhasil diperbarui', 'success');
            
            // Reload calendar and modal
            loadCalendar();
            if (selectedDate) openScheduleModal(selectedDate);
        } else {
            throw new Error(data.message || 'Gagal mengubah jadwal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Restore button state
        button.disabled = false;
        button.innerHTML = originalContent;
        
        // Show error notification
        showNotification(error.message || 'Terjadi kesalahan saat mengubah jadwal', 'error');
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 ${
        type === 'success' ? 'bg-green-100 border border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-100 border border-red-200 text-red-800' :
        'bg-blue-100 border border-blue-200 text-blue-800'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${
                type === 'success' ? 'fa-check-circle' :
                type === 'error' ? 'fa-exclamation-circle' :
                'fa-info-circle'
            } mr-2"></i>
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    
    return new Intl.DateTimeFormat('id-ID', options).format(date);
}
</script>
@endsection