<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsulanResource\Pages;
use App\Filament\Resources\UsulanResource\RelationManagers;
use App\Models\Bantuan;
use App\Models\Usulan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsulanResource extends Resource
{
    protected static ?string $model = Usulan::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Usulan';

    protected static ?string $navigationLabel = 'Usulan Bantuan';

    protected static ?string $modelLabel = 'Usulan Bantuan';

    protected static ?string $pluralLabel = 'Usulan Bantuan';

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
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $bantuan = Bantuan::where('sekolahs_id', $state)->with('databantuan')->orderBy('tahun','asc')->get();
                            if ($bantuan->isEmpty()) {
                                $set('bantuan_list', 'Tidak ada riwayat bantuan'); // Pesan jika tidak ada data
                            } else {
                                $bantuanList = $bantuan->map(function ($item) {
                                    // Mengonversi sumber dana menjadi string jika merupakan array
                                    $sumberDanaString = is_array($item->sumberdana) ? implode(', ', $item->sumberdana) : $item->sumberdana;

                                    // Mengambil nama bantuan
                                    $namaBantuan = $item->databantuan ? $item->databantuan->nama_bantuan : 'N/A'; // Ganti 'N/A' dengan apa pun yang Anda inginkan

                                    return "{$item->tahun} - {$namaBantuan} - {$sumberDanaString} | ";
                                })->toArray();
                            $set('bantuan_list', implode("\n", $bantuanList));
                            }
                        } else {
                            $set('bantuan_list', ''); // Reset jika tidak ada sekolah yang dipilih
                        }
                    })
                    ->required(),

                Forms\Components\Textarea::make('bantuan_list')
                    ->readonly() // agar textarea hanya untuk tampil
                    ->rows(10)
                    ->label('Riwayat Data Bantuan')
                    ->default(fn ($get) => $get('bantuan_list') ?? ''),
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
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'process' => 'Proses',
                        'success' => 'Diterima',
                        'danger' => 'Ditolak',
                    ])
                    ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_approval'])),
                Forms\Components\Textarea::make('catatan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('tgl_usulan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_usulan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('databantuan.nama_bantuan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('sumberdana')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'process' => 'warning',
                        'success' => 'success',
                        'danger' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'process' => 'Proses',
                        'success' => 'Diterima',
                        'danger' => 'Ditolak',
                        default => 'Unknown',
                    }),
                Tables\Columns\TextColumn::make('catatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bantuan_list')
                    ->label('Riwayat Bantuan')
                    ->html()
                    ->limit(20)
                    ->tooltip(fn ($record) => strip_tags($record->bantuan_list))
                    ->sortable() // Menambahkan opsi untuk mengurutkan kolom
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsulans::route('/'),
            'create' => Pages\CreateUsulan::route('/create'),
            'edit' => Pages\EditUsulan::route('/{record}/edit'),
        ];
    }
}
