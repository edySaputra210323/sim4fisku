<?php

namespace App\Filament\Admin\Clusters\Master\Resources;

use stdClass;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TahunAjaran;
use Filament\Resources\Resource;
use App\Filament\Admin\Clusters\Master;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Clusters\Master\Resources\TahunAjaranResource\Pages;
use App\Filament\Admin\Clusters\Master\Resources\TahunAjaranResource\RelationManagers;

class TahunAjaranResource extends Resource
{
    
    protected static ?string $model = TahunAjaran::class;

    protected static ?string $cluster = Master::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Tahun Ajaran';

    protected static ?string $modelLabel = 'Tahun Ajaran';

    protected static ?string $pluralModelLabel = 'Tahun Ajaran';

    protected static ?string $slug = 'tahun-ajaran';

    public static function form(Form $form): Form
    {
        return $form
        ->inlineLabel()
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                Forms\Components\TextInput::make('th_ajaran')
                ->label('Tahun Ajaran')
                ->placeholder('Contoh: 2020/2021')
                ->required()
                ->unique(ignoreRecord: true)
                ->validationMessages([
                    'required' => 'Tahun ajaran tidak boleh kosong',
                    'unique' => 'Tahun ajaran sudah ada, gunakan tahun ajaran lain',
                    ]),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(false),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->orderBy('th_ajaran', 'asc');
            })
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
                Tables\Columns\TextColumn::make('index')
                ->label('No')
                ->width('1%')
                ->alignCenter()
                ->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            (intval($livewire->getTableRecordsPerPage()) * (
                                intval($livewire->getTablePage()) - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('th_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status Aktif')
                    ->alignCenter()
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state) {
                            // Menonaktifkan tahun akademik lain
                            \App\Models\TahunAjaran::where('id', '!=', $record->id)
                                ->update(['status' => false]);
                        }
                    })
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
                    ->modalHeading('Hapus Tahun Ajaran'),
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
            'index' => Pages\ListTahunAjarans::route('/'),
            'create' => Pages\CreateTahunAjaran::route('/create'),
            'view' => Pages\ViewTahunAjaran::route('/{record}'),
            'edit' => Pages\EditTahunAjaran::route('/{record}/edit'),
        ];
    }
}
