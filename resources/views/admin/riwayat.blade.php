@extends('layouts.admin')

@section('title', 'Riwayat Perubahan - ' . $profileSekolah->nama_sekolah)
@section('content')

    <div class="flex items-center justify-between mb-5">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Riwayat Perubahan — {{ $profileSekolah->nama_sekolah }}
        </h1>
        <a href="{{ route('user.show', $profileSekolah->user_id) }}" class="text-sm link">
            <i class="bi bi-arrow-left"></i> Kembali ke Detail Sekolah
        </a>
    </div>

    <div class="card">
        <div class="card-body divide-y divide-gray-100 dark:divide-gray-700">
            @forelse ($activities as $log)
                <div class="py-3 text-sm">
                    <p class="text-gray-800 dark:text-gray-100">
                        <span class="font-semibold">{{ $log->causer?->name ?? 'Sistem' }}</span>
                        — {{ $log->description }}
                        <span class="text-gray-400 dark:text-gray-500 text-xs">
                            ({{ $log->created_at->diffForHumans() }})
                        </span>
                    </p>

                    @php
                        $perubahan = $log->attribute_changes ?? [];
                    @endphp
                    @if (!empty($perubahan['attributes'] ?? null))
                        <ul class="text-xs text-gray-500 dark:text-gray-400 ml-4 mt-1 list-disc">
                            @foreach ($perubahan['attributes'] as $field => $newValue)
                                <li>
                                    {{ $field }}:
                                    <span class="line-through">{{ $perubahan['old'][$field] ?? '-' }}</span>
                                    &rarr;
                                    <span class="font-semibold">{{ is_array($newValue) ? json_encode($newValue) : $newValue }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 dark:text-gray-500 text-sm py-6 text-center">
                    Belum ada riwayat perubahan untuk sekolah ini.
                </p>
            @endforelse
        </div>

        @if (method_exists($activities, 'links'))
            <div class="card-body pt-0">
                <x-pagination :paginator="$activities" />
            </div>
        @endif
    </div>

@endsection