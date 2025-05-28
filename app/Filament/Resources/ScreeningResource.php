<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScreeningResource\Pages;
use App\Models\Screening;
use App\Models\Cinema;
use App\Models\Movie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;

class ScreeningResource extends Resource
{
    protected static ?string $model = Screening::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Cinema Selection
                Forms\Components\Select::make('cinema_id')
                    ->label('Cinema')
                    ->relationship('cinema', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('movie_id', null);
                        $set('starts_at', null);
                        $set('ends_at', null);
                    }),

                // Movie Selection
                Forms\Components\Select::make('movie_id')
                    ->label('Movie')
                    ->relationship('movie', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->visible(fn (callable $get) => $get('cinema_id')),

                // Start Time Selection
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Starts At')
                    ->required()
                    ->format('Y-m-d H:i')
                    ->minutesStep(5)
                    ->visible(fn (callable $get) => $get('movie_id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if (!$state || !$get('movie_id') || !$get('cinema_id')) {
                            return;
                        }

                        $startTime = Carbon::parse($state);
                        $cinema = Cinema::find($get('cinema_id'));
                        $movie = Movie::find($get('movie_id'));
                        
                        // Map English days to Latvian days
                        $dayMapping = [
                            'monday' => 'Pirmdiena',
                            'tuesday' => 'Otrdiena',
                            'wednesday' => 'Trešdiena',
                            'thursday' => 'Ceturtdiena',
                            'friday' => 'Piektdiena',
                            'saturday' => 'Sestdiena',
                            'sunday' => 'Svētdiena'
                        ];
                        
                        // Get Latvian day name
                        $dayOfWeek = $dayMapping[strtolower($startTime->format('l'))];
                        
                        // Check if cinema is open on this day
                        $operatingHour = $cinema->openingHours()
                            ->where('day_of_week', $dayOfWeek)
                            ->first();

                        if (!$operatingHour || !$operatingHour->opens_at) {
                            $set('validation_message', "Cinema is closed on {$dayOfWeek}");
                            $set('ends_at', null);
                            return;
                        }

                        // Check if screening starts during opening hours
                        $openingTime = Carbon::parse($operatingHour->opens_at)
                            ->setDateFrom($startTime);
                        $closingTime = Carbon::parse($operatingHour->closes_at)
                            ->setDateFrom($startTime);

                        if ($startTime->lt($openingTime)) {
                            $set('validation_message', "Cinema opens at {$operatingHour->opens_at->format('H:i')}");
                            $set('ends_at', null);
                            return;
                        }

                        // Calculate end time
                        $endTime = $startTime->copy()->addMinutes((int) $movie->duration_minutes);

                        // Check if movie ends before closing
                        if ($endTime->gt($closingTime)) {
                            $set('validation_message', "Movie must end before {$operatingHour->closes_at->format('H:i')}");
                            $set('ends_at', null);
                            return;
                        }

                        // Check for overlapping screenings (20min buffer)
                        $conflictingScreening = Screening::where('cinema_id', $get('cinema_id'))
                            ->where('id', '!=', $get('id'))
                            ->where(function ($query) use ($startTime, $endTime) {
                                $query->whereBetween('starts_at', [
                                    $startTime->copy()->subMinutes(20),
                                    $endTime->copy()->addMinutes(20)
                                ])
                                ->orWhereBetween('ends_at', [
                                    $startTime->copy()->subMinutes(20),
                                    $endTime->copy()->addMinutes(20)
                                ]);
                            })
                            ->exists();

                        if ($conflictingScreening) {
                            $set('validation_message', 'There must be at least 20 minutes between screenings');
                            $set('ends_at', null);
                            return;
                        }

                        // All validations passed
                        $set('ends_at', $endTime);
                        $set('validation_message', null);
                    }),

                // End Time Display
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Ends At')
                    ->format('Y-m-d H:i')
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                // Validation Message Display
                Forms\Components\TextInput::make('validation_message')
                    ->label('Validation Message')
                    ->hidden(fn (callable $get) => !$get('validation_message'))
                    ->disabled()
                    ->dehydrated(false)
                    ->extraAttributes(['class' => 'text-red-500']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cinema.name')
                    ->label('Cinema')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('movie.title')
                    ->label('Movie')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Starts At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Ends At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('starts_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScreenings::route('/'),
            'create' => Pages\CreateScreening::route('/create'),
            'edit' => Pages\EditScreening::route('/{record}/edit'),
        ];
    }
}