<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Info')
                    ->schema([
                        Forms\Components\MorphToSelect::make('providable')
                            ->label('Link Provider to')
                            ->types([
                                Forms\Components\MorphToSelect\Type::make(Service::class)
                                    ->titleAttribute('name'),
                                Forms\Components\MorphToSelect\Type::make(ServiceCategory::class)
                                    ->titleAttribute('name')->label('Sub Category'),
                            ])
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('business_name')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->maxLength(255)
                            ->required()
                            ->readonly(),

                        Forms\Components\Textarea::make('description')->columnSpanFull(),

                        Forms\Components\TextInput::make('phone')->tel()->maxLength(255),

                        Forms\Components\TextInput::make('alternate_phone')->tel()->maxLength(255),

                        Forms\Components\TextInput::make('whatsapp_number')->maxLength(255),

                        Forms\Components\TextInput::make('email')->email(),

                        Forms\Components\TextInput::make('website')->url(),

                        Forms\Components\TextInput::make('address')->maxLength(255),

                        Forms\Components\TextInput::make('area')->maxLength(255),

                        Forms\Components\TextInput::make('pincode')->maxLength(20),

                        Forms\Components\FileUpload::make('photos')
                            ->multiple()
                            ->preserveFilenames()
                            ->directory('providers')
                            ->panelLayout('grid')
                            ->reorderable()
                            ->imageEditor()
                            ->disk('public')
                            ->image(),

                        Forms\Components\FileUpload::make('logo')
                            ->preserveFilenames()
                            ->directory('provider-logos')
                            ->image()
                            ->imageEditor()
                            ->disk('public'),

                        Forms\Components\Hidden::make('latitude'),
                        Forms\Components\Hidden::make('longitude'),

                        Forms\Components\Toggle::make('is_active')->required()->default(true),
                        Forms\Components\Toggle::make('is_verified'),
                        Forms\Components\Toggle::make('featured'),

                        Forms\Components\TextInput::make('views')->numeric()->default(0),
                    ]),

                Section::make('Contact Person')
                    ->schema([
                        Forms\Components\TextInput::make('contact_person_name')->maxLength(255),
                        Forms\Components\TextInput::make('contact_person_role')
                        ->label('Contact Person Role')
                        ->datalist([
                            'Manager',
                            'Owner',
                            'Supervisor',
                            'Receptionist',
                            'Representative',
                        ])
                        ->maxLength(255),
                        Forms\Components\TextInput::make('contact_person_phone')->maxLength(255),
                        Forms\Components\TextInput::make('contact_person_email')->email(),
                        Forms\Components\TextInput::make('contact_person_whatsapp')->maxLength(255),
                    ]),

                Section::make('Additional Info')
                    ->schema([
                        Forms\Components\Fieldset::make('working_hours')
                            ->label('Working Days and Hours')
                            ->schema([
                                Forms\Components\CheckboxList::make('working_hours.days')
                                    ->label('Working Days')
                                    ->options([
                                        'Monday' => 'Monday',
                                        'Tuesday' => 'Tuesday',
                                        'Wednesday' => 'Wednesday',
                                        'Thursday' => 'Thursday',
                                        'Friday' => 'Friday',
                                        'Saturday' => 'Saturday',
                                        'Sunday' => 'Sunday',
                                    ])
                                    ->columns(2),
                                        Section::make('Working Hours')
                                ->schema([
                                Forms\Components\TimePicker::make('working_hours.from')
                                    ->label('Working From')
                                    ->seconds(false)
                                    ->required(),

                                Forms\Components\TimePicker::make('working_hours.to')
                                    ->label('Working To')
                                    ->seconds(false)
                                    ->required(),
                            ])
                            ]),

                        Forms\Components\Select::make('established_year')
                            ->label('Established Year')
                            ->options(
                                collect(range(date('Y'), 1800))->mapWithKeys(fn ($year) => [$year => $year])->toArray()
                            )
                            ->searchable()
                            ->preload(),

                        Forms\Components\TagsInput::make('tags'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('business_name')->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('website')->searchable(),
                Tables\Columns\TextColumn::make('contact_person_name')->label('Contact Person')->searchable(),
                Tables\Columns\TextColumn::make('area')->searchable(),
                Tables\Columns\TextColumn::make('pincode')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\IconColumn::make('is_verified')->boolean(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\TextColumn::make('views')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
