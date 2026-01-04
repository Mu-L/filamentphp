# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Filament is a full-stack UI framework for Laravel built with Livewire. It provides admin panels, forms, tables, notifications, actions, infolists, and widgets as composable packages.

## Development Commands

### Running Tests

```bash
# Run all tests (SQLite + commands + PHPStan)
composer test

# Run tests with specific database
composer test:sqlite
composer test:mysql
composer test:pgsql

# Run command tests separately (they can't run in parallel)
composer test:commands:sqlite

# Run a single test file
vendor/bin/pest tests/src/Forms/Components/FileUploadTest.php

# Run PHPStan static analysis
composer test:phpstan
```

### Code Style

```bash
# Run all code style fixes (Rector + Pint + Prettier)
composer cs

# Run individual tools
vendor/bin/rector process
vendor/bin/pint --config pint-strict-imports.json
npm run prettier
```

### Building Assets

```bash
npm run build       # Build all JS and CSS
npm run build-demo  # Use this if ../demo directory exists (publishes assets to demo too)
```

## Architecture

### Package Structure

The monorepo contains these core packages in `packages/`:

- **support** - Base utilities, components, assets, colors, icons. All other packages depend on this.
- **schemas** - Schema component system for building UI layouts (shared by forms/infolists)
- **forms** - Form components extending schemas (TextInput, Select, FileUpload, etc.)
- **infolists** - Read-only display components extending schemas
- **tables** - Table component with columns, filters, and bulk actions
- **actions** - Modal actions (Create, Edit, Delete, Import, Export, etc.)
- **notifications** - Toast notification system
- **widgets** - Dashboard widgets (stats, charts)
- **panels** - Full admin panel framework combining all packages
- **query-builder** - Advanced query building UI for filtering
- **upgrade** - Rector rules for upgrading between Filament versions
- **spatie-laravel-media-library-plugin** - Integration with Spatie Media Library
- **spatie-laravel-settings-plugin** - Integration with Spatie Laravel Settings
- **spatie-laravel-tags-plugin** - Integration with Spatie Laravel Tags
- **spatie-laravel-google-fonts-plugin** - Google Fonts provider using Spatie package
- **spark-billing-provider** - Laravel Spark billing integration

### Key Concepts

**Resources** (`packages/panels/src/Resources/Resource.php`): Define CRUD interfaces for Eloquent models. Each resource has pages (List, Create, Edit, View) and configures forms, tables, and infolists.

**Pages** (`packages/panels/src/Pages/`): Livewire components that make up panel screens. Resource pages extend the base Page class.

**Schema Components** (`packages/schemas/src/Components/`): Base UI components with layout, visibility, and state management. Form and Infolist components extend these.

**Actions** (`packages/actions/src/`): Modal-based operations. Actions can have forms, confirmation dialogs, and execute callbacks.

**Panels** (`packages/panels/src/Panel.php`): Configuration object for an entire admin panel (auth, navigation, resources, pages, middleware, etc.). Created via `PanelProvider`.

### Test Structure

Tests are in `tests/src/` organized by package:
- `tests/src/Forms/` - Form component tests
- `tests/src/Tables/` - Table component tests
- `tests/src/Actions/` - Action tests
- `tests/src/Panels/` - Panel and resource tests

Tests use Pest with Laravel's Livewire testing helpers. Fixtures are in `tests/src/Fixtures/`.

### Documentation

- `docs/` - Main documentation for panels and general usage
- Package-specific docs exist in: `packages/{actions,forms,infolists,notifications,schemas,tables,widgets}/docs/`

## Coding Standards

### Pest Test Naming

Use backticks for code references in test names. Add `()` when referencing methods:

```php
// Good
it('can use `aspectRatio()` to force image cropping')
it('returns `null` for `getImageCropAspectRatio()` by default')

// Bad
it('can use aspectRatio to force image cropping')
it('returns null for getImageCropAspectRatio by default')
```

### Variable Naming

Never use abbreviated variable names in PHP or JS. Use descriptive names:

```php
// Good
$exception, $component, $response, $configuration

// Bad
$e, $comp, $res, $cfg
```

Exception: Common abbreviations where humans read them as-is are acceptable (e.g., `$id`, `$url`).

### Deprecations

When renaming or replacing public methods that are used in the documentation, keep the old method and mark it as deprecated:

```php
/**
 * @deprecated Use `newMethod()` instead.
 */
public function oldMethod(): void
{
    return $this->newMethod();
}
```

### Comments

Avoid excessive comments. PHPDoc blocks are encouraged when they add type information beyond PHP's native types, especially for arrays and generics:

```php
// Good - adds useful type info
/** @var array<string, array{label: string, icon: string}> */

// Bad - redundant with native types
/** @param string $name The name */
public function setName(string $name): void
```
