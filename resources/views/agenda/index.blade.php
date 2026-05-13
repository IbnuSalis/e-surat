@extends('layouts.app')

@section('title', 'Agenda Acara')
@section('page-title', 'Agenda Acara')
@section('page-subtitle', 'Jadwal dan kegiatan desa')

@section('content')
<div class="fade-in-up">

    <!-- Upcoming highlight -->
    @if($upcomingAgendas->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @foreach($upcomingAgendas as $ua)
        <div class="flex items-center gap-4 p-4 rounded-xl border" style="background: #f0f4ff; border-color: #d3e4fe">
            <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center text-white font-bold flex-shrink-0" style="background: {{ $ua->warna }}">
                <span class="text-lg leading-none font-heading">{{ $ua->tanggal_mulai->format('d') }}</span>
                <span class="text-[9px] opacity-80">{{ $ua->tanggal_mulai->format('M') }}</span>
            </div>
            <div class="min-w-0">
                <p class="font-heading font-semibold text-gray-900 text-sm truncate">{{ $ua->judul }}</p>
                <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-sm">location_on</span>
                    {{ Str::limit($ua->lokasi ?? 'Belum ditentukan', 30) }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <p class="text-gray-500 text-sm">Total: <strong class="text-gray-900">{{ $agendas->total() }}</strong> agenda</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('agenda.create') }}" class="btn-primary flex-shrink-0">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Agenda
        </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="card p-5 mb-5">
        <form action="{{ route('agenda.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Cari Agenda</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul agenda..." class="form-input pl-10"/>
                </div>
            </div>
            <div class="min-w-[160px]">
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="upcoming"  {{ request('status') === 'upcoming'  ? 'selected' : '' }}>Akan Datang</option>
                    <option value="ongoing"   {{ request('status') === 'ongoing'   ? 'selected' : '' }}>Berlangsung</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Filter
                </button>
                @if(request()->hasAny(['search','status']))
                <a href="{{ route('agenda.index') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-lg">clear</span>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Agenda List -->
    <div class="card overflow-hidden">
        @if($agendas->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-200">event_busy</span>
            <h3 class="font-heading font-semibold text-gray-500 mt-3">Tidak ada agenda</h3>
            <p class="text-sm text-gray-400 mt-1">Belum ada agenda yang terjadwal.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th class="text-left w-12">#</th>
                        <th class="text-left">Judul Agenda</th>
                        <th class="text-left">Tanggal Mulai</th>
                        <th class="text-left">Lokasi</th>
                        <th class="text-left">Penanggung Jawab</th>
                        <th class="text-left">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agendas as $i => $agenda)
                    <tr>
                        <td class="text-gray-400 text-xs">{{ $agendas->firstItem() + $i }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background: {{ $agenda->warna }}">
                                    {{ $agenda->tanggal_mulai->format('d') }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $agenda->judul }}</p>
                                    @if($agenda->deskripsi)
                                    <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $agenda->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm text-gray-700">{{ $agenda->tanggal_mulai->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $agenda->tanggal_mulai->format('H:i') }} WIB</p>
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                <span class="material-symbols-outlined text-gray-400 text-sm">location_on</span>
                                {{ $agenda->lokasi ?? '—' }}
                            </div>
                        </td>
                        <td class="text-sm text-gray-700">{{ $agenda->penanggung_jawab ?? '—' }}</td>
                        <td><span class="badge badge-{{ $agenda->status }}">{{ $agenda->status_label }}</span></td>
                        <td>
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('agenda.show', $agenda->id) }}" class="btn-icon btn-icon-view">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('agenda.edit', $agenda->id) }}" class="btn-icon btn-icon-edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form id="del-agenda-{{ $agenda->id }}" action="{{ route('agenda.destroy', $agenda->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('del-agenda-{{ $agenda->id }}')" class="btn-icon btn-icon-delete">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($agendas->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500">Menampilkan {{ $agendas->firstItem() }}–{{ $agendas->lastItem() }} dari {{ $agendas->total() }} entri</p>
            <div class="flex items-center gap-1">
                @if($agendas->onFirstPage())<span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border border-gray-100">‹</span>
                @else<a href="{{ $agendas->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-200 hover:bg-gray-50">‹</a>@endif
                @foreach($agendas->getUrlRange(max(1,$agendas->currentPage()-2),min($agendas->lastPage(),$agendas->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-sm border transition-colors {{ $page == $agendas->currentPage() ? 'text-white' : 'text-gray-600 border-gray-200 hover:bg-gray-50' }}" style="{{ $page == $agendas->currentPage() ? 'background:#002147;border-color:#002147' : '' }}">{{ $page }}</a>
                @endforeach
                @if($agendas->hasMorePages())<a href="{{ $agendas->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-200 hover:bg-gray-50">›</a>
                @else<span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border border-gray-100">›</span>@endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
