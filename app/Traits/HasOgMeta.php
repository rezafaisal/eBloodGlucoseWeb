<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

trait HasOgMeta
{
    public function ogMeta($invitation): array
    {
        $date = Carbon::parse($invitation->events[0]->event_date)->isoFormat('D MMMM Y');

        return [
            'title' => "{$invitation->detail->bride_nickname} & {$invitation->detail->groom_nickname} - " . config('app.name', 'Teman Momen'),
            'description' => "Akan diselenggarakan di {$invitation->events[0]->venue_name}, pada {$date}",
            'image' => $invitation->detail->cover_images[0]['url'] ?? asset('assets/og-default.png'),
            'url' => URL::full(),
        ];
    }
}
