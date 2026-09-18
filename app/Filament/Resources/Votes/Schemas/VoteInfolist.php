<?php

namespace App\Filament\Resources\Votes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class VoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([

                Section::make('Información del voto')
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('code')
                            ->label('Código de voto')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->columnSpan(6),

                        TextEntry::make('vote_type')
                            ->label('Tipo de voto')
                            ->badge()
                            ->color(fn($state) => match ($state) {
                                'válido' => 'success',
                                'no sabe' => 'info',
                                'ninguno' => 'danger',
                            })
                            ->formatStateUsing(fn($state) => match ($state) {
                                'válido' => 'Válido',
                                'no sabe' => 'No sabe / No opina',
                                'ninguno' => 'Ninguno de los anteriores',
                            })
                            ->columnSpan(6),

                        TextEntry::make('poll.title')
                            ->label('Encuesta')
                            ->columnSpanFull(),

                        TextEntry::make('candidate.name')
                            ->label('Candidato')
                            ->placeholder('—')
                            ->columnSpanFull()
                            ->visible(fn($record) => $record->vote_type === 'válido'),

                        TextEntry::make('created_at')
                            ->label('Fecha de votación')
                            ->dateTime('d/m/Y H:i:s')
                            ->columnSpan(6),

                        TextEntry::make('updated_at')
                            ->label('Última actualización')
                            ->dateTime('d/m/Y H:i:s')
                            ->columnSpan(6)
                            ->visible(fn($record) => $record->created_at != $record->updated_at),
                    ]),

                Section::make('Datos técnicos del dispositivo')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('Dirección IP')
                            ->placeholder('No registrada')
                            ->copyable()
                            ->icon('heroicon-o-globe-alt')
                            ->columnSpan(6),

                        TextEntry::make('user_agent')
                            ->label('Navegador / Dispositivo')
                            ->placeholder('No registrado')
                            ->wrap()
                            ->icon('heroicon-o-computer-desktop')
                            ->columnSpan(6),

                        TextEntry::make('session_id')
                            ->label('ID de Sesión')
                            ->placeholder('No registrada')
                            ->copyable()
                            ->icon('heroicon-o-identification')
                            ->fontFamily('mono')
                            ->size('xs')
                            ->columnSpan(12),
                    ]),

                Section::make('Huellas de seguridad (Anti-fraude)')
                    ->icon('heroicon-o-shield-check')
                    ->description('Identificadores únicos utilizados para prevenir votos duplicados')
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('fingerprint')
                            ->label('Browser Fingerprint')
                            ->placeholder('No registrado')
                            ->copyable()
                            ->fontFamily('mono')
                            ->size('xs')
                            ->helperText('Huella digital única del navegador/dispositivo')
                            ->icon('heroicon-o-finger-print')
                            ->columnSpan(12),

                        TextEntry::make('composite_hash')
                            ->label('Hash Compuesto')
                            ->placeholder('No registrado')
                            ->copyable()
                            ->fontFamily('mono')
                            ->size('xs')
                            ->helperText('SHA-256 combinado de: Poll ID + Fingerprint + IP + User Agent')
                            ->icon('heroicon-o-lock-closed')
                            ->columnSpan(12),
                    ]),

                Section::make('Análisis de seguridad')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('security_analysis')
                            ->label('Análisis automático')
                            ->placeholder('—')
                            ->state(function ($record) {
                                $warnings = [];

                                $votesFromSameIP = \App\Models\Vote::where('poll_id', $record->poll_id)
                                    ->where('ip_address', $record->ip_address)
                                    ->count();

                                if ($votesFromSameIP > 1) {
                                    $warnings[] = "⚠️ {$votesFromSameIP} votos detectados desde esta IP en esta encuesta";
                                }

                                $votesFromSameFingerprint = \App\Models\Vote::where('poll_id', $record->poll_id)
                                    ->where('fingerprint', $record->fingerprint)
                                    ->count();

                                if ($votesFromSameFingerprint > 1) {
                                    $warnings[] = "⚠️ {$votesFromSameFingerprint} votos con el mismo fingerprint en esta encuesta";
                                }

                                $allVotesFromIP = \App\Models\Vote::where('ip_address', $record->ip_address)->count();

                                if ($allVotesFromIP > 5) {
                                    $warnings[] = "🚨 Esta IP ha votado {$allVotesFromIP} veces en total (múltiples encuestas)";
                                }

                                if (empty($warnings)) {
                                    return '✅ Voto legítimo - No se detectaron anomalías';
                                }

                                return implode("\n", $warnings);
                            })
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('votes_from_same_ip')
                            ->label('Votos desde la misma IP (todas las encuestas)')
                            ->state(fn($record) => \App\Models\Vote::where('ip_address', $record->ip_address)->count())
                            ->badge()
                            ->color(fn($state) => match(true) {
                                $state == 1 => 'success',
                                $state <= 3 => 'warning',
                                default => 'danger',
                            })
                            ->columnSpan(6),

                        TextEntry::make('votes_same_fingerprint')
                            ->label('Votos con mismo fingerprint (esta encuesta)')
                            ->state(fn($record) => \App\Models\Vote::where('poll_id', $record->poll_id)
                                ->where('fingerprint', $record->fingerprint)
                                ->count())
                            ->badge()
                            ->color(fn($state) => match(true) {
                                $state == 1 => 'success',
                                default => 'danger',
                            })
                            ->columnSpan(6),
                    ]),
            ]);
    }
}
