@extends('admin.layouts.app')
@section('title', 'Kelola Jadwal Kunjungan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Jadwal Kunjungan</h2>
            <p class="text-gray-600">Atur ketersediaan jadwal kunjungan per jam</p>
        </div>
        <div class="flex items-center space-x-4">
            <input type="month" id="month-selector" value="{{ $currentMonth }}"
                   class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-7 gap-1 mb-4">
            <div class="text-center text-sm font-medium text-gray-500 py-2">Minggu</div>
            <div class="text-center text-sm font-medium text-gray-500 py-2">Senin</div>
            <div class="text-center text-sm font-medium text-gray-500 py-2">Selasa</div>
            <div class="text-center text-sm font-medium text-gray-500 py-2">Rabu</div>
            <div class="text-center text-sm font-medium text-gray-500 py-2">Kamis</div>
            <div class="text-center text-sm font-medium text-gray-500 py-2">Jumat</div>
            <div class="text-center text-sm font-medium text-gray-500 py-2">Sabtu</div>
        </div>
        
        <div id="calendar-grid" class="grid grid-cols-7 gap-1">
            <div class="text-center">Memuat...</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Keterangan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-green-400 border border-green-500 rounded"></div>
                <span class="text-sm text-gray-600">Tersedia</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-red-400 border border-red-500 rounded"></div>
                <span class="text-sm text-gray-600">Dinonaktifkan</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-blue-400 border border-blue-500 rounded"></div>
                <span class="text-sm text-gray-600">Sudah Dibooking</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-yellow-400 border border-yellow-500 rounded"></div>
                <span class="text-sm text-gray-600">Selesai (✓)</span>
            </div>
        </div>
    </div>
</div>

<div id="schedule-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Pengaturan Jadwal</h3>
                    <button onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="selected-date-info" class="mb-6">
                    <p class="text-lg font-medium text-gray-800" id="modal-date"></p>
                </div>
                <div id="schedule-list" class="space-y-3">
                    <!-- Schedule items will be populated by JavaScript -->
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button onclick="closeScheduleModal()" 
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
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

function loadCalendar() {
    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = '<div class="text-center">Memuat...</div>';

    fetch(`/admin/jadwal/calendar-data?month=${currentMonth}&_=${new Date().getTime()}`, { // Cache busting
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

        // Calculate the first day of the month (0 = Sunday, 6 = Saturday)
        const firstDayOfMonth = new Date(`${currentMonth}-01`).getDay();
        // Add empty placeholders before the 1st
        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'border border-gray-200 rounded-lg h-24';
            calendarGrid.appendChild(emptyDiv);
        }

        // Render each day
        data.forEach(day => {
            const dayDiv = document.createElement('div');
            dayDiv.className = 'p-2 text-center cursor-pointer hover:bg-gray-100 rounded-lg border border-gray-200 h-24';
            if (day.hasBookings || !day.isPast) {
                dayDiv.onclick = () => openScheduleModal(day.date);
            }
            dayDiv.innerHTML = `<div class="text-sm font-medium ${day.isToday ? 'text-blue-600' : 'text-gray-900'}">${day.day}</div>`;

            // Add indicators for all 7 time slots
            const indicators = document.createElement('div');
            indicators.className = 'flex justify-center space-x-1 mt-1';

            // Define the 7 time slots (matching database jamMulai)
            const timeSlots = [
                '08:00:00', '09:00:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00'
            ];

            // Map schedules to time slots by jamMulai
            const scheduleMap = {};
            day.schedules.forEach(schedule => {
                const startTime = schedule.jamMulai; // Use jamMulai as is
                scheduleMap[startTime] = schedule;
                console.log(`Mapped ${startTime}: isActive=${schedule.isActive}, isBooked=${schedule.isBooked}, kunjungan=${JSON.stringify(schedule.kunjungan)}`);
            });

            // Render 7 dots, one for each time slot
            timeSlots.forEach(time => {
                const schedule = scheduleMap[time] || { isActive: true, isBooked: false, kunjungan: null }; // Default to available
                const indicator = document.createElement('div');
                indicator.className = 'w-2 h-2 rounded-full border';

                if (!schedule.isActive) {
                    indicator.className += ' bg-red-400 border-red-500'; // Dinonaktifkan
                } else if (schedule.kunjungan) {
                    if (schedule.kunjungan.isCompleted) {
                        indicator.className += ' bg-yellow-400 border-yellow-500'; // Selesai
                    } else {
                        indicator.className += ' bg-blue-400 border-blue-500'; // Dibooking
                    }
                } else {
                    indicator.className += ' bg-green-400 border-green-500'; // Tersedia
                }
                indicators.appendChild(indicator);
            });

            dayDiv.appendChild(indicators);
            calendarGrid.appendChild(dayDiv);
        });

        // Add empty placeholders for remaining grid cells
        const totalCells = data.length + firstDayOfMonth;
        const remainingCells = (7 - (totalCells % 7)) % 7;
        for (let i = 0; i < remainingCells; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'border border-gray-200 rounded-lg h-24';
            calendarGrid.appendChild(emptyDiv);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        calendarGrid.innerHTML = '<div class="text-center text-red-500">Gagal memuat kalender. Silakan coba lagi.</div>';
    });
}

function openScheduleModal(date) {
    selectedDate = date;
    document.getElementById('modal-date').textContent = formatDate(date);
    fetch(`/admin/jadwal/schedule-settings?date=${date}`)
    .then(response => {
        if (!response.ok) throw new Error('Gagal memuat pengaturan jadwal');
        return response.json();
    })
    .then(data => {
        renderScheduleList(data.schedules);
        document.getElementById('schedule-modal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal memuat pengaturan jadwal. Silakan coba lagi.');
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
    div.className = 'flex items-center justify-between p-3 border border-gray-200 rounded-lg';
    const info = document.createElement('div');
    info.className = 'flex-1';
    const timeLabel = document.createElement('div');
    timeLabel.className = 'font-medium text-gray-900';
    timeLabel.textContent = schedule.timeLabel;
    info.appendChild(timeLabel);
    if (schedule.kunjungan) {
        const bookingInfo = document.createElement('div');
        bookingInfo.className = 'text-sm text-gray-600';
        const status = schedule.kunjungan.isCompleted ? '✓ ' : '';
        bookingInfo.textContent = status + schedule.kunjungan.namaPengunjung;
        info.appendChild(bookingInfo);
    }
    div.appendChild(info);
    const toggle = document.createElement('div');
    toggle.className = 'flex items-center space-x-3';
    if (!schedule.isBooked) {
        const switchBtn = document.createElement('button');
        switchBtn.className = `relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${schedule.isActive ? 'bg-green-600' : 'bg-gray-300'}`;
        switchBtn.onclick = () => toggleSchedule(schedule.id, !schedule.isActive);
        const switchThumb = document.createElement('span');
        switchThumb.className = `inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${schedule.isActive ? 'translate-x-6' : 'translate-x-1'}`;
        switchBtn.appendChild(switchThumb);
        toggle.appendChild(switchBtn);
        const statusText = document.createElement('span');
        statusText.className = 'text-sm text-gray-600';
        statusText.textContent = schedule.isActive ? 'Aktif' : 'Nonaktif';
        toggle.appendChild(statusText);
    } else {
        const statusBadge = document.createElement('span');
        statusBadge.className = 'px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800';
        statusBadge.textContent = 'Sudah Dibooking';
        toggle.appendChild(statusBadge);
    }
    div.appendChild(toggle);
    return div;
}

function toggleSchedule(scheduleId, isActive) {
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
            loadCalendar();
            if (selectedDate) openScheduleModal(selectedDate);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah jadwal');
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}
</script>
@endsection