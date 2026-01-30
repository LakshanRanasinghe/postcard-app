<?php

use Livewire\Component;

new class extends Component {
    public $selectedCard = null;

    public function selectCard($cardId)
    {
        return redirect()->route('postcard.show', ['id' => $cardId]);
    }
};
?>

<div
    class="bg-white rounded-[2.5rem] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] border border-gray-100 flex flex-col md:flex-row w-full h-full p-8 md:p-12 lg:p-16 gap-10 md:gap-16 overflow-hidden relative">

    {{-- Logo Top Right --}}
    <div class="absolute top-0 right-8 md:top-0 md:right-12 z-20">
        <img src="{{ asset('rijksoverheid-logo.png') }}" alt="Rijksoverheid Logo"
            class="h-16 md:h-34 w-auto opacity-80 mix-blend-multiply">
    </div>

    {{-- Main Content Column (Images) --}}
    <div class="w-full md:w-[60%] flex flex-col justify-center order-2 md:order-1">
        <div class="grid grid-cols-2 gap-5 w-full max-w-xl mx-auto md:ml-0">
            @php
                $cards = [
                    ['id' => 1, 'image' => 'images/option-1.png', 'title' => 'Option 1'],
                    ['id' => 2, 'image' => 'images/option-2.jpeg', 'title' => 'Option 2'],
                    ['id' => 3, 'image' => 'images/option-3.jpeg', 'title' => 'Option 3'],
                    ['id' => 4, 'image' => 'images/option-4.jpeg', 'title' => 'Option 4'],
                ];
            @endphp

            @foreach($cards as $card)
                <button wire:click="selectCard({{ $card['id'] }})" style="animation-delay: {{ $loop->index * 100 }}ms"
                    class="group relative aspect-square w-full cursor-pointer rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-xl hover:-translate-y-1 focus:outline-none ring-offset-2 focus:ring-2 focus:ring-[#23568b] animate-fade-up">
                    <div class="absolute inset-0 bg-gray-50">
                        <img src="{{ asset($card['image']) }}" alt="{{ $card['title'] }}"
                            class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                    </div>

                    {{-- Hover Overlay --}}
                    <div class="absolute inset-0 bg-[#23568b]/0 group-hover:bg-[#23568b]/5 transition-colors duration-300">
                    </div>

                    @if($selectedCard === $card['id'])
                        <div class="absolute inset-0 ring-4 ring-[#23568b] ring-inset rounded-3xl z-10"></div>
                        <div
                            class="absolute top-3 right-3 bg-[#23568b] text-white p-2 rounded-full shadow-lg z-20 animate-in fade-in zoom-in duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    {{-- Sidebar Column (Text) --}}
    <div
        class="w-full md:w-[40%] flex flex-col justify-center pl-0 md:pl-4 lg:pl-6 order-1 md:order-2 text-center md:text-left relative z-10">
        <div class="w-full">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50/50 border border-blue-100 mb-6 animate-fade-up"
                style="animation-delay: 300ms">
                <span class="w-2 h-2 rounded-full bg-[#23568b]"></span>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#23568b]/80">Rijksoverheid</span>
            </div>

            <h1 class="font-display text-3xl md:text-4xl font-bold text-black leading-[1.1] mb-6 tracking-tight animate-fade-up"
                style="animation-delay: 500ms">
                Kies jouw kaart <br>
                en ontvang <br>
                deze na een <br>
                door jou <br>
                gewenste <br>
                periode
            </h1>

            {{-- Decorative element --}}
            <div
                class="hidden md:block absolute -top-20 -left-20 w-64 h-64 bg-yellow-50 rounded-full blur-3xl opacity-60 -z-10 mix-blend-multiply">
            </div>
        </div>
    </div>
</div>