<?php

use Livewire\Component;
use App\Exports\PostcardsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Postcard;
use App\Models\PostcardEmailLog;
use App\Mail\SimpleMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;

new class extends Component {
    public $duration = '';

    #[Computed]
    public function availableDurations()
    {
        return Postcard::select('duration')->distinct()->pluck('duration');
    }

    #[Computed]
    public function postcards()
    {
        if (empty($this->duration)) {
            return collect();
        }
        return Postcard::with('emailLog')->where('duration', $this->duration)->get();
    }

    public function download()
    {
        return Excel::download(new PostcardsExport, 'postcards.xlsx');
    }

    public function sendEmails()
    {
        if (empty($this->duration)) {
            session()->flash('error', 'Please enter or select a duration first.');
            return;
        }

        $postcards = $this->postcards;

        if ($postcards->isEmpty()) {
            session()->flash('error', 'No postcards found for this duration.');
            return;
        }

        $sentCount = 0;
        foreach ($postcards as $postcard) {
            if (!$postcard->emailLog) {
                try {
                    Mail::to($postcard->email)->send(new SimpleMail($postcard));
                    PostcardEmailLog::create([
                        'postcard_id' => $postcard->id,
                        'email' => $postcard->email
                    ]);
                    $sentCount++;
                } catch (\Exception $e) {
                    \Log::error('Mail sending failed: ' . $e->getMessage());
                }
            }
        }

        session()->flash('success', "Process complete: {$sentCount} new emails sent out of {$postcards->count()} matching postcards.");
        
        // This forces livewire to re-evaluate the computed postcards so the status updates immediately
        unset($this->postcards); 
    }
};
?>

<div class="bg-white rounded-[2.5rem] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] flex flex-col w-full h-full p-8 md:p-12 lg:p-16 gap-10 overflow-hidden relative justify-center items-center">

    {{-- Logo Top Right --}}
    <div class="absolute top-0 right-8 md:right-12 z-20">
        <img src="{{ asset('rijksoverheid-logo.webp') }}" alt="Rijksoverheid Logo"
            class="h-16 md:h-34 w-auto opacity-80 mix-blend-multiply">
    </div>

    <div class="text-center space-y-8 animate-fade-up w-full max-w-4xl mx-auto">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-[#23568b] tracking-tight">
            Export & Mailing
        </h1>

        <p class="text-lg text-gray-700 mx-auto leading-relaxed max-w-2xl">
            Download alle postcard data als Excel bestand, of stuur een e-mail naar gebruikers door de duur (duration) te filteren.
        </p>

        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-6 justify-center items-center mt-8">
            <button wire:click="download"
                class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-[#23568b] hover:bg-[#1a4066] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#23568b] transition-all duration-300 shadow-xl cursor-pointer">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Excel
            </button>
        </div>

        <hr class="my-8 border-gray-200">

        <div class="flex flex-col gap-4 text-left bg-gray-50 p-6 rounded-2xl border border-gray-100">
            <label for="duration" class="font-medium text-gray-700">Filter op duur (Duration)</label>
            <div class="flex flex-col md:flex-row gap-4 w-full">
                <select id="duration" wire:model.live="duration" class="flex-1 rounded-xl border-gray-300 shadow-sm focus:border-[#23568b] focus:ring-[#23568b] py-3 px-4 bg-white">
                    <option value="">-- Select Duration --</option>
                    @foreach ($this->availableDurations as $dur)
                        <option value="{{ $dur }}">{{ $dur }}</option>
                    @endforeach
                </select>
            </div>
            <p class="text-sm text-gray-500">Alleen ansichtkaarten die overeenkomen met deze duur en nog geen e-mail hebben ontvangen, worden benaderd.</p>
        </div>

        @if($this->postcards->isNotEmpty())
        <div class="mt-8 overflow-x-auto w-full border border-gray-200 rounded-xl shadow-sm">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Duration</th>
                        <th scope="col" class="px-6 py-4">Mail Send Status</th>
                        <th scope="col" class="px-6 py-4">Submit Date</th>
                        <th scope="col" class="px-6 py-4">Mail Send Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->postcards as $pc)
                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $pc->name }}</td>
                        <td class="px-6 py-4">{{ $pc->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pc->duration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($pc->emailLog)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                    Sent
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="mr-1 h-3 w-3 text-yellow-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pc->created_at ? $pc->created_at->format('Y-m-d H:i') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pc->emailLog ? $pc->emailLog->created_at->format('Y-m-d H:i') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end w-full">
            <button wire:click="sendEmails" wire:loading.attr="disabled"
                class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-[#23568b] hover:bg-[#1a4066] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#23568b] transition-all duration-300 shadow-xl cursor-pointer disabled:opacity-50">
                <svg wire:loading.remove wire:target="sendEmails" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <svg wire:loading wire:target="sendEmails" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span wire:loading.remove wire:target="sendEmails">Send Emails to Filtered List</span>
                <span wire:loading wire:target="sendEmails">Sending...</span>
            </button>
        </div>
        @elseif(!empty($duration))
        <div class="mt-8 text-gray-500 italic">
            Geen ansichtkaarten gevonden voor de geselecteerde duur.
        </div>
        @endif
    </div>
</div>