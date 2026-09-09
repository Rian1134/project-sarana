@extends('layouts.admin')

@section('title')
    User
@endsection

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Data User</h1>
        </div>
        <div>
            <x-button href="{{ route('user.create') }}" variant="primary" class="gap-1">
                <i class="bi bi-plus-circle"></i> Tambah User
            </x-button>
        </div>
    </div>

    <x-card>
        <div class="p-4">
            <x-table bordered hover>
                <x-slot:head>
                    <tr class="bg-gray-800 text-white">
                        <x-table.heading class="text-white! text-center">No</x-table.heading>
                        <x-table.heading class="text-white!">Nama</x-table.heading>
                        <x-table.heading class="text-white!">Email</x-table.heading>
                        <x-table.heading class="text-white!">Role</x-table.heading>
                        <x-table.heading class="text-white! text-center">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                <tbody>
                    @forelse ($users as $no => $item)
                        <x-table.row>
                            <x-table.cell class="text-center font-bold">
                                {{ $no }}
                            </x-table.cell>
                            <x-table.cell>{{ $item->name }}</x-table.cell>
                            <x-table.cell>{{ $item->email }}</x-table.cell>
                            <x-table.cell>
                                @if($item->getRoleNames()->isNotEmpty())
                                    <x-badge variant="primary">
                                        {{ $item->getRoleNames()->first() }}
                                    </x-badge>
                                @else
                                    <x-badge variant="secondary">User</x-badge>
                                @endif
                            </x-table.cell>
                            <x-table.cell class="text-center">
                                <div class="flex justify-center gap-1">
                                    <x-button 
                                        href="{{ route('user.show', $item->id) }}" 
                                        variant="info" 
                                        size="xs" 
                                        class="p-1.5"
                                        title="Lihat Detail"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                    </x-button>
                                    
                                    <x-button 
                                        href="{{ route('user.edit', $item->id) }}" 
                                        variant="warning" 
                                        size="xs" 
                                        class="p-1.5"
                                        title="Edit Data"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </x-button>
                                    
                                    <x-button 
                                        variant="danger" 
                                        size="xs" 
                                        class="p-1.5"
                                        data-modal-open="deleteModal{{ $item->id }}"
                                        title="Hapus Data"
                                    >
                                        <i class="bi bi-trash-fill"></i>
                                    </x-button>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.empty colspan="5" message="Belum ada data user." />
                    @endforelse
                </tbody>
            </x-table>

            {{-- PAGINATION --}}
            @if (method_exists($users, 'links'))
                <div class="mt-4">
                    <x-pagination :paginator="$users" />
                </div>
            @endif
        </div>
    </x-card>

    <!-- ===== MODAL DELETE (Loop) ===== -->
    @foreach ($users as $item)
        <x-modal id="deleteModal{{ $item->id }}" size="sm" centered>
            <x-slot:header>
                <div class="flex items-center gap-2 text-red-600">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                    <span class="font-semibold">Konfirmasi Hapus</span>
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
                    <x-button variant="secondary" data-modal-close class="gap-1">
                        <i class="bi bi-x-circle"></i> Batal
                    </x-button>
                    <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-button variant="danger" type="submit" class="gap-1">
                            <i class="bi bi-trash"></i> Ya, Hapus
                        </x-button>
                    </form>
                </div>
            </x-slot:footer>
        </x-modal>
    @endforeach
@endsection