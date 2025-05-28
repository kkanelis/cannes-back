<?php

namespace App\Filament\Widgets;

use App\Models\Screening;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ScreeningCalendar extends Widget
{
    protected static string $view = 'filament.widgets.screening-calendar';

    public $week;
    public $screenings;

    public function mount(): void
    {
        $this->week = now()->startOfWeek();
        $this->loadScreenings();
    }

    public function nextWeek(): void
    {
        $this->week = Carbon::parse($this->week)->addWeek();
        $this->loadScreenings();
    }

    public function previousWeek(): void
    {
        $this->week = Carbon::parse($this->week)->subWeek();
        $this->loadScreenings();
    }

    protected function loadScreenings(): void
    {
        $startOfWeek = Carbon::parse($this->week)->startOfWeek();
        $endOfWeek = Carbon::parse($this->week)->endOfWeek();

        $screenings = Screening::with(['movie', 'cinema'])
            ->whereBetween('starts_at', [$startOfWeek, $endOfWeek])
            ->orderBy('starts_at')
            ->get();

        $this->screenings = collect($screenings)->groupBy(function ($screening) {
            return Carbon::parse($screening->starts_at)->format('l');
        });
    }

    public function editScreening(int $screeningId): void
    {
        redirect()->to("/admin/screenings/{$screeningId}/edit");
    }

    protected function getScreeningColor(Screening $screening): string
    {
        $today = Carbon::parse($screening->starts_at)->format('Y-m-d');
        $yesterday = Carbon::parse($screening->starts_at)->subDay()->format('Y-m-d');
        $tomorrow = Carbon::parse($screening->starts_at)->addDay()->format('Y-m-d');

        // Check for same movie in same cinema on consecutive days (blue)
        $hasConsecutiveDay = Screening::query()
            ->where('movie_id', $screening->movie_id)
            ->where('cinema_id', $screening->cinema_id)
            ->where('id', '!=', $screening->id)
            ->whereIn('starts_at', [$yesterday, $tomorrow])
            ->exists();

        if ($hasConsecutiveDay) {
            return 'blue';
        }

        // Check for same movie in same cinema on same day (red)
        $hasSameCinemaSameDay = Screening::query()
            ->where('movie_id', $screening->movie_id)
            ->where('cinema_id', $screening->cinema_id)
            ->where('id', '!=', $screening->id)
            ->whereDate('starts_at', $today)
            ->exists();

        if ($hasSameCinemaSameDay) {
            return 'red';
        }

        // Check for same movie in different cinema on same day (yellow)
        $hasDifferentCinemaSameDay = Screening::query()
            ->where('movie_id', $screening->movie_id)
            ->where('cinema_id', '!=', $screening->cinema_id)
            ->whereDate('starts_at', $today)
            ->exists();

        if ($hasDifferentCinemaSameDay) {
            return 'yellow';
        }

        return 'default';
    }

    protected function getViewData(): array
    {
        return [
            'screenings' => $this->screenings ?? collect(),
            'week' => Carbon::parse($this->week),
            'timeFormat' => 'H:i',
            'days' => [
                'Monday', 'Tuesday', 'Wednesday', 
                'Thursday', 'Friday', 'Saturday', 'Sunday'
            ],
            'getScreeningColor' => fn ($screening) => $this->getScreeningColor($screening)
        ];
    }
}