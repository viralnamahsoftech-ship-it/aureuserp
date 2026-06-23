# AureusERP Plugin Creation Rules

Use this checklist when creating a new plugin or updating an existing module.

## 1. Confirm The Real Stack

- Check `composer.json`, `bootstrap/providers.php`, and sibling plugins before coding.
- Follow the installed Filament syntax in this repo, not assumptions from another version.
- Current plugin base path is `plugins/webkul/{plugin-name}`.
- Each plugin namespace should be `Webkul\{StudlyName}`.
- Each plugin service provider extends `Webkul\PluginManager\PackageServiceProvider`.

## 2. Required Plugin Files

Minimum structure:

```text
plugins/webkul/{plugin-name}/
  composer.json
  src/{StudlyName}ServiceProvider.php
  src/{StudlyName}Plugin.php
  src/Models/{Model}.php
  src/Policies/{Model}Policy.php
  src/Filament/Admin/Resources/{Model}Resource.php
  src/Filament/Admin/Resources/{Model}Resource/Pages/List{Models}.php
  src/Filament/Admin/Resources/{Model}Resource/Pages/Create{Model}.php
  src/Filament/Admin/Resources/{Model}Resource/Pages/Edit{Model}.php
  src/Filament/Admin/Resources/{Model}Resource/Pages/View{Model}.php
  database/migrations/{timestamp}_create_{table}_table.php
```

Add more models, migrations, relation managers, clusters, pages, widgets, translations, settings, seeders, or factories only when the module needs them.

## 3. Composer Rules

`composer.json` must include:

- Package name, for example `webkul/leads`.
- Description.
- `extra.laravel.providers` with the plugin service provider.
- PSR-4 autoload mapping, for example `Webkul\\Lead\\` to `src/`.
- Factory and seeder namespaces if those folders are used.

After adding or renaming plugin files, run:

```bash
php -d xdebug.mode=off C:\ProgramData\ComposerSetup\bin\composer.phar dump-autoload --no-scripts --no-interaction
php -d xdebug.mode=off artisan package:discover --ansi
php -d xdebug.mode=off artisan optimize:clear --no-interaction
```

On Windows, prefer disabling Xdebug for Composer because normal `composer dump-autoload` can be slow.

## 4. Provider Registration Rules

Every local plugin must be registered in:

```text
bootstrap/providers.php
```

Add:

```php
use Webkul\Lead\LeadServiceProvider;
```

and:

```php
LeadServiceProvider::class,
```

The plugin may also declare the provider in its own `composer.json`, but in this app `bootstrap/providers.php` is the practical registration source for local Webkul plugins.

## 5. Service Provider Rules

The service provider must:

- Set `public static string $name` to the plugin install name.
- Set `public static string $viewNamespace`.
- Call `$package->name(static::$name)`.
- Register migrations with `hasMigrations([...])`.
- Use `runsMigrations()` when plugin migrations should load after install.
- Keep `hasDependencies([])` empty unless dependency install commands actually exist.
- Add `hasInstallCommand(fn (InstallCommand $command) => $command->runsMigrations())`.
- Register the Filament plugin in `packageRegistered()` with `Panel::configureUsing(...)`.

Do not add fake dependencies. If dependency commands do not exist, installation will fail.

## 6. Plugin Class Rules

The plugin class must:

- Implement `Filament\Contracts\Plugin`.
- Return the plugin name from `getId()`.
- Use `app(static::class)` in `make()`.
- Check `Package::isPluginInstalled($this->getId())` before discovering resources.
- Discover admin resources only for the admin panel.

Typical admin discovery:

```php
$panel
    ->discoverResources(
        in: __DIR__.'/Filament/Admin/Resources',
        for: 'Webkul\\Lead\\Filament\\Admin\\Resources'
    )
    ->discoverPages(...)
    ->discoverClusters(...)
    ->discoverWidgets(...);
```

## 7. Menu And Navigation Rules

This is mandatory: a module is not complete just because a route exists.

For every Filament resource, verify:

- The resource appears in the correct menu.
- The direct route works after login.
- The current user has the required permission.
- The menu placement follows sibling modules.

If sibling modules use clusters, attach the new resource to the same cluster.

Example for a sales operational module:

```php
use Webkul\Sale\Filament\Clusters\Orders;

protected static ?string $cluster = Orders::class;
protected static ?string $slug = 'leads';
protected static ?int $navigationSort = 0;
protected static bool $shouldRegisterNavigation = true;
```

For the Leads plugin, menu path is:

```text
Sales -> Orders -> Leads
```

and route path is:

```text
/admin/sale/orders/leads
```

Do not expect operational modules to appear under `/admin/plugins`; that screen is for plugin management, not the module's work UI.

## 8. Resource Rules

Each resource should define:

