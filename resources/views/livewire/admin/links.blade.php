<div class="p-4">
    <div class="flex justify-between">
        <div class="2xl:ml-8 flex">
            <h1 class="text-4xl text-white">{{__('Content')}}</h1>
            <div class="flex items-center ml-4">
                <p class="text-white ml-8">Filter By Types: </p>
                <select class="form-control form-control-sm rounded ml-4 w-32" wire:model="selectedTypes">
                    <option selected value="">All</option>
                    <option value="ServerIP">Server IP</option>
                    <option value="Content">Content</option>
                </select>
            </div>
            <div class="flex items-center 2xl:ml-8 md:ml-2">
                <p class="text-white ml-8">Filter By Gamemodes: </p>
                <select class="form-control form-control-sm rounded ml-4 w-32" wire:model="selectedGamemodes">
                    <option selected value="">All</option>
                    <option value="TTT">Trouble in Terrorist Town V2</option>
                    <option value="Surf">Surf V2</option>
                    <option value="Deathrun">Deathrun</option>
                    <option value="Slender">Slender</option>
                    <option value="Sandbox">Sandbox</option>
                    <option value="PH">Prop Hunt X</option>
                </select>
            </div>
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
                    <th class="px-2 py-4 text-xl font-light">Types</th>
                    <th class="px-2 py-4 text-xl font-light">Gamemodes</th>
                    <th class="px-2 py-4 text-xl font-light">Link / IP</th>
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
                            <td>{!! $item->content2 !!}</td>
                            <td>{!! $item->content3 !!}</td>
                            <td>{{ \Carbon\Carbon::parse($item['updated_at'])->format('j F, Y') }}</td>
                            <td><x-jet-button wire:click="updateShowModal({{ $item->id }})" class="bg-blue-300 rounded items-center cursor-pointer hover:bg-blue-500 hover:shadow-lg transition-all px-3 py-2 text-white text-xl hover:scale-105"><i class="fas fa-pencil-alt"></i></x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{ $item->id }})" class="bg-red-500 rounded items-center cursor-pointer hover:bg-red-700 hover:shadow-lg transition-all px-3 py-2 text-white text-xl hover:scale-105"><i class="fas fa-trash-alt"></i></x-jet-danger-button></td>
                        </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="7" class="text-center">No results found</td>
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
                {{ __('New Links / IP') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <label>
                        <input class="form-radio" type="radio" value="ServerIP" wire:model="types"/>
                        <span class="ml-2 text-sm text-gray-600">Server IP</span>
                    </label>
                </div>
                <div class="mt-4">
                    <label>
                        <input class="form-radio" type="radio" value="Content" wire:model="types"/>
                        <span class="ml-2 text-sm text-gray-600">Server Contents</span>
                    </label>
                </div>
                <div class="mt-4">
                    <x-jet-label for="title" value="{{ __('Gamemodes') }}" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <select wire:model="gamemodes" class="flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            <option value="" selected>Pick the Gamemodes</option>
                            <option value="TTT">Trouble in Terrorist Town</option>
                            <option value="Surf">Surf</option>
                            <option value="Deathrun">Deathrun</option>
                            <option value="Slender">Slender</option>
                            <option value="Sandbox">Sandbox</option>
                            <option value="PH">Prop Hunt X</option>
                        </select>
                    </div>
                </div>
                @error('gamemodes') <span class="error text-red-500">{{ $message }}</span> @enderror
                <div class="mt-4">
                    <x-jet-label for="link" value="{{ __('Link') }}" />
                    <x-jet-input id="link" class="block mt-1 w-full" type="text" wire:model="link" />
                    @error('link') <span class="error text-red-500">{{ $message }}</span> @enderror
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
                    <x-jet-button class="ml-2" wire:click="check" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-jet-danger-button>
                @endif
            </x-slot>
        </x-jet-dialog-modal>
        
        <!-- The Delete Modal -->
        <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
            <x-slot name="title">
                {{ __('Delete News') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this News? Once this News is deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete News') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>