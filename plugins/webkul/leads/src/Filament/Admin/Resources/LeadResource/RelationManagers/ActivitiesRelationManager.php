<?php

namespace Webkul\Lead\Filament\Admin\Resources\LeadResource\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Webkul\Lead\Models\LeadActivity;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(LeadActivity::typeOptions())
                    ->default(LeadActivity::TYPE_NOTE)
                    ->required()
                    ->native(false),
                TextInput::make('subject')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('activity_at')
                    ->label('Activity At')
                    ->default(now())
                    ->native(false),
                Textarea::make('body')
                    ->label('Details')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('subject')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => LeadActivity::typeOptions()[$state] ?? str($state)->headline()->toString())
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->placeholder('-'),
                TextColumn::make('activity_at')
                    ->label('Activity At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(LeadActivity::typeOptions()),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Activity')
                    ->icon('heroicon-o-plus-circle'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('activity_at', 'desc');
    }
}
