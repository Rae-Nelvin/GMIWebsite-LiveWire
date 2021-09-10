<div class="p-4">
    <div class="flex justify-between">
        <div class="2xl:ml-8">
            <h1 class="text-4xl text-white">{{__('Content')}}</h1>
        </div>
        <div class="text-white bg-yellow-400 rounded items-center py-1 px-6 cursor-pointer hover:bg-yellow-500 hover:scale-105 hover:shadow-lg transition-all">
            <a class="text-xl font-semibold" wire:click="createShowModal"><span class="font-bold text-2xl">+</span> Add New</a>
        </div>
    </div>
    <div class="mt-3">
        <table class="table-auto min-w-full text-center overflow-hidden rounded-lg">
            <thead class="bg-gray-600">
                <tr class="text-white">
                    <th class="px-2 py-4 text-xl font-light">#</th>
                    <th class="px-2 py-4 text-xl font-light">Real Name</th>
                    <th class="px-2 py-4 text-xl font-light">Steam Name</th>
                    <th class="px-2 py-4 text-xl font-light">Social Media</th>
                    <th class="px-2 py-4 text-xl font-light">Role</th>
                    <th class="px-2 py-4 text-xl font-light">Photo</th>
                    <th wire:click="sortBy('updated_at')" class="px-2 py-4 text-xl font-light cursor-pointer">Last Update
                    @include('partials._sort-icon',['field'=>'updated_at'])</th>
                    <th class="px-2 py-4 text-xl font-light">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if ($data->count())
                    @foreach ($data as $item)
                        <tr class="text-black">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->content1 }}</td>
                            <td>{{ $item->content2 }}</td>
                            <td>{{ $item->content3 }}</td>
                            <td>{{ $item->content4 }}</td>
                            <td class="w-60"><img src="{{ asset('storage/photos/'.$item->photos->file_path )}}" class="relative p-2"></td>
                            <td>{{ \Carbon\Carbon::parse($item['updated_at'])->format('j F, Y') }}</td>
                            <td><x-jet-button wire:click="updateShowModal({{ $item->id }})" class="bg-blue-300 rounded items-center cursor-pointer hover:bg-blue-500 hover:shadow-lg transition-all px-3 py-2 text-white text-xl hover:scale-105"><i class="fas fa-pencil-alt"></i></x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{ $item->id }})" class="bg-red-500 rounded items-center cursor-pointer hover:bg-red-700 hover:shadow-lg transition-all px-3 py-2 text-white text-xl hover:scale-105"><i class="fas fa-trash-alt"></i></x-jet-danger-button></td>
                        </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="8" class="text-center">No results found</td>
                        </tr>
                @endif
            </tbody>
        </table>
    </div>
    <br />
    {{ $data->links() }}

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                {{ __('New Admins') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-jet-label for="steamName" value="{{ __('Steam Name') }}" />
                    <x-jet-input id="steamName" class="block mt-1 w-full" type="text" wire:model="steamName" />
                    @error('steamName') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="realName" value="{{ __('Real Name') }}" />
                    <x-jet-input id="realName" class="block mt-1 w-full" type="text" wire:model="realName" />
                    @error('realName') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="socialMedia" value="{{ __('Social Media') }}" />
                    <x-jet-input id="socialMedia" class="block mt-1 w-full" type="text" wire:model="socialMedia" />
                    @error('socialMedia') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="role" value="{{ __('Role') }}" />
                    <x-jet-input id="role" class="block mt-1 w-full" type="text" wire:model="role" />
                    @error('role') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="photos" value="{{ __('Photos') }}" />
                    <x-jet-input class="block mt-1 w-full" type="file" wire:model="photos" name="attachment" id="upload{{ $iteration }}"/>
                    @error('photos') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                @if ($modelId)
                    <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-jet-danger-button>
                @else
                    <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-jet-danger-button>
                @endif 
            </x-slot>
        </x-jet-dialog-modal>
        
        <!-- The Delete Modal -->
        <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
            <x-slot name="title">
                {{ __('Delete Admin') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this Admin? Once this Admin is deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete Admin') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>
