<div class="p-4">
    <div class="flex justify-between">
        <div class="ml-8 flex">
            <h1 class="text-4xl text-white">{{__('Content')}}</h1>
            <div class="flex items-center ml-4">
                <p class="text-white ml-8">Filter By Teams: </p>
                <select class="form-control form-control-sm rounded ml-4" wire:model="selectedTypes">
                    <option selected value="">All</option>
                    <option value="Innocent">Innocent</option>
                    <option value="Traitor">Traitor</option>
                    <option value="Others">Others</option>
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
                    <th class="px-2 py-4 text-xl font-light">Roles</th>
                    <th class="px-2 py-4 text-xl font-light">Description</th>
                    <th class="px-2 py-4 text-xl font-light">Teams</th>
                    <th class="px-2 py-4 text-xl font-light">Gambar</th>
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
                            <td>{!! $item->content1 !!}</td>
                            <td>{!! $item->content2 !!}</td>
                            <td>{!! $item->content3 !!}</td>
                            <td class="w-60"><img src="{{ asset('storage/photos/'.$item->photos->file_path )}}" class="relative p-2"></td>
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
                {{ __('New Role') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-jet-label for="roles" value="{{ __('Roles') }}" />
                    <div class="flex mt-2"><p>Previous Roles : <span>{!! $roles !!}</span></p></div>
                    <div class="block w-full mt-5" wire:ignore>
                        <textarea id="roles" type="text" wire:model="roles"></textarea>
                    </div>
                    @error('roles') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <div class="flex mt-2"><p>Previous Description : <span>{!! $description !!}</span></p></div>
                    <div class="block w-full mt-5" wire:ignore>
                        <textarea id="description" type="text" wire:model="description">{!! $description !!}</textarea>
                    </div>
                    @error('description') <span class="error text-red-500"></span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="teams" value="{{ __('Teams') }}" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <select wire:model="teams" class="flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            <option value="" selected>Pick the Team</option>
                            <option value="Innocent">Innocent</option>
                            <option value="Traitor">Traitor</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                @error('teams') <span class="error text-red-500">{{ $message }}</span> @enderror
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
                {{ __('Delete Role') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this Role? Once this Role is deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete Role') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>

<script src="{{ ('ckeditor5/build/ckeditor.js') }}"></script>
<script>ClassicEditor
				.create( document.querySelector( '#roles' ), {
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'underline',
						'fontSize',
						'fontColor',
						'|',
						'indent',
						'outdent',
						'bulletedList',
						'numberedList',
						'link',
						'removeFormat',
						'|',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo'
					]
				},
				language: 'id',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:inline',
						'imageStyle:block',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells'
					]
				},
					licenseKey: '',
				} )
				.then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('roles', editor.getData());
            })
        })
				.catch( error => {
					console.error( 'Oops, something went wrong!' );
					console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
					console.warn( 'Build id: emnf9e39wpfy-90xfl1h2zvf' );
					console.error( error );
				} );
</script>
<script>ClassicEditor
				.create( document.querySelector( '#description' ), {
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'underline',
						'fontSize',
						'fontColor',
						'|',
						'indent',
						'outdent',
						'bulletedList',
						'numberedList',
						'link',
						'removeFormat',
						'|',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo'
					]
				},
				language: 'id',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:inline',
						'imageStyle:block',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells'
					]
				},
					licenseKey: '',
				} )
				.then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('description', editor.getData());
            })
        })
				.catch( error => {
					console.error( 'Oops, something went wrong!' );
					console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
					console.warn( 'Build id: emnf9e39wpfy-90xfl1h2zvf' );
					console.error( error );
				} );
</script>
