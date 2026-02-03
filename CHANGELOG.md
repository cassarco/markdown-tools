# Changelog

All notable changes to `markdown-tools` will be documented in this file.

## v2.0.0 - 2026-02-03

### Breaking Changes

- **Handler and rules are now class-based** - Closures in config are no longer supported. You must use invokable classes implementing `MarkdownFileHandler` and `MarkdownFileRules` contracts.
- **Config is now cacheable** - The config file no longer contains closures, so `php artisan config:cache` works correctly.
- **Action classes must be published** - Run `php artisan markdown-tools:install` or `php artisan vendor:publish --tag=markdown-tools-actions` to publish the required action stubs.

### Added

- `MarkdownFileHandler` contract for handler classes
- `MarkdownFileRules` contract for validation rules classes
- `InvalidConfigException` for configuration errors
- Install command: `php artisan markdown-tools:install`
- Publishable action stubs to `app/Actions/`

### Changed

- Default scheme renamed from `markdown` to `default`
- Updated to Laravel 12 support (via orchestra/testbench ^10.0)
- Updated to Pest 3.x
- Updated to PHPStan 2.x
- Updated to Larastan 3.x

### Removed

- Closure support for handlers and rules in config

## v1.0.0 - 2024-03-24

Stable release v1.0.0
