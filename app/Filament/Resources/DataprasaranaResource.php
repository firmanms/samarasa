<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataprasaranaResource\Pages;
use App\Filament\Resources\DataprasaranaResource\RelationManagers;
use App\Models\Dataprasarana;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataprasaranaResource extends Resource
{
    protected static ?string $model = Dataprasarana::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Data Prasarana';

    protected static ?string $modelLabel = 'Data Prasarana';

    protected static ?string $pluralLabel = 'Data Prasarana';

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
                Forms\Components\TextInput::make('luas_tanah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status_kepemilikan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ruang_kelas')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('ruang_kepsek')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('ruang_guru')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('wc_guru')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('wc_siswa')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('meja_siswa')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('kursi_siswa')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('papan_tulis')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('komputer')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('luas_tanah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_kepemilikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ruang_kelas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ruang_kepsek')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ruang_guru')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wc_guru')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wc_siswa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('meja_siswa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kursi_siswa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('papan_tulis')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('komputer')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListDataprasaranas::route('/'),
            'create' => Pages\CreateDataprasarana::route('/create'),
            'edit' => Pages\EditDataprasarana::route('/{record}/edit'),
        ];
    }
}
