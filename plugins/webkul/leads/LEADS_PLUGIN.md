# Leads Plugin

Plugin name: `leads`

Install command:

```bash
php artisan leads:install
```

Admin URL:

```text
/admin/sale/orders/leads
```

## Goal

The lead module is built for minimum clicks and maximum daily sales work. The reference portal lead screen was dense and action-driven: fast search, visible lead stage, owner, contact data, follow-up information, and quick actions from the listing. This plugin keeps that workflow inside a native Filament resource.

## Portal UI Mapped Into AureusERP

Reference portal concepts mapped into this plugin:

- Lead list with quick search and table columns.
- New Lead action from the list header.
- Business/contact details on the main form.
- Business segment, category, source, priority, and sales person ownership.
- Stage pipeline with visible progress on the view page.
- Quick stage change action from list, view, and edit pages.
- Quick call log action with next follow-up date.
- Follow-up due preset view.
- My Leads preset view.
- Open Pipeline preset view.

## Files

- `composer.json` registers PSR-4 autoloading for `Webkul\Lead\`.
- `src/LeadServiceProvider.php` defines plugin metadata, migrations, install command, and panel plugin registration.
- `src/LeadPlugin.php` discovers admin Filament resources when the plugin is installed.
- `src/Models/Lead.php` is the main lead pipeline model.
- `src/Models/LeadActivity.php` stores notes, calls, emails, and meetings against a lead.
- `src/Policies/LeadPolicy.php` maps Filament/Shield permissions to lead actions.
- `database/migrations/2026_01_01_000001_create_leads_leads_table.php` creates the lead table.
- `database/migrations/2026_01_01_000002_create_leads_activities_table.php` creates the lead activity table.
- `src/Filament/Admin/Resources/LeadResource.php` defines the form, table, infolist, filters, actions, pages, and Sales Orders cluster menu placement.
- `src/Filament/Admin/Resources/LeadResource/Pages/ListLeads.php` adds preset views and the New Lead button.
- `src/Filament/Admin/Resources/LeadResource/Pages/CreateLead.php` redirects new records to the view screen.
- `src/Filament/Admin/Resources/LeadResource/Pages/EditLead.php` adds view, stage change, call log, and delete actions.
- `src/Filament/Admin/Resources/LeadResource/Pages/ViewLead.php` adds edit, stage change, call log, and delete actions.

## Bootstrap Sequence

1. Laravel loads `bootstrap/providers.php`.
2. `Webkul\Lead\LeadServiceProvider` configures package name `leads`, migrations, install command, translations, views, and icon.
3. During panel registration, the service provider adds `LeadPlugin::make()` to Filament.
4. `LeadPlugin` checks the admin panel and installed plugin status.
5. Once installed, the plugin discovers resources under `src/Filament/Admin/Resources`.
6. Filament registers `LeadResource`.
7. The admin panel exposes `/admin/sale/orders/leads`, `/create`, `/{record}`, and `/{record}/edit`.

## Data Model

`leads_leads` stores the sales opportunity:

- Identification: `lead_number`.
- Contact: `business_name`, `contact_title`, `contact_name`, `email`, `phone`, `alternate_phone`.
- Classification: `business_segment`, `business_category`, `business_sub_category`, `source`, `other_source`.
- Pipeline: `stage`, `priority`, `probability`, `expected_close_date`, `lost_reason`.
- Commercial: `project_title`, `pv_capacity`, `expected_value`.
- Follow-up: `last_contacted_at`, `next_follow_up_at`.
- Address: billing/contact address plus separate site address fields.
- Ownership: `customer_id`, `assigned_to`, `company_id`, `creator_id`.
- Audit: soft deletes and timestamps.

`leads_activities` stores lead history:

- `lead_id`
- `type`: note, call, email, meeting
- `subject`
- `body`
- `activity_at`
- `creator_id`

## Lead Stages

The current stage flow is:

```text
New -> Qualified -> Site Survey -> Design -> Quotation -> Negotiation -> Won / Lost
```

These are defined in `Webkul\Lead\Models\Lead` as constants and reused by the form, table badges, filters, action modal, and progress stepper.

## Priority Values

```text
Low, Medium, High, Extreme
```

The default priority is `Medium`.

## Ownership Defaults

When a lead is created:

- `lead_number` is generated as `LEAD{yy}_{####}`.
- `stage` defaults to `new`.
- `priority` defaults to `medium`.
- `country` defaults to `India`.
- `creator_id` defaults to `auth()->id()`.
- `assigned_to` defaults to `auth()->id()`.
- `company_id` defaults to `auth()->user()->default_company_id`.

## Filament Resource

`LeadResource` extends `Filament\Resources\Resource`.

Menu placement:

- Cluster: `Webkul\Sale\Filament\Clusters\Orders`.
- Top navigation path: `Sales -> Orders -> Leads`.
- Resource slug: `leads`.
- Explicit navigation registration: `protected static bool $shouldRegisterNavigation = true`.
- Sort order: `0`, so Leads appears before quotations/orders inside the Orders cluster.

Main table behavior:

- Searchable lead number, business name, contact name, phone, and email.
- Stage badge with colors.
- Priority badge with colors.
- Sales person column.
- Next follow-up column.
- Created date column.
- Stage and sales person grouping.
- Filters for stage, priority, assigned sales person, and overdue follow-up.
- Row actions: view, edit, change stage, log call, restore, delete, force delete.

Main form sections:

- Lead Progress
- Business & Contact
- Address
- Site Address
- Remarks
- Classification
- Opportunity
- Ownership

View page:

- Uses `Webkul\Field\Filament\Infolists\Components\ProgressStepper` for pipeline progress.
- Shows contact, opportunity, ownership, and status summary.

## Permissions

The policy expects the permission keys generated by Filament Shield for this resource:

- `view_any_lead_lead`
- `view_lead_lead`
- `create_lead_lead`
- `update_lead_lead`
- `delete_lead_lead`
- `delete_any_lead_lead`
- `force_delete_lead_lead`
- `force_delete_any_lead_lead`
- `restore_lead_lead`
- `restore_any_lead_lead`
- `reorder_lead_lead`

The install command refreshes Filament Shield permissions and syncs them to the first role, matching the current plugin manager behavior.

## Installed State

The plugin is registered in:

```text
bootstrap/providers.php
```

The installed admin routes are:

```text
GET /admin/sale/orders/leads
GET /admin/sale/orders/leads/create
GET /admin/sale/orders/leads/{record}
GET /admin/sale/orders/leads/{record}/edit
```
