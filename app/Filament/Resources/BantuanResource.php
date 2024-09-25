<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanResource\Pages;
use App\Filament\Resources\BantuanResource\RelationManagers;
use App\Models\Bantuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BantuanResource extends Resource
{
    protected static ?string $model = Bantuan::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Data Penerima Bantuan';

    protected static ?string $modelLabel = 'Data Penerima Bantuan';

    protected static ?string $pluralLabel = 'Data Penerima Bantuan';

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
                Forms\Components\Select::make('databantuans_id')
                    ->label('Bantuan')
                    ->relationship('databantuan', 'nama_bantuan')
                    ->searchable()
                    // ->disabled(fn ($record) => $record ? $record->exists : false) // Menandai sebagai disabled jika record ada
                    ->preload()
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('tahun'),
                Forms\Components\Select::make('sumberdana')
                    ->label('Sumber Dana')
                    ->multiple()
                    ->options([
                        'APBD Murni' => 'APBD Murni',
                        'APBD Perubahan' => 'APBD Perubahan',
                        'APBD Provinsi Murni' => 'APBD Provinsi Murni',
                        'APBD Provinsi Perubahan' => 'APBD Provinsi Perubahan',
                        'DAK Pusat' => 'DAK Pusat',
                        'Cek Ulang' => 'Cek Ulang',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('databantuan.nama_bantuan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sumberdana')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
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
            'index' => Pages\ListBantuans::route('/'),
            'create' => Pages\CreateBantuan::route('/create'),
            'edit' => Pages\EditBantuan::route('/{record}/edit'),
        ];
    }
}
