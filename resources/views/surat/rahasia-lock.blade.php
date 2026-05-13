@extends('layouts.app')

@section('title', 'Surat Rahasia — Verifikasi')
@section('page-title', 'Surat Rahasia')
@section('page-subtitle', 'Akses terproteksi — diperlukan verifikasi')

@section('content')
<div class="fade-in-up flex items-center justify-center min-h-[60vh]">
    <div class="card p-10 max-w-sm w-full text-center">
        <!-- Lock Icon -->
        <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center" style="background: #fee2e2">
            <span class="material-symbols-outlined text-4xl text-red-600" style="font-variation-settings:'FILL' 1">lock</span>
        </div>

        <h2 class="font-heading font-bold text-xl text-gray-900 mb-2">Akses Terbatas</h2>
        <p class="text-sm text-gray-500 mb-7 leading-relaxed">
            Halaman ini berisi surat dengan klasifikasi <strong class="text-red-600">RAHASIA</strong>. Masukkan password Anda untuk melanjutkan.
        </p>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-5 text-left">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-red-500 text-lg" style="font-variation-settings:'FILL' 1">error</span>
                <p class="text-sm text-red-600">{{ $errors->first('password') }}</p>
            </div>
        </div>
        @endif

        <form action="{{ route('surat.rahasia.verify') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label text-left">Password Anda</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-lg">key</span>
                    <input type="password" name="password" placeholder="Masukkan password..." class="form-input pl-10" autofocus required/>
                </div>
            </div>
            <button type="submit" class="btn-primary w-full justify-center" style="background: #dc2626">
                <span class="material-symbols-outlined text-xl">lock_open</span>
                Verifikasi & Buka
            </button>
        </form>

        <div class="mt-5 pt-5 border-t border-gray-100">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-gray-700 flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
