<?php

namespace App\Actions;

use Illuminate\Support\Arr;
use Spatie\Multitenancy\Exceptions\InvalidConfiguration;
use App\Actions\EnsureRightTenantDatabaseConnection;


trait UseMyTenantDatabaseConnection
{
    use   EnsureRightTenantDatabaseConnection;

    protected static function bootUseMyTenantDatabaseConnection()
    {
        return static::tenantDatabaseConnectionName();
    }

    public static function tenantDatabaseConnectionName(): ?string
    {
        static::makeCurrent();
        return config('multitenancy.tenant_database_connection_name') ?? config('database.default');
    }

    public function landlordDatabaseConnectionName(): ?string
    {
        return config('multitenancy.landlord_database_connection_name') ?? config('database.default');
    }

    public function currentTenantContainerKey(): string
    {
        return config('multitenancy.current_tenant_container_key');
    }

    public function getMultitenancyActionClass(string $actionName, string $actionClass)
    {
        $configuredClass = config("multitenancy.actions.{$actionName}") ?? $actionClass;

        if (! is_a($configuredClass, $actionClass, true)) {
            throw InvalidConfiguration::invalidAction(
                actionName: $actionName,
                configuredClass: $configuredClass ?? '',
                actionClass: $actionClass
            );
        }

        return app($configuredClass);
    }

    public function getTenantArtisanSearchFields(): array
    {
        return Arr::wrap(config('multitenancy.tenant_artisan_search_fields'));
    }
}
