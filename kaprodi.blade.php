foreach ($service as &$s) {
            $dplDetails = [];
            foreach ($s['program']['dpl'] as $dpl) {
                $dpl['status'] = in_array($dpl['dpl_id'], array_column($s['dpl'], 'dpl_id')) ? "Y" : "N";
                $dplDetails[] = $dpl;
            }
            $s['program']['dpl'] = $dplDetails;
        }

@if(in_array($mahasiswa['program']['program']['status'], ['tutup', 'proses', 'selesai']))
                                <button class="cursor-not-allowed hidden md:block w-full px-7 py-2 group transition transform duration-700 bg-transparent hover:bg-orange-500 focus:bg-orange-500 border-[0.5px] hover:border-orange-500 focus:border-orange-500 rounded-lg focus:scale-95">
                                    <h1 class="text-[10px] sm:text-xs font-semibold transition transform duration-500 text-orange-500 group-hover:text-[#FFFFFF] group-focus:text-[#FFFFFF] uppercase">
                                        Dpl</h1>
                                </button>
                            @else
                                <button @click="isOpen = true"
                                        class="hidden md:block w-full px-7 py-2 group transition transform duration-700 bg-transparent hover:bg-orange-500 focus:bg-orange-500 border-[0.5px] hover:border-orange-500 focus:border-orange-500 rounded-lg focus:scale-95">
                                    <h1 class="text-[10px] sm:text-xs font-semibold transition transform duration-500 text-orange-500 group-hover:text-[#FFFFFF] group-focus:text-[#FFFFFF] uppercase">
                                        Dpl</h1>
                                </button>
                            @endif
                            

<div x-show="isOpen"
                                 x-transition:enter="transition duration-300 ease-out"
                                 x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                                 x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                                 x-transition:leave="transition duration-150 ease-in"
                                 x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                                 x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                                 class="fixed inset-0 z-20 overflow-y-auto bg-[#F5F7FA]"
                                 aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-center justify-center p-1 h-screen">
                                    <span aria-hidden="true"></span>

                                    <!-- Pembungkus -->
                                    <form action="/dashboard/kaprodi/detailprogram/pesertamendaftar/dpl/{{ $mahasiswa['id'] }}"
                                          method="POST" class="px-5">
                                        @csrf
                                        <div class="relative p-6 transition-all transform bg-white opacity-85 rounded-lg">
                                            <div class="pb-5 mx-4 overflow-y-scroll h-[18rem]">
                                                @foreach($mahasiswa['program']['dpl'] as $dpl)
                                                    <div class="grid gap-2 m-2">
                                                        <div class="flex items-center gap-3 mt-2 w-full py-5 px-5 md:px-10 border-[0.5px] bg-transparent border-[#B0B0B0] focus:border-[#1480EC] rounded-lg focus:outline-none focus:scale-[1.01]">
                                                            <input name="{{ $dpl['dpl_id'] }}"
                                                                   {{ $dpl['status'] === "Y" ? 'checked' : '' }} type="checkbox">
                                                            <div class="flex space-y-1 flex-col text-start">
                                                                <h1 class="text-gray-700 font-medium text-xs md:text-sm">
                                                                    {{ $dpl['dpl']['nama'] }}
                                                                    <span class="text-gray-400 font-normal">({{ $dpl['dpl']['nidn'] }})
                                                                        </span>
                                                                </h1>
                                                                <p class="text-gray-400 font-normal text-[10px] md:text-xs">
                                                                    {{ $dpl['dpl']['prodi']['nama'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Pembungkus Button -->
                                            <div class="flex justify-center gap-3 mt-6">
                                                <div class="sm:grow"></div>

                                                <button @click="isOpen = false"
                                                        class="flex px-5 md:px-10 py-1 md:py-2 group transition transform duration-700 border-[0.5px] border-[#B0B0B0] hover:bg-red-500 hover:border-red-500 focus:bg-red-500 focus:border-red-500 rounded-lg focus:scale-[.98]"
                                                        type="button">
                                                    <h1 class="text-[10px] md:text-xs font-bold transition transform duration-500 text-[#989898] group-hover:text-[#FFFFFF] group-focus:text-[#FFFFFF] uppercase">
                                                        Tidak</h1>
                                                </button>

                                                <button class="flex px-5 md:px-10 py-1 md:py-2 group transition transform duration-700 border-[0.5px] border-[#B0B0B0] hover:bg-blue-500 hover:border-blue-500 focus:bg-blue-500 focus:border-blue-500 rounded-lg focus:scale-[.98]"
                                                        type="submit">
                                                    <h1 class="text-[10px] md:text-xs font-bold transition transform duration-500 text-[#989898] group-hover:text-[#FFFFFF] group-focus:text-[#FFFFFF] uppercase">
                                                        Ya</h1>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
