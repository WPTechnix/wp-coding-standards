# WPTechnix Coding Standards

[![Validate Rulesets](https://github.com/WPTechnix/wp-coding-standards/actions/workflows/rulesets.yml/badge.svg)](https://github.com/WPTechnix/wp-coding-standards/actions/workflows/rulesets.yml)

PHP_CodeSniffer rulesets for WordPress plugin development. They help you catch coding mistakes, enforce consistent formatting, and keep your code compatible across PHP versions.

These rulesets combine standards from [WPCS](https://github.com/WordPress/WordPress-Coding-Standards), [VIPCS](https://github.com/Automattic/VIP-Coding-Standards), [PHPCompatibilityWP](https://github.com/PHPCompatibility/PHPCompatibilityWP), [PHPCSExtra](https://github.com/PHPCSStandards/PHPCSExtra), and [Slevomat Coding Standard](https://github.com/slevomat/coding-standard).

## Quick start

```bash
composer require --dev wptechnix/wp-coding-standards

# List available standards
phpcs -i

# Lint your plugin with the base standard
phpcs --standard=WPTechnix path/to/your-plugin
```

PHP_CodeSniffer auto-discovers installed standards through [phpcodesniffer-composer-installer](https://github.com/PHPCSStandards/composer-installer).

## Standards overview

There are four standards. Each is complete on its own and resolves everything it needs.

| Standard | What it does |
|----------|--------------|
| `WPTechnix` | Base standard. Enforces WordPress conventions with tab indentation and short arrays. Catches common mistakes, security issues, and compatibility problems. |
| `WPTechnix-PSR4` | Everything in the base, plus PSR-4 file naming (`Plugin.php` instead of `class-plugin.php`). |
| `WPTechnix-PSR` | Everything in the base, plus PSR-4 file naming and PSR-12 formatting (4-space indent, next-line braces, camelCase naming). |
| `WPTechnix-Strict` | Standalone strict analysis standard. Enforces type hints, complexity limits, and import discipline. Works on any PHP codebase, not just WordPress. |

You can use standards together by separating them with a comma:

```bash
phpcs --standard=WPTechnix-PSR,WPTechnix-Strict path/to/file.php
```

## When to use each standard

| Your project | Start with |
|---|---|
| A WordPress plugin with traditional WordPress style | `WPTechnix` |
| A WordPress plugin using PSR-4 autoloading | `WPTechnix-PSR4` |
| A WordPress plugin using PSR-4 and PSR-12 | `WPTechnix-PSR` |
| Any PHP project that needs strict analysis | `WPTechnix-Strict` |
| A PSR-4 WordPress plugin with strict analysis | `WPTechnix-PSR,WPTechnix-Strict` |

## The standards in detail

### WPTechnix

WPTechnix is the foundation. It starts from `WordPress-Extra` and `WordPress-Docs`, then layers on additional checks:

- **VIPCS**: Security, escaping, performance, and hook checks from the WordPress VIP coding standard. Only platform-agnostic rules are included.
- **PHPCompatibilityWP**: Flags functions and syntax that won't work on older PHP versions. Default floor is PHP 8.0; you can change this per project.
- **PHPCSExtra / Universal**: Quality-of-life sniffs like disallowing fully-qualified `true`/`false`/`null`, and flagging `TODO` and `FIXME` comments.
- **Slevomat**: Dead catch detection, unused variables, import hygiene, null-coalescing enforcement, and formatting for modern PHP features (attributes, enums, arrow functions, union and DNF types).

Some WordPress-Extra sniffs are disabled by default because they either require per-project setup or are too opinionated for plugin development:

- **PrefixAllGlobals** (disabled) -- Enable this in your project's `phpcs.xml` with your plugin prefix.
- **CronInterval** (disabled) -- The sniff cannot see cron schedules added through filters.
- **ExceptionNotEscaped** (disabled) -- Exception messages are developer-facing and do not need escaping.
- **UnknownCapability** (disabled) -- Plugins define custom capabilities outside WPCS's fixed list.
- **YodaConditions** (disabled) -- Yoda style is not enforced.

What WPTechnix expects from your code:

- Tab indentation
- Short array syntax (`[]` over `array()`)
- WordPress docblock conventions
- Proper escaping, sanitization, and nonce verification

### WPTechnix-PSR4

This standard is identical to WPTechnix except it changes file naming rules. Instead of requiring `class-{name}.php` filenames, it allows `{Name}.php`.

```
# WPTechnix expects:
src/class-plugin.php
src/class-admin-settings.php

# WPTechnix-PSR4 allows:
src/Plugin.php
src/Admin/Settings.php
```

It also removes the requirement for `@package` tags in docblocks, since they are redundant under PSR-4 namespacing.

### WPTechnix-PSR

This standard combines PSR-4 file naming with PSR-12 formatting. Compared to the base standard, here is what changes:

| Rule | WPTechnix | WPTechnix-PSR |
|------|-----------|---------------|
| Indentation | Tabs | 4 spaces |
| Braces | Same line (K&R) | Next line |
| Naming (`snake_case`) | Enforced | Silenced |
| File naming | `class-{name}.php` | `{Name}.php` |

WPTechnix-PSR is a superset of WPTechnix-PSR4. If you use WPTechnix-PSR, you do not need WPTechnix-PSR4 as well.

### WPTechnix-Strict

WPTechnix-Strict is an additional standard for better strictness.

It enforces:

- **Type hints**: Parameters, return types, properties, and class constants must have type declarations.
- **Complexity limits**: Cognitive complexity (warn at 12, error at 20), cyclomatic complexity (max 10), and nesting level (max 5).
- **OOP design**: Non-interface classes must be `abstract` or `final`. Public properties are forbidden unless `readonly`. Use `self` instead of class name for static references.
- **Code quality**: Prefer early exit over nested `if` blocks. Disallow empty functions and catches. Require null-safe operator where applicable.
- **Import discipline**: Every namespaced reference must be imported with `use`. Fully-qualified global functions and constants are allowed.

Use it alone or layered on top of another standard:

```bash
phpcs --standard=WPTechnix,WPTechnix-Strict path/to/file.php
# OR 
phpcs --standard=WPTechnix-PSR4,WPTechnix-Strict path/to/file.php
# OR
phpcs --standard=WPTechnix-PSR,WPTechnix-Strict path/to/file.php
```

## Configuration in your project

Create a `phpcs.xml` file at the root of your project:

```xml
<?xml version="1.0"?>
<ruleset name="MyProject">
    <description>My project coding standard</description>

    <!-- Choose your standards -->
    <rule ref="WPTechnix" />
    <!-- OR <rule ref="WPTechnix-PSR" /> -->
    <rule ref="WPTechnix-Strict" />

    <!-- Set your PHP version for compatibility checks -->
    <!-- 8.2- means PHP 8.2 and above -->
    <config name="testVersion" value="8.2-" />

    <!-- Set your plugin textdomain for i18n checks -->
    <rule ref="WordPress.WP.I18n">
        <properties>
            <property name="textdomain" value="my-plugin" />
        </properties>
    </rule>

    <!-- Enable prefix checks with your plugin slug -->
    <rule ref="WordPress.NamingConventions.PrefixAllGlobals">
        <properties>
            <property name="prefixes" type="array">
                <element value="myplugin" />
            </property>
        </properties>
    </rule>
</ruleset>
```

Then run:

```bash
phpcs
```

## Requirements

- PHP 8.0 or later
- Composer

## License

MIT
