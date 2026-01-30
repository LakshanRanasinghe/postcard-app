<?php

use Livewire\Component;
use App\Exports\PostcardsExport;
use Maatwebsite\Excel\Facades\Excel;

new class extends Component {
    public function download()
    {
        return Excel::download(new PostcardsExport, 'postcards.xlsx');
    }
};
?>

<div
    class="bg-white rounded-[2.5rem] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] border border-gray-100 flex flex-col md:flex-row w-full h-full p-8 md:p-12 lg:p-16 gap-10 md:gap-16 overflow-hidden relative justify-center items-center">

    {{-- Logo Top Right --}}
    <div class="absolute top-0 right-8 md:right-12 z-20">
        <img src="{{ asset('rijksoverheid-logo.png') }}" alt="Rijksoverheid Logo"
            class="h-16 md:h-34 w-auto opacity-80 mix-blend-multiply">
    </div>

    <div class="text-center space-y-8 animate-fade-up">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-[#23568b] tracking-tight">
            Download overzicht
        </h1>

        <p class="text-lg text-gray-700 max-w-lg mx-auto leading-relaxed">
            Klik op de onderstaande knop om alle postcard data te downloaden als Excel bestand.
        </p>

        <button wire:click="download"
            class="inline-flex items-center justify-center px-8 py-5 border border-transparent text-lg font-semibold rounded-full text-white bg-[#23568b] hover:bg-[#1a4066] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#23568b] transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download Excel
        </button>
    </div>
</div>