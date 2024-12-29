<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\TasksRelationManager;
use App\Forms\Components\PostalCode;
use App\Models\User;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use Filament\Actions\Exports\Enums\ExportFormat;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;


    public static function getModelLabel(): string
    {
        return __('User');
    }

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $navigationGroup = 'Usuários';
    protected static ?int $navigationSort = 1;


    protected static ?string $slug = 'users';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Tabs::make()
                    ->columns(2)
                    ->tabs([
                        Tabs\Tab::make('Informações do Usuário')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                // TextInput::make('document')
                                //     ->label('CPF')
                                //     ->required()
                                //     ->maxLength(14)
                                //     ->mask('999.999.999-99')
                                //     ->unique(ignoreRecord: true),
                                // Forms\Components\DateTimePicker::make('email_verified_at'),
                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->revealable(filament()->arePasswordsRevealable())
                                    // ->rule(Password::default())
                                    // ->autocomplete(false)
                                    // ->dehydrated(fn($state): bool => filled($state))
                                    // ->live(debounce: 500)
                                    ->same('password Confirmation')
                                    ->maxLength(255),
                                TextInput::make('password Confirmation')
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->required()
                                    ->visible(fn(Get $get): bool => filled($get('password')))
                                    ->dehydrated(false),
                            ]),
                        Tabs\Tab::make('Relacionamentos')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Select::make('roles')
                                    ->multiple()
                                    ->relationship(
                                        'roles',
                                        'name',
                                        fn(Builder $query) =>
                                        auth()->user()->hasRole('Admin') ? null : $query->where('name', '!=', 'Admin')
                                    )
                                    ->preload()
                                    ->optionsLimit(5),
                                Select::make('permissions')
                                    ->multiple()
                                    ->relationship(titleAttribute: 'name')
                                    ->preload()
                                    ->optionsLimit(5)
                            ]),
                        // Tabs\Tab::make('Telefones')
                        // ->columns(null)
                        // ->icon('heroicon-o-phone')
                        // ->schema([
                        //     Repeater::make('phoneNumbers')
                        //         ->relationship()
                        //         ->columns(4)
                        //         ->schema([
                        //             TextInput::make('type')
                        //                 // ->required()
                        //                 ->maxLength(255),
                        //             TextInput::make('ddi')
                        //                 ->mask('99')
                        //                 ->prefix('+')
                        //                 // ->required()
                        //                 ->maxLength(255),
                        //             TextInput::make('ddd')
                        //                 ->prefix('0')
                        //                 ->mask('99')
                        //                 // ->required()
                        //                 ->maxLength(255),
                        //             TextInput::make('number')
                        //                 ->mask('99999-9999')
                        //                 // ->required()
                        //                 ->maxLength(255),
                        //         ])
                        // ]),
                        // Tabs\Tab::make('Endereço')
                        // ->relationship('address')
                        // ->columns(4)
                        // ->icon('heroicon-o-calendar-date-range')
                        // ->schema([
                        //     PostalCode::make('postal_code')
                        //         ->helperText('Digite seu CEP e clique na lupa')
                        //         ->label('CEP')
                        //         ->validationAttribute('CEP')
                        //         ->viaCep(
                        //             setFields: [
                        //                 'rua'           => 'logradouro',
                        //                 'number'        => 'numero',
                        //                 'complement'    => 'Rua',
                        //                 'bairro'        => 'bairro',
                        //                 'city'          => 'localidade',
                        //                 'uf'            => 'uf',
                        //             ]
                        //         )->required(false),
                        //     TextInput::make('rua')
                        //         // ->columnSpanFull()
                        //         ->columnSpan(3)
                        //         ->label('Rua'),
                        //     TextInput::make('number')
                        //         ->label('Número')
                        //         ->columns(1)
                        //         ->extraAlpineAttributes([
                        //             'x-on:cep.window' => "\$el.focus()",
                        //         ]),
                        //     TextInput::make('complement')
                        //         ->columnSpan(3)
                        //         ->label('Complemento'),
                        //     TextInput::make('bairro')
                        //         ->columnSpan(1)
                        //         ->label('Bairro'),
                        //     TextInput::make('city')
                        //         ->label('Cidade')
                        //         ->columnSpan(2),
                        //     TextInput::make('uf')
                        //         ->label('Estado')
                        //         ->columns(1)
                        //         ->minLength(2)
                        //         ->maxLength(2),
                        // ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                // TextColumn::make('document'),
                // TextColumn::make('phoneNumbers.full_number')
                //     ->label('Phone Number')
                //     ->searchable()
                //     ->sortable()
                //     ->listWithLineBreaks(),
                TextColumn::make('email_verified_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class)
                    ->color('info')
                    ->label('Exportar CSV ou XLSX'),
                ImportAction::make()
                    ->importer(UserImporter::class)
                    ->maxRows(1000)
                    ->csvDelimiter(',')
                    ->color('warning')
                    ->label('Importar CSV'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()
                    ->exporter(UserExporter::class)
                    ->color('info')
                    ->label('Exportar CSV')
                    ->formats([
                        ExportFormat::Csv,
                    ])
                // ]),
                // ExportBulkAction::make()
                //     ->exporter(UserExporter::class)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            // 'view' => Pages\ViewUser::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // return parent::getEloquentQuery()->where('name', '!=', 'Admin');
        return auth()->user()->hasRole('Admin')
            ? parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                'roles',
                fn(Builder $query) => $query->where('name', '!=', 'Admin')
            );
    }
}
