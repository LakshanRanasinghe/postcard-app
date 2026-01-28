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
    public $submitted = false;

    public function mount($id)
    {
        $this->cardId = $id;
    }

    public function getCardImageProperty()
    {
        $cards = [
            1 => 'images/option-1.png',
            2 => 'images/option-2.jpeg',
            3 => 'images/option-3.jpeg',
            4 => 'images/option-4.jpeg',
        ];

        return $cards[$this->cardId] ?? 'images/option-1.png';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'duration' => 'required',
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

<div class="flex w-full h-full p-8 md:p-12">
    {{-- Left Column: Image --}}
    <div class="w-1/2 pr-4 flex items-center justify-center">
        <div class="w-full h-full flex items-center justify-center">
            <img src="{{ asset($this->cardImage) }}" alt="Selected Card" class="object-contain max-h-[90%] max-w-[90%]">
        </div>
    </div>

    {{-- Right Column: Form or Success --}}
    <div class="w-1/2 flex flex-col justify-center pl-8 md:pl-12">
        <div class="w-full">
            @if($submitted)
                <div class="space-y-8 animate-fade-in">
                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold text-gray-900">Beste {{ $name }},</h2>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Bedankt voor je boodschap. Over <span class="font-semibold">{{ $duration }}</span> ontvang je
                            dit bericht als reminder automatisch in je inbox.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Wil je in de tussentijd meer weten, dan kun je altijd het persoonlijk overzicht checken.
                        </p>
                    </div>

                    <div class="pt-8 space-y-3">
                        <button wire:click="resetForm"
                            class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Terug naar start
                        </button>

                        <button type="button"
                            class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Persoonlijk overzicht
                        </button>
                    </div>
                </div>
            @else
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Vul jouw gegevens in</h2>

                <form wire:submit="submit" class="space-y-4">
                    {{-- Name --}}
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-medium text-gray-700">Naam:</label>
                        <input type="text" id="name" wire:model="name"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 p-2.5">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Emailadres:</label>
                        <input type="email" id="email" wire:model="email"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 p-2.5">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Message --}}
                    <div class="space-y-1">
                        <label for="message" class="block text-sm font-medium text-gray-700">Boodschap aan mijzelf:</label>
                        <textarea id="message" wire:model="message" rows="3"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 p-2.5"></textarea>
                        @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Duration --}}
                    <div class="space-y-2 pt-2">
                        <label class="block text-base font-medium text-gray-900">Dit bericht ontvang ik graag over:</label>
                        <div class="space-y-2">
                            @foreach(['1 maand', '2 maanden', '5 maanden', '7 maanden'] as $option)
                                <div class="flex items-center">
                                    <input type="radio" id="duration-{{ $loop->index }}" name="duration" value="{{ $option }}"
                                        wire:model="duration" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="duration-{{ $loop->index }}"
                                        class="ml-3 block text-sm font-medium text-gray-700">
                                        {{ $option }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('duration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 pb-2">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Versturen
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>