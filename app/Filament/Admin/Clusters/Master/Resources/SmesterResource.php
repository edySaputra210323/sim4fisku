<?php

namespace App\Filament\Admin\Clusters\Master\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Smester;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TahunAjaran;
use Filament\Resources\Resource;
use App\Filament\Admin\Clusters\Master;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Clusters\Master\Resources\SmesterResource\Pages;
use App\Filament\Admin\Clusters\Master\Resources\SmesterResource\RelationManagers;

class SmesterResource extends Resource
{
    protected static ?string $model = Smester::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Semester';

    protected static ?string $modelLabel = 'Semester';

    protected static ?string $pluralModelLabel = 'Semester';

    protected static ?string $slug = 'semester';

    protected static ?string $cluster = Master::class;

    public static function form(Form $form): Form
    {// Cek apakah ada tahun ajaran aktif
        $activeTahunAjaran = TahunAjaran::where('status', true)->first();
        $isTahunAjaranActive = !!$activeTahunAjaran;

        // Jika tidak ada tahun ajaran aktif, tampilkan notifikasi
        if (!$isTahunAjaranActive) {
            Notification::make()
                ->title('Peringatan')
                ->body('Tidak ada tahun ajaran yang aktif. Anda tidak dapat membuat semester sampai tahun ajaran diaktifkan.')
                ->warning()
                ->persistent()
                ->send();
        }

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Semester')
                    ->schema([
                        Forms\Components\Select::make('th_ajaran_id')
                            ->label('Tahun Ajaran')
                            ->required()
                            ->placeholder('Pilih Tahun Ajaran')
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                // Hanya ambil tahun ajaran yang aktif
                                return TahunAjaran::where('status', true)
                                    ->pluck('th_ajaran', 'id');
                            })
                            ->disabled(!$isTahunAjaranActive)
                            ->rules(['exists:tahun_ajaran,id']),
                        Forms\Components\TextInput::make('nm_smester')
                            ->label('Nama Semester')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ganjil atau Genap')
                            ->disabled(!$isTahunAjaranActive),
                        Forms\Components\DatePicker::make('periode_mulai')
                            ->label('Periode Mulai')
                            ->nullable()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->disabled(!$isTahunAjaranActive),
                        Forms\Components\DatePicker::make('periode_akhir')
                            ->label('Periode Akhir')
                            ->nullable()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->disabled(!$isTahunAjaranActive),
                        Forms\Components\Toggle::make('status')
                            ->label('Aktif')
                            ->default(false)
                            ->disabled(!$isTahunAjaranActive),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->recordAction(null)
            ->recordUrl(null)
            ->extremePaginationLinks()
            ->paginated([5, 10, 20, 50])
            ->defaultPaginationPageOption(10)
            ->striped()
            ->recordClasses(function () {
                $classes = 'table-vertical-align-top ';
                return $classes;
            })
            ->columns([
                Tables\Columns\TextColumn::make('tahunAjaran.th_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nm_smester')
                ->label('Semester')
                    ->searchable(),
                Tables\Columns\TextColumn::make('periode_mulai')
                    ->date('d/m/Y')
                    ->label('Periode Mulai'),
                Tables\Columns\TextColumn::make('periode_akhir')
                    ->date('d/m/Y')
                    ->label('Periode Akhir'),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status Aktif')
                    ->alignCenter()
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state) {
                            // Menonaktifkan tahun akademik lain
                            \App\Models\Smester::where('id', '!=', $record->id)
                                ->update(['status' => false]);
                        }
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->color('warning')
                    ->icon('heroicon-m-pencil-square'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Hapus Semester'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSmesters::route('/'),
            'create' => Pages\CreateSmester::route('/create'),
            'view' => Pages\ViewSmester::route('/{record}'),
            'edit' => Pages\EditSmester::route('/{record}/edit'),
        ];
    }
}
