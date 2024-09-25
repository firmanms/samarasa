<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DatasaranaResource\Pages;
use App\Filament\Resources\DatasaranaResource\RelationManagers;
use App\Models\Datasarana;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DatasaranaResource extends Resource
{
    protected static ?string $model = Datasarana::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Data Sarana';

    protected static ?string $modelLabel = 'Data Sarana';

    protected static ?string $pluralLabel = 'Data Sarana';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sekolahs_id')
                    ->label('Sekolah')
                    ->relationship('sekolah', 'nama_sekolah')
                    ->searchable()
                    // ->disabled(fn ($record) => $record ? $record->exists : false) // Menandai sebagai disabled jika record ada
                    ->preload()
                    ->live()
                    ->required(),
                Forms\Components\Textarea::make('perabotan')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('ape_dalam')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('ape_luar')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('media_pembelajaran')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('perabotan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ape_dalam')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ape_luar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('media_pembelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDatasaranas::route('/'),
            'create' => Pages\CreateDatasarana::route('/create'),
            'edit' => Pages\EditDatasarana::route('/{record}/edit'),
        ];
    }
}
