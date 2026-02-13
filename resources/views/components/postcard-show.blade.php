<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Postcard;

new class extends Component {
    public $cardId;
    public $name;
    public $email;
    public $message;
    public $duration = '1 maand';
    public $consent = false;
    public $submitted = false;

    public function mount($id)
    {
        $this->cardId = $id;
    }

    public function getCardImageProperty()
    {
        $cards = [
            1 => 'images/option-1.png',
            2 => 'images/option-2.png',
            3 => 'images/option-3.png',
            4 => 'images/option-4.png',
        ];

        return $cards[$this->cardId] ?? 'images/option-1.png';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'nullable',
            'duration' => 'required',
            'consent' => 'accepted',
        ]);

        Postcard::create([
            'card_id' => $this->cardId,
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'duration' => $this->duration,
        ]);

        $this->submitted = true;
    }

    public function resetForm()
    {
        return redirect()->route('home');
    }
};
?>

<div
    class="bg-white rounded-[2.5rem] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] border border-gray-100 flex flex-col md:flex-row w-full h-full p-8 md:p-12 lg:p-16 gap-10 md:gap-16 overflow-hidden relative">

    {{-- Logo Top Right --}}
    <div class="absolute top-0 right-8 md:right-12 z-20">
        <img src="{{ asset('rijksoverheid-logo.webp') }}" alt="Rijksoverheid Logo"
            class="h-16 md:h-34 w-auto opacity-80 mix-blend-multiply">
    </div>

    {{-- Left Column: Image --}}
    <div
        class="w-full md:w-1/2 flex items-center justify-center order-2 md:order-1 p-4 md:p-8 bg-gray-50/50 rounded-[2rem]">
        <div class="relative group w-full max-w-[400px]">
            {{-- Card decoration --}}
            <div
                class="absolute inset-0 bg-white rounded-lg shadow-xl rotate-3 scale-105 opacity-40 transition-transform duration-500 group-hover:rotate-6 group-hover:scale-110">
            </div>
            <div
                class="absolute inset-0 bg-white rounded-lg shadow-xl -rotate-2 scale-105 opacity-40 transition-transform duration-500 group-hover:-rotate-4 group-hover:scale-110">
            </div>

            {{-- Main Image --}}
            <div
                class="relative bg-white p-3 rounded-lg shadow-2xl animate-fade-up transition-transform duration-500 group-hover:scale-[1.02]">
                <img src="{{ asset($this->cardImage) }}" alt="Selected Card"
                    class="w-full h-auto object-contain rounded-md">
            </div>
        </div>
    </div>

    {{-- Right Column: Form or Success --}}
    <div class="w-full md:w-1/2 flex flex-col justify-center order-1 md:order-2 pl-0">
        <div class="w-full max-w-lg mx-auto md:mx-0">
            @if($submitted)
                <div class="space-y-8 animate-fade-in">
                    <div class="space-y-4 mb-2">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-[#23568b] leading-tight mb-6">Beste
                            {{ $name }},
                        </h2>
                        <p class="text-lg text-gray-700 leading-relaxed font-sans">
                            Bedankt voor je boodschap. Over <span
                                class="font-semibold text-[#23568b]">{{ $duration }}</span>
                            ontvang je
                            dit bericht als reminder automatisch in je inbox.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed font-sans">
                            Wil je in de tussentijd meer weten, dan kun je altijd het persoonlijk overzicht checken.
                        </p>
                    </div>

                    <div class="pt-8 space-y-3 mb-2">
                        <button wire:click="resetForm" x-data="{ timeLeft: 25, timer: null }"
                            x-init="timer = setInterval(() => { if(timeLeft > 0) { timeLeft--; } else { clearInterval(timer); $wire.resetForm(); } }, 1000)"
                            class="w-full inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-full text-white bg-[#23568b] hover:bg-[#1a4066] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#23568b] transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 cursor-pointer">
                            Terug naar start (<span x-text="timeLeft"></span>s)
                        </button>

                        <!-- <a href="https://google.nl" target="_blank"
                                                                        class="group w-full inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-gray-200 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-[#23568b]/5 hover:border-[#23568b] hover:text-[#23568b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#23568b] transition-all duration-300 cursor-pointer transform hover:scale-[1.02] active:scale-[0.98] hover:shadow-md">
                                                                        Persoonlijk overzicht
                                                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-[#23568b] transition-colors" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                                        </svg>
                                                                    </a> -->

                        <div class="grid grid-cols-2 gap-8 mt-8">
                            <div class="flex flex-col items-center space-y-4 relative group">
                                <div
                                    class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 relative z-10 transition-transform duration-300 group-hover:scale-105">
                                    <img src="{{ asset('images/checklist_kind_krijgen.png') }}"
                                        alt="QR Code Checklist Kind Krijgen" class="w-32 h-32 object-contain">

                                    <!-- User Provided Arrow (Points Top-Left from bottom-right) -->
                                    <svg class="absolute -right-14 -bottom-6 w-16 h-16 text-[#23568b] transform -rotate-12 hidden md:block opacity-90"
                                        viewBox="0 0 473.654 473.654" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor">
                                        <path d="M143.386,111.189c27.011-17.31,54.018-34.625,81.029-51.939c2.891-1.855,5.688-1.249,7.632,0.471
                                                                    c1.687,1.088,2.887,2.921,2.887,5.55c0,11.286,0,22.572,0,33.858
                                                                    c81.47,3.841,145.372,69.122,146.958,151.221
                                                                    c1.608,83.594-70.248,149.852-151.415,151.415
                                                                    c-25.336,0.49-25.291-38.783,0-39.266
                                                                    c62.073-1.197,110.953-50.077,112.15-112.15
                                                                    c1.167-60.54-49.288-108.534-107.692-111.955
                                                                    c0,10.25,0,20.5,0,30.751
                                                                    c0,5.172-5.987,9.035-10.564,6.099
                                                                    c-27.011-17.31-54.018-34.625-81.029-51.939
                                                                    C138.794,120.396,138.869,114.087,143.386,111.189z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-lg font-medium text-center text-[#23568b] leading-tight block w-full px-2 max-w-[200px]">
                                    Persoonlijke overzicht bij het krijgen van een baby
                                </span>
                            </div>

                            <div class="flex flex-col items-center space-y-4 relative group">
                                <div
                                    class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 relative z-10 transition-transform duration-300 group-hover:scale-105">
                                    <img src="{{ asset('images/checklist_having_a_baby.png') }}"
                                        alt="QR Code Checklist Having a Baby" class="w-32 h-32 object-contain">

                                    <!-- User Provided Arrow (Points from right side) -->
                                    <svg class="absolute -right-14 -bottom-6 w-16 h-16 text-[#23568b] transform -rotate-12 hidden md:block opacity-90"
                                        viewBox="0 0 473.654 473.654" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor">
                                        <path d="M143.386,111.189c27.011-17.31,54.018-34.625,81.029-51.939c2.891-1.855,5.688-1.249,7.632,0.471
                                                                    c1.687,1.088,2.887,2.921,2.887,5.55c0,11.286,0,22.572,0,33.858
                                                                    c81.47,3.841,145.372,69.122,146.958,151.221
                                                                    c1.608,83.594-70.248,149.852-151.415,151.415
                                                                    c-25.336,0.49-25.291-38.783,0-39.266
                                                                    c62.073-1.197,110.953-50.077,112.15-112.15
                                                                    c1.167-60.54-49.288-108.534-107.692-111.955
                                                                    c0,10.25,0,20.5,0,30.751
                                                                    c0,5.172-5.987,9.035-10.564,6.099
                                                                    c-27.011-17.31-54.018-34.625-81.029-51.939
                                                                    C138.794,120.396,138.869,114.087,143.386,111.189z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-lg font-medium text-center text-[#23568b] leading-tight block w-full px-2 max-w-[200px]">
                                    Personal checklist having a baby
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h2 class="font-display text-3xl md:text-4xl font-bold tracking-tight text-[#23568b] mb-8">Vul jouw gegevens
                    in</h2>

                <form wire:submit="submit" class="space-y-6">
                    {{-- Name --}}
                    <div class="space-y-1 mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-500 ml-1">Naam</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="name" wire:model="name"
                                class="block w-full rounded-xl border-transparent bg-gray-50 pl-9 p-2.5 text-gray-900 shadow-sm transition-all duration-200 placeholder:text-gray-400 focus:bg-white hover:bg-white focus:border-[#23568b] focus:ring-[#23568b] focus:ring-1 text-sm">
                        </div>
                        @error('name') <span class="text-red-500 text-sm ml-1">Het naamveld is verplicht.</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1 mb-2">
                        <label for="email" class="block text-sm font-medium text-gray-500 ml-1">E-mailadres</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" wire:model="email"
                                class="block w-full rounded-xl border-transparent bg-gray-50 pl-9 p-2.5 text-gray-900 shadow-sm transition-all duration-200 placeholder:text-gray-400 focus:bg-white hover:bg-white focus:border-[#23568b] focus:ring-[#23568b] focus:ring-1 text-sm">
                        </div>
                        @error('email') <span class="text-red-500 text-sm ml-1">Het e-mailveld is verplicht.</span>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div class="space-y-1 mb-2">
                        <label for="message" class="block text-sm font-medium text-gray-500 ml-1">Boodschap aan
                            mijzelf (optioneel)</label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <textarea id="message" wire:model="message" rows="3"
                                class="block w-full rounded-xl border-transparent bg-gray-50 pl-9 p-2.5 text-gray-900 shadow-sm transition-all duration-200 placeholder:text-gray-400 focus:bg-white hover:bg-white focus:border-[#23568b] focus:ring-[#23568b] focus:ring-1 text-sm"></textarea>
                        </div>
                        @error('message') <span class="text-red-500 text-sm ml-1">Het boodschapveld is verplicht.</span>
                        @enderror
                    </div>

                    {{-- Duration --}}
                    <div class="space-y-3 pt-2">
                        <label class="block text-sm font-medium text-gray-500 ml-1">Dit bericht ontvang ik graag
                            over</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['1 maand', '2 maanden', '5 maanden', '7 maanden'] as $option)
                                <label class="cursor-pointer relative group">
                                    <input type="radio" value="{{ $option }}" wire:model="duration" class="peer sr-only">
                                    <div
                                        class="w-full text-center rounded-lg border border-gray-200 bg-white px-2 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all duration-200 hover:bg-[#23568b]/5 hover:border-[#23568b] hover:text-[#23568b] hover:shadow-md hover:scale-[1.02] peer-checked:border-[#23568b] peer-checked:bg-[#23568b] peer-checked:text-white peer-checked:shadow-md peer-focus:ring-2 peer-focus:ring-[#23568b] peer-focus:ring-offset-1">
                                        {{ $option }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('duration') <span class="text-red-500 text-sm ml-1">Het duurveld is verplicht.</span>
                        @enderror
                    </div>

                    {{-- Consent --}}
                    <div class="flex items-start pt-2">
                        <div class="flex h-5 items-center">
                            <input id="consent" wire:model="consent" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-theme focus:ring-theme">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="consent" class="font-medium text-gray-700">Ik geef toestemming dat mijn e-mail
                                adres eenmalig wordt gebruikt, daarna worden mijn gegevens verwijderd.</label>
                            @error('consent') <p class="text-red-500 text-xs mt-1">Het toestemmingveld is verplicht.</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-full shadow-lg text-sm font-semibold text-white bg-[#23568b] hover:bg-[#1a4066] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#23568b] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] hover:shadow-2xl">
                            Versturen
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>