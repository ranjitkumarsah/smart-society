<x-filament::page>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">

        {{-- 🧍 Profile Info Card --}}
        <x-filament::card>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Personal Details</h2>

                @if (! $editing)
                    <x-filament::button icon="heroicon-o-pencil" wire:click="$set('editing', true)">
                        
                    </x-filament::button>
                @endif
            </div>

            @if ($editing)
                <div class="space-y-4">
                    {{ $this->form }}
                    <div class="flex justify-end gap-2 mt-4">
                        <x-filament::button color="gray" wire:click="$set('editing', false)">
                            Cancel
                        </x-filament::button>
                        <x-filament::button color="primary" wire:click="save">
                            Save
                        </x-filament::button>
                    </div>
                </div>
            @else
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div><strong>Name:</strong> {{ $user->name }}</div>
                    <div><strong>Email:</strong> {{ $user->email }}</div>
                    <div><strong>Phone:</strong> {{ $user->phone ?? '-' }}</div>
                </dl>
            @endif
        </x-filament::card>


        {{-- 🏢 Flat & Tower Info Card --}}
        <x-filament::card>
            <h2 class="text-xl font-semibold mb-4">Flat & Tower Details</h2>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><strong>Flat Number:</strong> {{ $user->flat->flat_no ?? '-' }}</div>
                <div><strong>Floor:</strong> {{ $user->flat->floor ?? '-' }}</div>
                <div><strong>Area:</strong> {{ $user->flat->area_sq_ft ?? '-' }}</div>
                <div><strong>Tower:</strong> {{ $user->flat->tower->tower_name ?? '-' }}</div>
            </dl>
        </x-filament::card>

        
    </div>
</x-filament::page>
