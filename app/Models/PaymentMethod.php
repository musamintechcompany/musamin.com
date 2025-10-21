<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;
use Illuminate\Support\Facades\Log;
use JsonException;

class PaymentMethod extends Model
{
    // Set UUID as primary key and disable auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'hashid',
        'name',
        'code',
        'type',
        'category',
        'icon',
        'countdown_time',
        'usd_rate',
        'currency_symbol',
        'crypto_credentials',
        'bank_credentials',
        'is_active',
        'has_fee',
        'sort_order'
    ];

    protected $casts = [
        'crypto_credentials' => 'array',
        'bank_credentials' => 'array',
        'is_active' => 'boolean',
        'has_fee' => 'boolean',
        'usd_rate' => 'decimal:8',
    ];

    protected $appends = [
        'has_multiple_credentials',
        'formatted_credentials'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate UUID if not set
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }

            // Generate hashid if not set
            if (empty($model->hashid)) {
                $model->hashid = $model->generateHashid();
            }
        });
    }

    public function generateHashid(): string
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt'),
            config('hashids.connections.main.length'),
            config('hashids.connections.main.alphabet')
        );

        $numericId = crc32($this->id);
        return $hashids->encode($numericId);
    }

    public function getFormattedCredentialsAttribute(): array
    {
        return $this->getFormattedCredentials();
    }

    public function getFormattedCredentials(): array
    {
        try {
            return match ($this->category) {
                'crypto' => $this->formatCryptoCredentials(),
                'bank' => $this->formatBankCredentials(),
                default => [],
            };
        } catch (\Exception $e) {
            Log::error("Failed to format credentials for method {$this->id}", [
                'error' => $e->getMessage(),
                'credentials' => $this->crypto_credentials,
                'bank_credentials' => $this->bank_credentials
            ]);
            return [];
        }
    }

    protected function formatCryptoCredentials(): array
    {
        $wallets = $this->crypto_credentials['wallets'] ?? [];

        return array_map(function ($wallet) {
            return [
                'type' => 'crypto',
                'address' => $wallet['address'] ?? '',
                'qr_code' => $wallet['qr_code'] ?? null,
                'network' => $wallet['network'] ?? null,
                'comment' => $wallet['comment'] ?? null,
                'active' => $wallet['active'] ?? true
            ];
        }, array_filter($wallets, fn($w) => $w['active'] ?? true));
    }

    protected function formatBankCredentials(): array
    {
        $rawData = $this->bank_credentials ?? [];

        if (empty($rawData)) {
            Log::warning("Empty bank credentials for method {$this->id}");
            return [];
        }

        if (is_string($rawData)) {
            try {
                $rawData = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                Log::error("Invalid JSON in bank credentials", [
                    'method_id' => $this->id,
                    'error' => $e->getMessage(),
                    'raw_data' => $rawData
                ]);
                return [];
            }
        }

        // Log the structure for debugging
        Log::info("Processing bank credentials for method {$this->id}", [
            'structure' => array_keys($rawData),
            'has_groups' => isset($rawData['groups']),
            'has_direct_details' => isset($rawData[0]['details']),
            'has_flat_details' => isset($rawData['details'])
        ]);

        if (isset($rawData['groups'])) {
            return $this->processGroupedCredentials($rawData['groups']);
        }

        if (isset($rawData[0]['details'])) {
            return $this->processDirectCredentials($rawData);
        }

        if (isset($rawData['details'])) {
            return $this->processFlatDetails($rawData);
        }

        return $this->processLegacyFormat($rawData);
    }

    protected function processDirectCredentials(array $data): array
    {
        $result = [];

        foreach ($data as $index => $group) {
            if (!($group['active'] ?? true)) {
                Log::info("Skipping inactive group {$index} for method {$this->id}");
                continue;
            }

            $details = [];
            foreach ($group['details'] ?? [] as $detail) {
                if (isset($detail['title']) && isset($detail['value']) && !empty(trim($detail['value']))) {
                    $details[] = [
                        'title' => trim($detail['title']),
                        'value' => trim($detail['value'])
                    ];
                }
            }

            if (!empty($details)) {
                $result[] = [
                    'type' => 'bank',
                    'details' => $details,
                    'comment' => $group['comment'] ?? null,
                    'active' => true
                ];
                Log::info("Added bank credential group {$index} with " . count($details) . " details");
            } else {
                Log::warning("No valid details found in group {$index} for method {$this->id}");
            }
        }

        return $result;
    }

    protected function processGroupedCredentials(array $groups): array
    {
        $result = [];

        foreach ($groups as $group) {
            if (!($group['active'] ?? true)) {
                continue;
            }

            $details = [];
            foreach ($group['details'] ?? [] as $detail) {
                if (isset($detail['title']) && isset($detail['value'])) {
                    $details[] = [
                        'title' => $detail['title'],
                        'value' => $detail['value']
                    ];
                }
            }

            if (!empty($details)) {
                $result[] = [
                    'type' => 'bank',
                    'details' => $details,
                    'comment' => $group['comment'] ?? null,
                    'active' => true
                ];
            }
        }

        return $result;
    }

    protected function processFlatDetails(array $data): array
    {
        $details = [];
        foreach ($data['details'] ?? [] as $detail) {
            if (isset($detail['title']) && isset($detail['value'])) {
                $details[] = [
                    'title' => $detail['title'],
                    'value' => $detail['value']
                ];
            }
        }

        if (empty($details)) {
            return [];
        }

        return [[
            'type' => 'bank',
            'details' => $details,
            'comment' => $data['comment'] ?? null,
            'active' => $data['active'] ?? true
        ]];
    }

    protected function processLegacyFormat(array $data): array
    {
        $details = [];

        foreach ($data as $key => $value) {
            if (is_string($key) && !empty($value)) {
                $details[] = [
                    'title' => ucwords(str_replace('_', ' ', $key)),
                    'value' => $value
                ];
            }
        }

        if (empty($details)) {
            return [];
        }

        return [[
            'type' => 'bank',
            'details' => $details,
            'comment' => null,
            'active' => true
        ]];
    }

    protected function getHasMultipleCredentialsAttribute(): bool
    {
        try {
            return count($this->formatted_credentials) > 1;
        } catch (\Exception $e) {
            Log::error("Failed to check multiple credentials", [
                'method_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeManual($query)
    {
        return $query->where('type', 'manual');
    }

    public function scopeWithFees($query)
    {
        return $query->where('has_fee', true);
    }

    public static function findByHashid($hashid)
    {
        return static::where('hashid', $hashid)->first();
    }
}
