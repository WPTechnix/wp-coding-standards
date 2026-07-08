# WPTechnix Coding Standards

[![Validate Rulesets](https://github.com/WPTechnix/wp-coding-standards/actions/workflows/rulesets.yml/badge.svg)](https://github.com/WPTechnix/wp-coding-standards/actions/workflows/rulesets.yml)

PHP_CodeSniffer rulesets for WordPress development. Combines WordPress Coding Standards ([WPCS](https://github.com/WordPress/WordPress-Coding-Standards)), [VIPCS](https://github.com/Automattic/VIP-Coding-Standards), [PHPCompatibilityWP](https://github.com/PHPCompatibility/PHPCompatibilityWP), [PHPCSExtra](https://github.com/PHPCSStandards/PHPCSExtra), and [Slevomat Coding Standard](https://github.com/slevomat/coding-standard).

## Architecture

Standards are layered. Each builds on the one before it.

```text
WPTechnix (base)
  +-- WPTechnix-PSR4    (adds PSR-4 file naming)
  +-- WPTechnix-PSR     (adds PSR-4 naming + PSR-12 formatting)
  +-- WPTechnix-Strict  (standalone, no base dependency)
```

`WPTechnix-PSR` combines PSR-4 file naming and PSR-12 formatting in a single standard.

## Standards

### WPTechnix

Starts from `WordPress-Extra` and `WordPress-Docs`, then adds:

- **VIPCS**: Platform-agnostic subset (security, escaping, perf, hooks), excluding Automattic-specific rules.
- **PHPCompatibilityWP**: Cross-version PHP compatibility (default floor: PHP 8.0).
- **PHPCSExtra / Universal**: Gap-filling sniffs (no FQN true/false/null, `TODO`/`FIXME` enforcement, etc.).
- **Slevomat**: Dead catch detection, useless variable elimination, import hygiene, null-coalescing enforcement, modern PHP formatting (attributes, enums, arrow functions, union/DNF types).

Style: WordPress conventions with tab indentation, long arrays, and Yoda conditions.

Use with: WordPress plugins or themes that follow the standard WordPress style.

### WPTechnix-PSR4

Silences `WordPress.Files.FileName` (which enforces `class-{name}.php`) and the redundant `@package` tag. Classes use filenames like `Plugin.php` and `Admin/Settings.php` instead of `class-plugin.php` and `class-admin-settings.php`. Inherits the base standard.

Use with: Projects using PSR-4 autoloading that want to keep WordPress formatting (tabs, long arrays, Yoda).

### WPTechnix-PSR

Combines PSR-4 file naming with PSR-12 formatting in a single standard. Differences from the base:

| Rule | WPTechnix | WPTechnix-PSR |
|------|-----------|---------------|
| Indentation | Tabs | 4 spaces |
| Arrays | Long (`array()`) | Short (`[]`) |
| Braces | Same line (K&R) | Next line |
| Yoda conditions | Enforced | Silenced |
| Naming (`snake_case`) | Enforced | Silenced |
| File naming | `class-{name}.php` | `{Name}.php` |

Includes `PSR12` (excluding `PSR1.Files.SideEffects`), `Generic.Arrays.DisallowLongArraySyntax`, and the PSR-4 file naming changes. Subsumes `WPTechnix-PSR4`, so you do not need both.

Use with: Projects that want PSR-4 autoloading and PSR-12 formatting. Most common when a plugin also contains non-WordPress PHP packages or follows team-wide PSR conventions.

### WPTechnix-Strict

Standalone (no dependency on WPTechnix). Style-neutral and WordPress-independent. Works on any PHP codebase.

- **Type hints**: Parameter, return, property, and class constant type hints.
- **Complexity metrics**: Cognitive (warn 12 / error 20), cyclomatic (max 10), nesting (max 5).
- **OOP design**: `abstract` or `final` on non-interface classes, `self` references, forbidden public properties (readonly allowed).
- **Code quality**: Early exit, null-safe operator, unused variables, strict calls, non-capturing catches.
- **Import discipline**: All namespaced references must be imported.

Can be combined with the base:

```bash
phpcs --standard=WPTechnix,WPTechnix-Strict path/to/file.php
```

Use with: Adding static analysis on top of WPTechnix, or standalone on any PHP 8.0+ project.

## How to choose

| Project | Standard |
|---------|----------|
| WordPress plugin, traditional style | `WPTechnix` |
| WordPress plugin, PSR-4 autoloading | `WPTechnix-PSR4` |
| WordPress plugin, PSR-4 + PSR-12 | `WPTechnix-PSR` |
| Static analysis on any codebase | `WPTechnix-Strict` |
| PSR conventions + static analysis | `WPTechnix-PSR,WPTechnix-Strict` |

All combinations are pre-validated. No conflicting sniffs produce deadlock or double-firing.

## How it works

Each standard is a `ruleset.xml` file that references parent standards and individual sniffs. PHP_CodeSniffer follows the `<rule ref>` chain and merges every referenced sniff with its configured severity. When multiple standards are passed on the command line (e.g. `WPTechnix-PSR4,WPTechnix-PSR`), PHPCS resolves each and merges the results, deduplicating sniffs included by more than one standard.

`WPTechnix-PSR` alone replaces using both `WPTechnix-PSR4` and `WPTechnix-PSR12` together.

## Requirements

- PHP 8.0+
- Composer

## Installation

```bash
composer require --dev wptechnix/wp-coding-standards
```

PHP_CodeSniffer auto-discovers installed standards via [phpcodesniffer-composer-installer](https://github.com/PHPCSStandards/composer-installer).

## Usage

```bash
# List registered standards
phpcs -i

# Explain what a standard checks
phpcs --standard=WPTechnix -e

# Lint a file
phpcs --standard=WPTechnix path/to/file.php

# PSR conventions (naming + formatting)
phpcs --standard=WPTechnix-PSR path/to/file.php

# With static analysis on top
phpcs --standard=WPTechnix-PSR,WPTechnix-Strict path/to/file.php
```

In your project's `phpcs.xml`:

```xml
<!-- PSR-4 naming + PSR-12 formatting on a WordPress plugin -->
<rule ref="WPTechnix-PSR" />
<rule ref="WPTechnix-Strict" />

<!-- Override PHP version for PHPCompatibilityWP -->
<config name="testVersion" value="8.2-" /> <!-- Means 8.2 or above; Could be 8.0-, 8.1- or any >8.0 -->

<!-- Set your plugin textdomain for i18n sniffs -->
<rule ref="WordPress.WP.I18n">
    <properties>
        <property name="textdomain" value="my-plugin" />
    </properties>
</rule>
```

## Development

```bash
composer install
composer validate-rulesets   # Verify all standards resolve
composer lint:fixtures        # Confirm no formatting deadlock
```

A Docker-based Composer helper is available at `scripts/composer` for environments without a local PHP install:

```bash
./scripts/composer install
./scripts/composer validate-rulesets
```

## License

MIT
