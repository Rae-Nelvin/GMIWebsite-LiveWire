<div class="container mx-auto">
    <!-- Start Website Contents -->
    <div class="bg-gray-200 p-4 rounded 2xl:ml-2 w-2/3 md:ml-48">
        <!-- Title -->
        <div class="mb-1">
            <h1 class="text-black text-4xl font-normal">Website Contents</h1>
        </div>
        <!-- Line -->
        <div class="bg-gray-600 pt-px mb-8"></div>
        <!-- Start of Swiper -->
        <div class="swiper">
            <!-- Start of Swiper - Wrapper -->
            <div class="grid grid-cols-4 rounded swiper-wrapper">
                <!-- Start Swiper - slide 1 -->
                <div class="bg-green-500 rounded-md swiper-slide">
                    <div class="justify-between flex">
                        <div class="text-white">
                            <h1 class="2xl:text-3xl pt-4 pl-4 md:text-xl">Galleries <br />
                            {{ $galleries->count() }} </h1>
                        </div>
                        <div class="mt-4 mr-4 ">
                            <i class="far fa-images 2xl:text-5xl text-black text-opacity-25 md:text-4xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('galleries') }}"><div class="bg-green-600 hover:bg-green-800 transition-all 2xl:mt-12 md:mt-4 pt-2 2xl:pb-1 text-center rounded-b-md text-white cursor-pointer">
                        <h1 class="md:text-sm 2xl:text-base">More info <i class="fas fa-arrow-circle-right"></i></h1>
                    </div></a>
                </div>
                <!-- End of Swiper - slide 1 -->
                <!-- Start of Swiper - slide 2 -->
                <div class="bg-blue-500 rounded-md swiper-slide">
                    <div class="justify-between flex">
                        <div class="text-white">
                            <h1 class="2xl:text-3xl pt-4 pl-4 md:text-xl">News <br />
                            {{ $news->count() }}</h1>
                        </div>
                        <div class="mt-4 mr-4 ">
                            <i class="far fa-newspaper 2xl:text-5xl text-black text-opacity-25 md:text-4xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('news') }}"><div class="bg-blue-600 hover:bg-blue-800 transition-all 2xl:mt-12 md:mt-4 pt-2 2xl:pb-1 text-center rounded-b-md text-white cursor-pointer">
                        <h1 class="md:text-sm 2xl:text-base">More info <i class="fas fa-arrow-circle-right"></i></h1>
                    </div></a>
                </div>
                <!-- End of Swiper - slide 2 -->
                <!-- Start of Swiper - slide 3 -->
                <div class="bg-red-500 rounded-md swiper-slide">
                    <div class="justify-between flex">
                        <div class="text-white">
                            <h1 class="2xl:text-xl pt-4 pl-4 md:text-sm md:mb-2">Admin & Staff <br />
                            {{ $admins->count() }}</h1>
                        </div>
                        <div class="mt-4 mr-4 ">
                            <i class="fas fa-users-cog 2xl:text-5xl text-black text-opacity-25 md:text-4xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('admins') }}"><div class="bg-red-600 hover:bg-red-800 transition-all 2xl:mt-14 md:mt-6 pt-2 2xl:pb-1 text-center rounded-b-md text-white cursor-pointer">
                        <h1 class="md:text-sm 2xl:text-base">More info <i class="fas fa-arrow-circle-right"></i></h1>
                    </div></a>
                </div>
                <!-- End of Swiper - slide 3 -->
                <!-- Start of Swiper - slide 4 -->
                <div class="bg-yellow-500 rounded-md swiper-slide">
                    <div class="justify-between flex">
                        <div class="text-white">
                            <h1 class="2xl:text-3xl pt-4 pl-4 md:text-xl">Links & IP <br />
                            {{ $links->count() }}</h1>
                        </div>
                        <div class="mt-4 mr-4 ">
                            <i class="fas fa-link 2xl:text-5xl text-black text-opacity-25 md:text-4xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('links') }}"><div class="bg-yellow-600 hover:bg-yellow-800 transition-all 2xl:mt-12 md:mt-4 pt-2 2xl:pb-1 text-center rounded-b-md text-white cursor-pointer">
                        <h1 class="md:text-sm 2xl:text-base">More info <i class="fas fa-arrow-circle-right"></i></h1>
                    </div></a>
                </div>
                <!-- End of Swiper - slide 4 -->
                <!-- Start of Swiper - slide 5 -->
                <div class="bg-purple-500 rounded-md swiper-slide">
                    <div class="justify-between flex">
                        <div class="text-white">
                            <h1 class="2xl:text-xl pt-4 pl-4 md:text-l md:mb-2">TTT V2 Roles <br />
                            {{ $roles->count() }}</h1>
                        </div>
                        <div class="mt-4 mr-4 ">
                            <i class="fas fa-user-tag 2xl:text-5xl text-black text-opacity-25 md:text-4xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('TTTRoles') }}"><div class="bg-purple-600 hover:bg-purple-800 transition-all 2xl:mt-14 md:mt-4 pt-2 2xl:pb-1 text-center rounded-b-md text-white cursor-pointer">
                        <h1 class="md:text-sm 2xl:text-base">More info <i class="fas fa-arrow-circle-right"></i></h1>
                    </div></a>
                </div>
                <!-- End of Swiper -slide 5 -->
            </div>
            <!-- End of Swiper - wrapper -->
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <!-- End of Swiper -->
    </div>
    <!-- End of Website Contents -->
</div>