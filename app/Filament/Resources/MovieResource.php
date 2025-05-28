<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Models\Movie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('summary')
                    ->required()
                    ->maxLength(65535),
                TextInput::make('director')
                    ->required()
                    ->maxLength(255),
                TextInput::make('year')
                    ->required(),
                TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                TextInput::make('duration_minutes')
                    ->required(),
                TextInput::make('poster_url')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('director')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('country')
                    ->searchable(),
                TextColumn::make('duration_minutes')
                    ->label('Duration (min)')
                    ->sortable(),
                ImageColumn::make('poster_url')
                    ->label('Poster')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
