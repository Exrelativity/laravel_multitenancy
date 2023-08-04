## Artisan command for running migration in multitenancy

To run migration for the LandLords
```  
php artisan migrate:fresh --path=database/migrations/landlord --database=landlord

```

To run migration for the tenants
```
php artisan tenants:artisan "migrate --database=tenant"
```