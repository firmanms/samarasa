<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Data Sekolah';

    protected static ?string $modelLabel = 'Data Sekolah';

    protected static ?string $pluralLabel = 'Data Sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('npsn')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_sekolah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('bentuk')
                    ->required()
                    ->options(
                        ['Kesetaraan' => 'Kesetaraan',
                        'KB' => 'KB',
                        'PKBM' => 'PKBM',
                        'SD' => 'SD',
                        'SKB' => 'SKB',
                        'SMP' => 'SMP',
                        'SPS' => 'SPS',
                        'TK' => 'TK',
                        'TPA' => 'TPA',
                    ])
                    ->label('Bentuk'),
                Forms\Components\Select::make('jenjang')
                ->required()
                ->options(
                    ['Kesetaraan' => 'Kesetaraan',
                    'PAUD' => 'PAUD',
                    'SD' => 'SD',
                    'SMP' => 'SMP',
                    'SMA' => 'SMA',
                    'SMK' => 'SMK',
                ])
                ->label('Jenjang'),
                Forms\Components\Select::make('status')
                ->required()
                ->options([
                    'Negeri' => 'Negeri',
                    'Swasta' => 'Swasta',
                ])
                ->label('Status'),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('desa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kepsek')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('nip')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bentuk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenjang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_kepsek')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}
