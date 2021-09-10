</aside>
<x-app-layout>
    <!-- Main Contents Go Here -->
    <div class="bg-gray-500 md:pl-40 m-5 p-3"> 
        <!-- Title -->
        <div class="mx-auto">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center ml-14">
                        <h1 class="font-bold text-6xl text-yellow-400">
                            {{ __('News') }}
                        </h1>
                    </div>
                </div>
                <div class="ml-64 relative mt-3 mr-16">
                    <h2 class="text-yellow-400 text-xl">
                        <a href="{{ route('dashboard') }}" class="text-white">Home  </a>/ {{ __('News') }}
                    </h2>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 mt-16 overflow-hidden shadow-xl rounded bg-gray-900">
                    @livewire('admin.news')
        </div>
    </div>
</x-app-layout>
</div>