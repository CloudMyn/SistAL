<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatakuliahResource\Pages;
use App\Filament\Resources\MatakuliahResource\RelationManagers;
use App\Models\Frekuensi;
use App\Models\Matakuliah;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatakuliahResource extends Resource
{
    protected static ?string $model = Matakuliah::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?int $navigationSort = -2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->columnSpanFull()
                    ->unique('mata_kuliahs', 'nama', ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\Repeater::make('frekuensis')
                    ->label('Daftar Frekuensi')
                    ->columnSpanFull()
                    ->distinct()
                    ->createItemButtonLabel('Tambah Frekuensi')
                    ->deleteAction(
                        function (Action $action) {
                            return $action
                                ->before(function ($component, $get, $state, $arguments) {

                                    $id_frekuensi = $state[$arguments['item']]['id'];

                                    $frekuensi = Frekuensi::find($id_frekuensi);

                                    $frekuensi->update([
                                        'mata_kuliah_id'  =>  null
                                    ]);
                                });
                        }
                    )
                    ->simple(Forms\Components\Select::make('id')->placeholder('Pilih Frekuensi')
                        ->distinct()
                        ->options(function ($record) {
                            if (!$record) {
                                return Frekuensi::where('mata_kuliah_id', null)->get()->pluck('name', 'id');
                            }

                            return Frekuensi::get()->pluck('name', 'id');
                        }))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('frekuensi_count')
                    ->default(function ($record) {
                        return $record->frekuensi()->count();
                    })
                    ->badge()
                    ->label('Frekuensi'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatakuliahs::route('/'),
            'create' => Pages\CreateMatakuliah::route('/create'),
            'edit' => Pages\EditMatakuliah::route('/{record}/edit'),
        ];
    }
}
