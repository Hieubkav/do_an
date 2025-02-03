@extends('layouts.landing')

@section('content')
    <!-- Jumbo -->
    <div id='menu' class="bg-cover bg-center h-full text-white py-32 px-10 object-fill"
        style="background-image: url('https://img.freepik.com/free-vector/realistic-coffee-background_79603-1652.jpg?w=1060&t=st=1704622781~exp=1704623381~hmac=4804f733a66118f5b0080acdff1a6aa8077599baeaadcf0a488883f1f9829d01')">
        <div class="md:w-1/2">
            <p class="font-bold text-sm uppercase">Là Cafe</p>
            <p class="text-3xl font-bold">Cùng thức bên bạn chính Là Cafe</p>
            <p class="text-2xl mb-10 leading-none">Khám phá hương vị và câu chuyện của chúng tôi</p>
            <button data-popover-target="popover-bottom" data-popover-placement="bottom" type="button" id="menu_quan"
                class="bg-white text-gray-800 py-2 px-4 inline-block rounded hover:bg-gray-200">
                Menu quán
            </button>
            <div data-popover id="popover-bottom" role="tooltip"
                class="absolute z-30  inline-block w-5/6 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div
                    class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Menu nước</h3>
                </div>
                <div class="px-3 py-2 ">
                    <img src="https://scontent.fsgn5-10.fna.fbcdn.net/v/t39.30808-6/395319251_856205252960779_3334434163331120549_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=bd92f5&_nc_eui2=AeH3lt1egIb2N8AaQeqzlG8YGjNtl3bRNmYaM22XdtE2Zhd7PIbBckxQuab-AGXHamm36Un31Z5PCAS6atUqXp_l&_nc_ohc=NepTNU2TKxkAX_8mBq8&_nc_ht=scontent.fsgn5-10.fna&oh=00_AfDDsPFZLsnGTBo5Tv2m8O7YfzDiQTRPZsLBKnrTxFvG4g&oe=65A0DA7F"
                        alt="">
                </div>
                <div data-popper-arrow></div>
            </div>
            <a href="#story"
                class="bg-transparent border border-white text-white py-2 px-4 inline-block rounded hover:border-gray-200 hover:text-gray-200">Khám
                phá câu chuyện của chúng tôi</a>
        </div>
    </div>

    <!-- Accordion - Flowbite -->
    <div id="accordion-open" data-accordion="open" class="my-10 mx-10">
        <h2 id="accordion-open-heading-1">
            <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 bg-yellow-300 hover:bg-yellow-400 dark:hover:bg-gray-800 gap-3"
                data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
                <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd"></path>
                    </svg>Giá nước khi uống mang đi?</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    Đồng giá 19,000 vnd nha khách!
                </p>

            </div>
        </div>
        <h2 id="accordion-open-heading-2">
            <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 bg-yellow-300 hover:bg-yellow-400 dark:hover:bg-gray-800 gap-3"
                data-accordion-target="#accordion-open-body-2" aria-expanded="false" aria-controls="accordion-open-body-2">
                <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd"></path>
                    </svg>Giờ đóng cửa của quán?</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-open-body-2" class="hidden" aria-labelledby="accordion-open-heading-2">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    Quán luôn mở cửa 24/24 nha khách
                </p>

            </div>
        </div>
        <h2 id="accordion-open-heading-3">
            <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 bg-yellow-300 hover:bg-yellow-400 dark:hover:bg-gray-800 gap-3"
                data-accordion-target="#accordion-open-body-3" aria-expanded="false" aria-controls="accordion-open-body-3">
                <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd"></path>
                    </svg>Về Coffe In The Box thì giá cả thế nào?</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-open-body-3" class="hidden" aria-labelledby="accordion-open-heading-3">
            <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    2 giờ đầu 50k và các giờ sau 20k nha
                </p>

            </div>
        </div>
    </div>

    <!-- Carousel -->
    <div id="default-carousel" class="relative mx-10" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://scontent.fsgn2-4.fna.fbcdn.net/v/t39.30808-6/373624159_823618609552777_5428678438496279460_n.jpg?stp=cp6_dst-jpg&_nc_cat=101&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeFYSVzWsrUdQG7ZcZbfpHQ3TCDJhAlxD7pMIMmECXEPutN9tYAeP42YmhbXINH8Dqid2ZoIA-72TQFmGp66iAAs&_nc_ohc=rRK2t3lxrqMAX-_-HWA&_nc_ht=scontent.fsgn2-4.fna&oh=00_AfCfxrA47J3Znb7Ung1LcsOkbjmKftIPjtBrDaknogYz1g&oe=65A399DBhttps://scontent.fsgn2-4.fna.fbcdn.net/v/t39.30808-6/373624159_823618609552777_5428678438496279460_n.jpg?stp=cp6_dst-jpg&_nc_cat=101&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeFYSVzWsrUdQG7ZcZbfpHQ3TCDJhAlxD7pMIMmECXEPutN9tYAeP42YmhbXINH8Dqid2ZoIA-72TQFmGp66iAAs&_nc_ohc=rRK2t3lxrqMAX-_-HWA&_nc_ht=scontent.fsgn2-4.fna&oh=00_AfCfxrA47J3Znb7Ung1LcsOkbjmKftIPjtBrDaknogYz1g&oe=65A399DB"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://scontent.fsgn2-7.fna.fbcdn.net/v/t39.30808-6/373626522_823618659552772_9137632929719361666_n.jpg?stp=cp6_dst-jpg&_nc_cat=108&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeH3pnAA819huNLEQu3VO4hfrkJQ_RUgW76uQlD9FSBbvjfujXUfa_v4UCbf4KsTgu8SPDU2in60Ii1kWGSx1S7W&_nc_ohc=_DVJ-SCPzB0AX9ggpU5&_nc_ht=scontent.fsgn2-7.fna&oh=00_AfCbZQcxCMjywx6QH7CpI-n45a4yo5gdCBN6Q-UFIkSz5w&oe=65A4B6F5"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 " alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://scontent.fsgn2-9.fna.fbcdn.net/v/t39.30808-6/374201726_823618589552779_3706667321537444198_n.jpg?stp=cp6_dst-jpg&_nc_cat=106&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeGqr7ysuoGONte_SMhGe5kJk44OlyPavqKTjg6XI9q-oilpYBEt9kPbyhINQYAfM3RcVDx3lvZzeC_c0omY71F5&_nc_ohc=sPikpSsuB0kAX835DLd&_nc_ht=scontent.fsgn2-9.fna&oh=00_AfDcUZXzU1Kt-InVY6VUNOxJ5t-Um2Rl09ObZ1tNdLQ6rw&oe=65A060AB"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://scontent.fsgn2-4.fna.fbcdn.net/v/t39.30808-6/373564913_823618776219427_4526120482981431380_n.jpg?stp=cp6_dst-jpg&_nc_cat=101&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeFwTOpzjl3TdAhTEZ_e8UNrEV2rIpmC1_IRXasimYLX8u1oe2FGZbkpMCxciYH2q3wp44-g2FL8G-FqlDk60l6a&_nc_ohc=df9-tLgDXw4AX_BHmdS&_nc_ht=scontent.fsgn2-4.fna&oh=00_AfDSOcvur8qUhyEdD77ahLo-KJ0Fh8JECJIMRMSbc8RfVg&oe=65A545FD"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://scontent.fsgn2-5.fna.fbcdn.net/v/t39.30808-6/373624290_823618669552771_1788210720282605589_n.jpg?stp=cp6_dst-jpg&_nc_cat=104&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeGURyqdzpkZwrWitEeDVtXkDCzP0UOTG64MLM_RQ5MbrqsZfr_5RQ0HM7z6A_MAxmXJdcCCG-tvCc8LYvvBKm0z&_nc_ohc=-W4V2iprDfkAX_tSqxH&_nc_ht=scontent.fsgn2-5.fna&oh=00_AfA-ioce9IiAvlxuPaTvS72En7p5uwhv76Sg7Ml85Nx3rw&oe=65A48D5F"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <!-- Gallery -->
    <p class="text-3xl font-semibold text-black text-center mt-10" id="picture">
        Một Số Hình Ảnh Của Quán
    </p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-10 mx-10">
        <div class="grid gap-4">

            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-9.fna.fbcdn.net/v/t39.30808-6/387165647_846338297280808_3708902853053210936_n.jpg?stp=cp6_dst-jpg&_nc_cat=102&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeG_LK2Kk-QPXtyVanyBlgnHedI-hySRB-d50j6HJJEH52sQAvXE4qJjayGmn8-9s_HiTkTlHLbl2QeIOV2ODC_U&_nc_ohc=EWN1TnU7EIYAX_0X6LA&_nc_ht=scontent.fsgn5-9.fna&oh=00_AfCkMPq0-7UUJr2bp3bfhJ4yGbvCpJvFyB6EVmQDcxZxQg&oe=65A08451"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-12.fna.fbcdn.net/v/t39.30808-6/382227660_836798861568085_1657223316177598717_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeEpb0NtXrbHPyJnzGdp5StWSCKieSnHxrFIIqJ5KcfGsclCzE8iLEPPvcT8Ne2IhORle_2XrHojm9gtxlVYlRoe&_nc_ohc=TAvFN0UoaikAX8UVMOo&_nc_ht=scontent.fsgn5-12.fna&oh=00_AfDzLGGV37OOZzo8L_iy4XC-A8rSY3b6XiIIgMbqBXx3Ug&oe=659FFF2D"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-8.fna.fbcdn.net/v/t39.30808-6/383078998_836798741568097_1232334322619054247_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeFEiR3U4VhhwKz7uAV8-tzD-zSbfs4WlRL7NJt-zhaVEn-DgocydGj_WG0QOBSV7EH2A9bNsZAFYUyonh1N238z&_nc_ohc=YlKUvAbzdQ0AX_gJvTx&_nc_ht=scontent.fsgn5-8.fna&oh=00_AfBwuQQR6EmRbAFZi0bCabmXQevrlzlRPRjTMcoBFB71BA&oe=65A056A7"
                    alt="">
            </div>
        </div>
        <div class="grid gap-4">
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-12.fna.fbcdn.net/v/t39.30808-6/375316944_826657532582218_486559245285240446_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeEqXxevaL6HVHCNcKg1tdZV6pH5yf8vA1jqkfnJ_y8DWKc6oEJ7ly_qWpqNWKGkQYmGVmWwzEM7cFiCnGxqa-o4&_nc_ohc=tcjbDd2_ewAAX_-4_bP&_nc_ht=scontent.fsgn5-12.fna&oh=00_AfBohvTt3vMMFuEQ5gZcyNh-MHilDKTwRz7-wIanVjQ4kw&oe=659FEA15"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-10.fna.fbcdn.net/v/t39.30808-6/385458743_840515294529775_3371771292761372872_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeEMkPYHWQ1CO28d4cz-ftbiPYdCuV_H2aE9h0K5X8fZoX9yW7DZVD0X8VRa0wMMjqhSzATit4trB6DeBq0PnWDH&_nc_ohc=wd_5yBIhHAwAX_6GEmI&_nc_ht=scontent.fsgn5-10.fna&oh=00_AfBmRpx0eYKEyK3ZEm9CWUpy--9OsiUZXQQDN1F2Rgv0uA&oe=65A13A60"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-10.fna.fbcdn.net/v/t1.15752-9/415107290_757933656225507_5193740330893344305_n.png?_nc_cat=107&ccb=1-7&_nc_sid=8cd0a2&_nc_eui2=AeH3pTVp-QGqbRbAm_tj_50UIsIwzgbkJ6ciwjDOBuQnp7yzXe_TzACv-_1u_UPmDTS67x2P0-i67sBoBCNjPV2c&_nc_ohc=rewaIVSomT0AX-VWU1Z&_nc_ht=scontent.fsgn5-10.fna&oh=03_AdQi_nx1Bf5g7USMzNMZP0Ebu2dJ_JHuPJs3nruhYdnHYQ&oe=65C2F049"
                    alt="">
            </div>
        </div>
        <div class="grid gap-4">
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-5.fna.fbcdn.net/v/t39.30808-6/354879658_781797573734881_7751148807914369867_n.jpg?stp=cp6_dst-jpg&_nc_cat=100&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeHarq0vqDUykc0hxWcty_cBuHVZ03do3VS4dVnTd2jdVD1LYPUUk_9iV6SQ3xjL8ptkDD2wdgKtVSXZw83ydrqm&_nc_ohc=8MUzs4lnrZ8AX-QujXq&_nc_ht=scontent.fsgn5-5.fna&oh=00_AfDWAPHCxwubkndKriiWjW_J24VuJtzApNJpwPMBEsUgNw&oe=65A15D2F"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-10.fna.fbcdn.net/v/t39.30808-6/375312902_826657572582214_8591094284478459166_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeHJAf7NY8dS3dWMfUD1hrHNoBGXsR6CO9mgEZexHoI72QYMo5z7aEE9MNAAKhAoEBKsQu89W0BvjsJ9BgLnWWiM&_nc_ohc=5xhduE2VzDIAX8iFRz4&_nc_ht=scontent.fsgn5-10.fna&oh=00_AfAVYSV_J_q-WFCKKvKScqhwuYmDWzXCV3dmniKzxzZyRg&oe=65A1304D"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-2.fna.fbcdn.net/v/t39.30808-6/374777127_824446656136639_3280175523209428759_n.jpg?stp=cp6_dst-jpg&_nc_cat=105&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeE5dvdDuvrnEXojKCb6dTQI7Eg4slPByA3sSDiyU8HIDV62Q9LrxPh6L96G7Fd7NvJ7P9Mv-Ezj03UoVTSI0Ija&_nc_ohc=y49h1T46MuEAX-Sk55Z&_nc_ht=scontent.fsgn5-2.fna&oh=00_AfAXylrUlYk8jqPeMvWf0Q19V-ssUqeyacNEAPDyIOdn0A&oe=65A12290"
                    alt="">
            </div>
        </div>
        <div class="grid gap-4">
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-10.fna.fbcdn.net/v/t39.30808-6/344940852_6254892291221388_1090366527658419853_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeEEkNRPe_zB1PRQCAl1J4lmmsgbIC7swWGayBsgLuzBYd_LWY3o-sNZkt--BRXuhUMGK6FUIPyMfsrvSMvoArrQ&_nc_ohc=HuM_R-y_LvIAX8UC4DT&_nc_ht=scontent.fsgn5-10.fna&oh=00_AfD2T1qa-N6yiMWNpi6ZecogjX-k8tqcHc2rSBNxlqHgaQ&oe=65A0095B"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-10.fna.fbcdn.net/v/t39.30808-6/373621869_823618656219439_4020240087791624680_n.jpg?stp=cp6_dst-jpg&_nc_cat=106&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeF89qRuCbGBJDo9hM4IgSboUylDYE3j9xNTKUNgTeP3E77Wn2ZAq4m4hKQhZbrVDs1RHmYXX4rQSQqosd5yx9iP&_nc_ohc=gu3WVNJnockAX-y5HS2&_nc_ht=scontent.fsgn5-10.fna&oh=00_AfB6yn92EuhuSxUjvhOacJ5bizUTlkH19v2Vo7FIEwelqQ&oe=65A0A662"
                    alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg"
                    src="https://scontent.fsgn5-2.fna.fbcdn.net/v/t39.30808-6/380662746_834492105132094_5523823707753430935_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=dd5e9f&_nc_eui2=AeGHlcU6Llipf9NK8KKhWSvb5rr7naWBcRTmuvudpYFxFKZKjdndNOSLpQmzil8zyMKsro082DfiaFRwAABPjHx2&_nc_ohc=VtcnzrOTTrMAX8TrATK&_nc_ht=scontent.fsgn5-2.fna&oh=00_AfAbKAlN9u7f2qjPK8YitMY9XmHn7b1TbiHUwrpR4NNmhw&oe=65A050A7"
                    alt="">
            </div>
        </div>
    </div>

    <!-- câu chuyện -->
    <p id="story"
        class="mx-10 mb-10 text-gray-500 first-letter:text-7xl first-letter:font-bold">
        Từ năm 1999, "Là Cafe" mở cửa lần đầu tại Long Xuyên, An Giang, với bao thử thách từ việc tiếp cận khách hàng đến
        xây dựng cơ sở hạ tầng. Đến năm 2023, cơ sở thứ hai tại Ninh Kiều, Cần Thơ ra đời, tiếp nối hành trình. Những khách
        hàng đã ủng hộ từ An Giang vẫn tiếp tục đồng hành, dù bước chân đã dẫn họ đến Cần Thơ. Quán cafe không chỉ dừng lại
        ở việc phục vụ đồ uống mà còn mở rộng thành không gian mở cửa 24/24 với box ngủ và phòng game, tạo nên điểm đến thân
        thuộc cho những tâm hồn yêu thích sự sáng tạo và kết nối. "Là Cafe" không chỉ là một quán cafe, mà còn là người bạn
        đồng hành, thức cùng bạn qua từng khó khăn, thử thách. Đó là hành trình của một không gian, nơi hội tụ của niềm đam
        mê, sự ủng hộ nồng nhiệt và tình yêu với hạt cà phê.
    </p>

    <!-- Video hướng dẫn -->
    <video class="w-3/4 h-auto mx-auto" controls>
        <source src="{{ asset('asset/local/video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
  
@endsection
