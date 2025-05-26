<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Provider;
use App\Models\Service;         // Import the Service model
use App\Models\ServiceCategory; // Import the ServiceCategory model
use App\Models\User;            // Import the User model
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\MorphToSelect::make('providable')
                    ->label('Link Provider to') // Or "Service / Category" or similar
                    ->types([
                        // Define the types that a Provider can belong to
                        Forms\Components\MorphToSelect\Type::make(Service::class)
                            ->titleAttribute('name'), // Attribute to display from Service model
                        Forms\Components\MorphToSelect\Type::make(ServiceCategory::class)
                            ->titleAttribute('name')->label('Sub Category'), // Attribute to display from ServiceCategory model
                        // Add other providable types here if needed in the future
                        // Forms\Components\MorphToSelect\Type::make(OtherModel::class)->titleAttribute('some_attribute'),
                    ])
                    ->searchable() // Allow searching within the selected type's items
                    ->preload(),   // Preload items for searching
                    // ->required() // Add this if a provider MUST be associated with something

                // --- Replacement for user_id ---
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name') // Assumes User model has a 'name' attribute
                                                   // Use 'email' if 'name' doesn't exist: ->relationship('user', 'email')
                    ->searchable()
                    ->preload()
                    ->required(), // Keep the required validation
                Forms\Components\TextInput::make('business_name')
                    ->maxLength(255)
                    ->live(onBlur: true)
    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255)
                    ->required()
                    ->readonly(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                    // file upload for photos
                Forms\Components\FileUpload::make('photos')
                    ->multiple()
                    ->preserveFilenames()
                    ->directory('providers')
                    ->panelLayout('grid')
                    ->reorderable()
                    ->imageEditor()
                    ->disk('public')
                    ->image(),
                Forms\Components\TextInput::make('latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('providable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('providable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