- `$model`
- `$slug`
- `$navigationIcon`
- `$navigationSort`
- `$shouldRegisterNavigation`
- `$cluster` when the module belongs inside an existing menu cluster.
- `getNavigationLabel()`
- `getModelLabel()` when useful.
- `form(Schema $schema): Schema`
- `table(Table $table): Table`
- `infolist(Schema $schema): Schema` for view pages.
- `getPages(): array`

Use repo patterns:

- Filament schemas use `Filament\Schemas\Schema`.
- Form sections use `Filament\Schemas\Components\Section`.
- Actions use `Filament\Actions`.
- Tables use `Filament\Tables\Table`.
- Icons must use the correct Filament 5 type: `string|BackedEnum|null`.

## 9. Policy And Permission Rules

Never guess permission names. Generate Shield permissions and inspect the actual keys.

Run:

```bash
php -d xdebug.mode=off artisan shield:generate --all --option=permissions --panel=admin --no-interaction
```

Then check:

```bash
php -d xdebug.mode=off artisan tinker
```

```php
DB::table('permissions')->where('name', 'like', '%lead%')->pluck('name');
```

Policy methods must match generated keys exactly.

Example from Leads:

```php
viewAny  -> view_any_lead_lead
view     -> view_lead_lead
create   -> create_lead_lead
update   -> update_lead_lead
delete   -> delete_lead_lead
```

After generating permissions, make sure the admin role has them. The plugin install command normally syncs permissions to the first role, but verify when access is missing.

## 10. Migration Rules

Before creating migrations:

- Inspect sibling plugin tables.
- Use plugin-prefixed table names when needed, for example `leads_leads`.
- Add foreign keys to existing app tables with the real table names.
- Add indexes for filter/search columns.
- Use `softDeletes()` if the resource has restore/force-delete actions.
- Make nullable fields nullable in both migration and form.

After install, verify:

```bash
php -d xdebug.mode=off artisan migrate:status --no-ansi
```

## 11. Model Rules

Models should include:

- Explicit `$table` when plugin table names are prefixed.
- `$fillable`.
- `$casts`.
- Relationship return types.
- Defaults in `boot()` when values depend on `auth()`.
- Constants/options for enums used by form, table, filters, and actions.

Avoid duplicating enum option arrays across resources.

## 12. Install And Cache Rules

After creating or updating a plugin:

```bash
php -d xdebug.mode=off artisan {plugin-name}:install --no-interaction
php -d xdebug.mode=off artisan optimize:clear --no-interaction
php -d xdebug.mode=off artisan shield:generate --all --option=permissions --panel=admin --no-interaction
```

Restart the dev server after changing providers, resource class signatures, policies, or plugin discovery.

For this local setup:

```bash
php -d xdebug.mode=off artisan serve --host=127.0.0.1 --port=8000 --no-reload
```

## 13. Validation Checklist

Run these before saying the module is done:

```bash
php -d xdebug.mode=off -l plugins/webkul/{plugin}/src/{File}.php
php -d xdebug.mode=off artisan route:list --path=admin/{expected-path} --no-ansi
php -d xdebug.mode=off artisan migrate:status --no-ansi
php -d xdebug.mode=off artisan shield:generate --all --option=permissions --panel=admin --no-interaction
vendor/bin/pint --dirty --format agent
```

Also verify:

- Plugin install command exists and runs.
- Routes exist.
- Migrations ran.
- Current admin user can access `viewAny`.
- Menu item appears in the intended group or cluster.
- Direct URL redirects to login when unauthenticated, not 404.
- Direct URL opens the resource after login.
- No recent Laravel log errors reference the new resource.

## 14. Browser Validation Rules

When UI access is questioned:

- Confirm the user is on the local app, not the reference portal.
- Confirm the correct route.
- Confirm login state.
- Confirm menu path.
- Hard refresh the admin panel after cache clears.
- Restart `artisan serve` if class signatures, providers, or policies changed.

For Leads:

```text
Correct local URL: http://127.0.0.1:8000/admin/sale/orders/leads
Correct menu path: Sales -> Orders -> Leads
Incorrect place to look: /admin/plugins
```

## 15. Updating Existing Modules

When updating an existing module:

- Read the module service provider, plugin class, resource, model, policy, and migrations first.
- Do not rename tables, permissions, routes, or namespaces unless required.
- Keep routes stable unless moving into a correct cluster/menu is the explicit fix.
- If route changes, update the module doc immediately.
- Run Shield generation when resources or policies change.
- Run `optimize:clear`.
- Restart the dev server if the browser is already open.
- Verify old route behavior and new route behavior.

## 16. Final Report Requirements

Every plugin task final answer should include:

- Files changed.
- Install command.
- Menu path.
- Direct URL.
- Verification commands run.
- Any route or permission name changes.
- Any remaining risk or manual browser step.

