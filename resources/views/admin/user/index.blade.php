@extends('layouts.admin')

@section('title')
    User
@endsection

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Data User</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4" data-alert>
            {{ session('success') }}
            <button type="button" data-dismiss="alert" class="btn-close ml-auto">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mb-4" data-alert>
            {{ session('error') }}
            <button type="button" data-dismiss="alert" class="btn-close ml-auto">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <x-table bordered class="text-[11px]">

                <x-slot:head>
                    <tr class="bg-gray-800 text-white text-center">
                        <x-table.heading class="text-white!">No</x-table.heading>
                        <x-table.heading class="text-white!">Nama</x-table.heading>
                        <x-table.heading class="text-white!">Email</x-table.heading>
                        <x-table.heading class="text-white!">Role</x-table.heading>
                        <x-table.heading class="text-white! text-center">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                <tbody>
                    {{-- PERBAIKAN: Gunakan $users bukan $user, dan $item di dalam loop --}}
                    @forelse ($users as $no => $item)
                        <x-table.row>
                            <x-table.cell class="text-center font-bold">{{ $no + 1 }}</x-table.cell>
                            <x-table.cell>{{ $item->name }}</x-table.cell>
                            <x-table.cell>{{ $item->email }}</x-table.cell>
                            <x-table.cell>
                                @if($item->getRoleNames()->isNotEmpty())
                                    <span class="badge badge-primary">
                                        {{ $item->getRoleNames()->first() }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">User</span>
                                @endif
                            </x-table.cell>
                            <x-table.cell class="text-center">
                                <div class="flex justify-center gap-1">
                                    {{-- Tombol Lihat Detail - Menggunakan tag a --}}
                                    <a href="{{ route('user.show', $item->id) }}" 
                                       class="btn btn-info btn-xs p-1.5!" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    
                                    {{-- Tombol Hapus - Menggunakan tag a dengan data-modal-open --}}
                                    <a href="#" 
                                       class="btn btn-danger btn-xs p-1.5!" 
                                       title="Hapus Data"
                                       data-modal-open="deleteModal{{ $item->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <i class="bi bi-inbox text-3xl block mb-2"></i>
                                Belum ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </x-table>

            {{-- PAGINATION --}}
            @if (method_exists($users, 'links'))
                <x-pagination :paginator="$users" class="mt-3" />
            @endif

        </div>
    </div>

    <!-- ===== MODAL DELETE (Loop) ===== -->
    @foreach ($users as $item)
        <x-modal id="deleteModal{{ $item->id }}" size="sm" centered>
            <x-slot:header>
                <div class="flex items-center gap-2 text-red-600">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                    <span>Konfirmasi Hapus</span>
                </div>
            </x-slot:header>

            <div class="text-center py-4">
                <div class="text-5xl text-red-500 mb-4">
                    <i class="bi bi-trash"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                    Yakin ingin menghapus data ini?
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    {{ $item->name }}
                </p>
                <p class="text-sm text-red-500 dark:text-red-400 mt-2">
                    <i class="bi bi-exclamation-circle"></i> Data yang dihapus tidak dapat dikembalikan!
                </p>
            </div>

            <x-slot:footer>
                <div class="flex flex-wrap justify-end gap-2 w-full">
                    <x-button variant="secondary" data-modal-close>
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </x-button>
                    <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-button variant="danger" type="submit">
                            <i class="bi bi-trash me-1"></i> Ya, Hapus
                        </x-button>
                    </form>
                </div>
            </x-slot:footer>
        </x-modal>
    @endforeach

    <style>
        /* Style untuk badge role */
        .badge-primary {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 500;
        }
        .dark .badge-primary {
            background-color: rgba(59, 130, 246, 0.3);
            color: #93c5fd;
        }
        .badge-secondary {
            background-color: #e5e7eb;
            color: #374151;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 500;
        }
        .dark .badge-secondary {
            background-color: rgba(55, 65, 81, 0.5);
            color: #9ca3af;
        }
    </style>
@endsection