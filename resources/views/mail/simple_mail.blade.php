<x-mail::message>
Beste {{ !empty($postcard->name) ? explode(' ', trim($postcard->name))[0] : 'aanstaande ouder' }},

@php
    $duration = strtolower(trim($postcard->duration ?? ''));
    $isTwoMonths = in_array($duration, ['1', '2', '1 month', '2 months', '1 maand', '2 maanden']);
@endphp
@if($isTwoMonths)
2 maanden geleden was je op de negen maanden beurs. Je hebt toen een reminder ingesteld, die we je hierbij graag toesturen.
@else
{{ str_replace(['month', 'months'], ['maand', 'maanden'], $postcard->duration ?? '') }} geleden was je op de negen maanden beurs. Je hebt toen een reminder ingesteld, die we je hierbij graag toesturen.
@endif

Of je nu voor de eerste keer ouder wordt of al één of meer kinderen hebt; er zal een hoop veranderen als er een kindje op komst is. Veel aanstaande ouders hebben vragen over wat ze allemaal met de overheid moeten regelen. Maar ook waar ze als ouders recht op hebben. Hoeveel recht op ouderschapsverlof heb ik? Wanneer moet ik mijn kind erkennen? En wat heb ik te zeggen over de achternaam van mijn kind? Het is gelukkig allemaal niet zo ingewikkeld, maar het is wel fijn om veel dingen op tijd te regelen of te checken waar je recht op hebt.

<div style="text-align: center; margin: 20px 0;">
    <img src="{{ url('images/option-' . ($postcard->card_id ?? 1) . '.png') }}" alt="Gekozen Kaart" style="max-width: 100%; border-radius: 8px;">
</div>

@if(!empty(trim($postcard->message ?? '')))
Dit is de boodschap die je voor jezelf achterliet: 
> _{{ $postcard->message }}_
@endif

Op rijksoverheid.nl/kindkrijgen krijg je dus gemakkelijk overzicht gebaseerd op jouw situatie. Zo krijg je alles wat je moet weten én regelen met de overheid handig op een rij.

Succes met de voorbereiding.<br>
Vriendelijke groet,<br>
Rijksoverheid
</x-mail::message>
