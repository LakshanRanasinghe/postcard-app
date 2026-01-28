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

<div class="flex w-full h-full p-8 md:p-12">
    {{-- Main Content Column (Images) - Approx 63% --}}
    <div class="w-[63%] pr-4 flex flex-col justify-center">
        <div class="grid grid-cols-2 gap-[10px] w-full">
            @php
                $cards = [
                    ['id' => 1, 'image' => 'images/option-1.png', 'title' => 'Option 1'],
                    ['id' => 2, 'image' => 'images/option-2.jpeg', 'title' => 'Option 2'],
                    ['id' => 3, 'image' => 'images/option-3.jpeg', 'title' => 'Option 3'],
                    ['id' => 4, 'image' => 'images/option-4.jpeg', 'title' => 'Option 4'],
                ];
            @endphp

            @foreach($cards as $card)
                <button wire:click="selectCard({{ $card['id'] }})"
                    class="group relative aspect-square w-full cursor-pointer border-2 border-transparent hover:border-primary-600 focus:outline-none {{ $selectedCard === $card['id'] ? 'ring-4 ring-primary-600 z-10' : '' }}">
                    <img src="{{ asset($card['image']) }}" alt="{{ $card['title'] }}"
                        class="absolute inset-0 w-full h-full transition-transform duration-300 group-hover:scale-[1.02]">

                    @if($selectedCard === $card['id'])
                        <div class="absolute top-3 right-3 bg-primary-600 text-white p-1.5 rounded-full shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    {{-- Sidebar Column (Text) - Approx 37% --}}
    <div class="w-[37%] flex flex-col justify-center pl-8 md:pl-12">
        <div class="w-full">
            <h1 class="text-3xl md:text-4xl font-medium text-black leading-tight mb-4">
                Kies jouw kaart <br>
                en ontvang <br>
                deze na een <br>
                door jou <br>
                gewenste <br>
                periode
            </h1>
        </div>
    </div>
</div>