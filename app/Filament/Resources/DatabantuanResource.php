<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DatabantuanResource\Pages;
use App\Filament\Resources\DatabantuanResource\RelationManagers;
use App\Models\Databantuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DatabantuanResource extends Resource
{
    protected static ?string $model = Databantuan::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Jenis Bantuan';

    protected static ?string $modelLabel = 'Jenis Bantuan';

    protected static ?string $pluralLabel = 'Jenis Bantuan';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_bantuan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rincian_bantuan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tahun')
                    ->required(),
                Forms\Components\TextInput::make('jenjang')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_bantuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rincian_bantuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('jenjang')
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
            'index' => Pages\ListDatabantuans::route('/'),
            'create' => Pages\CreateDatabantuan::route('/create'),
            'edit' => Pages\EditDatabantuan::route('/{record}/edit'),
        ];
    }
}
