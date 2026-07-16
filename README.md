# WPTechnix Coding Standards

[![Validate Rulesets](https://github.com/WPTechnix/wp-coding-standards/actions/workflows/rulesets.yml/badge.svg)](https://github.com/WPTechnix/wp-coding-standards/actions/workflows/rulesets.yml)

A collection of PHP_CodeSniffer standards for modern WordPress development.

WPTechnix builds on established community standards instead of replacing them. It combines the best parts of WPCS, VIPCS, PHPCompatibilityWP, PHPCSExtra, and Slevomat Coding Standard into a small set of ready-to-use rulesets for WordPress plugins and general PHP projects.

## Features

* Four ready-to-use coding standards.
* WordPress and PSR coding styles.
* PHP 8.0+ compatibility checks.
* Security, escaping, sanitization, and performance checks.
* Modern PHP support, including attributes, enums, arrow functions, and advanced PHPDoc syntax.
* Optional strict analysis for larger projects.
* Fully Composer installable.

The bundled standards are built on:

* [WordPress Coding Standards (WPCS)](https://github.com/WordPress/WordPress-Coding-Standards)
* [WordPress VIP Coding Standards (VIPCS)](https://github.com/Automattic/VIP-Coding-Standards)
* [PHPCompatibilityWP](https://github.com/PHPCompatibility/PHPCompatibilityWP)
* [PHPCSExtra](https://github.com/PHPCSStandards/PHPCSExtra)
* [Slevomat Coding Standard](https://github.com/slevomat/coding-standard)

---

# Installation

Install with Composer:

```bash
composer require --dev wptechnix/wp-coding-standards
```

PHP_CodeSniffer standards are registered automatically through `dealerdirect/phpcodesniffer-composer-installer`.

Verify the installation:

```bash
phpcs -i
```

Example:

```bash
phpcs --standard=WPTechnix path/to/plugin
```

---

# Included standards

The package contains four standards.

| Standard           | Description                                                 |
| ------------------ | ----------------------------------------------------------- |
| `WPTechnix`        | Base WordPress coding standard.                             |
| `WPTechnix-PSR4`   | Base standard with PSR-4 file naming.                       |
| `WPTechnix-PSR`    | Base standard with PSR-4 file naming and PSR-12 formatting. |
| `WPTechnix-Strict` | Standalone strict analysis standard for any PHP project.    |

Standards can be combined.

```bash
phpcs --standard=WPTechnix-PSR,WPTechnix-Strict src
```

---

# Which standard should I use?

| Project type                             | Recommended standard             |
| ---------------------------------------- | -------------------------------- |
| Traditional WordPress plugin             | `WPTechnix`                      |
| WordPress plugin using PSR-4 autoloading | `WPTechnix-PSR4`                 |
| WordPress plugin using PSR-12 formatting | `WPTechnix-PSR`                  |
| General PHP project                      | `WPTechnix-Strict`               |
| Modern PSR-based WordPress plugin        | `WPTechnix-PSR,WPTechnix-Strict` |

---

# Standards

## WPTechnix

WPTechnix is the primary WordPress standard.

It starts with `WordPress-Extra` and `WordPress-Docs`, then layers additional quality, compatibility, and modern PHP checks while intentionally avoiding rules that require project-specific configuration or create unnecessary noise.

### Included checks

#### WordPress Coding Standards

Provides the familiar WordPress coding style together with checks for:

* Escaping
* Sanitization
* Nonce verification
* Hook usage
* Internationalization
* SQL safety
* File naming
* WordPress coding conventions

#### WordPress VIP Coding Standards

Includes a carefully selected subset of platform-independent VIP rules covering:

* Security
* Performance
* Escaping
* Hook validation

Platform-specific VIP sniffs are intentionally excluded.

#### PHPCompatibilityWP

Detects language features and functions that are incompatible with older PHP versions.

The default compatibility target is PHP 8.0 and above.

Projects can override this using the `testVersion` configuration.

#### PHPCSExtra

Adds additional quality checks including:

* `TODO`
* `FIXME`
* Fully-qualified `true`, `false`, and `null`
* Various small consistency improvements

#### Slevomat Coding Standard

Adds modern PHP analysis including:

* Dead catch detection
* Unused variables
* Import hygiene
* Null coalescing recommendations
* Attributes
* Enums
* Arrow functions
* Union and DNF types
* Modern PHPDoc syntax, including generic and PHPStan-compatible types

---

### PHPDoc philosophy

WPTechnix follows WordPress documentation conventions while avoiding unnecessary duplication.

The standard intentionally:

* Supports inherited documentation using `@inheritDoc`.
* Supports modern PHPDoc syntax such as `list`, `array<TKey, TValue>`, `class-string`, and other generic type declarations.
* Does not require redundant summaries or duplicate parameter and return documentation for inherited methods.

---

### Disabled by default

Some upstream sniffs are intentionally disabled because they require project-specific configuration or frequently produce false positives.

| Sniff                 | Reason                                                                   |
| --------------------- | ------------------------------------------------------------------------ |
| `PrefixAllGlobals`    | Requires each project to define its own prefixes.                        |
| `CronInterval`        | Cannot detect cron schedules registered through filters.                 |
| `ExceptionNotEscaped` | Exception messages are intended for developers rather than end users.    |
| `UnknownCapability`   | Plugins commonly register custom capabilities outside the built-in list. |
| `YodaConditions`      | Yoda conditions are not enforced.                                        |

---

### Coding style

WPTechnix expects:

* Tabs for indentation
* Short array syntax (`[]`)
* WordPress coding conventions
* Modern PHPDoc
* Secure coding practices
* Proper escaping and sanitization

---

## WPTechnix-PSR4

WPTechnix-PSR4 is identical to WPTechnix except for file naming.

Instead of WordPress-style filenames:

```text
src/class-plugin.php
src/class-admin-settings.php
```

it allows standard PSR-4 filenames:

```text
src/Plugin.php
src/Admin/Settings.php
```

It also removes the requirement for `@package` annotations because namespaces already provide the necessary organization.

---

## WPTechnix-PSR

WPTechnix-PSR builds on WPTechnix-PSR4 by replacing WordPress formatting rules with PSR-12 formatting.

| Rule                     | WPTechnix           | WPTechnix-PSR |
| ------------------------ | ------------------- | ------------- |
| Indentation              | Tabs                | Four spaces   |
| Braces                   | K&R                 | Next line     |
| `snake_case` enforcement | Yes                 | No            |
| File naming              | `class-example.php` | `Example.php` |

`WPTechnix-PSR` already includes the functionality of `WPTechnix-PSR4`. There is no need to enable both simultaneously.

---

## WPTechnix-Strict

WPTechnix-Strict is a standalone standard that adds stricter static analysis and code quality checks for modern PHP projects.

Unlike the other standards, it is **not** WordPress-specific and does **not** depend on `WPTechnix`. It can be used with any PHP 8.0+ codebase or layered on top of another WPTechnix standard.

### Included checks

#### Type declarations

Encourages modern PHP type safety by enforcing:

* Parameter type declarations
* Return type declarations
* Property type declarations
* Detection of redundant class constant type declarations where supported by the configured PHP version

#### Code quality

Improves maintainability by enforcing:

* `declare(strict_types=1);`
* Early returns over deeply nested conditionals
* Static closures where possible
* Null-safe operator usage where applicable
* No empty functions
* No empty `empty()` control structures
* No implicit array creation
* `nowdoc` where interpolation is unnecessary
* Non-capturing `catch` blocks where the exception variable is unused

#### Object-oriented design

Encourages consistent object-oriented design:

* Classes should be `abstract` or `final`
* Prefer `self` over repeating the current class name
* Public properties are discouraged unless `readonly`

#### Complexity metrics

Helps prevent overly complex code by enforcing:

| Metric                | Warning |            Error |
| --------------------- | ------: | ---------------: |
| Cognitive complexity  |      12 |               20 |
| Cyclomatic complexity |       — | 10 (20 absolute) |
| Nesting level         |       — |  5 (10 absolute) |

#### Import discipline

Encourages consistent namespace usage by requiring imported namespaced symbols while allowing normal use of global PHP functions and constants.

---

## Combining standards

`WPTechnix-Strict` is designed to complement the other standards.

Examples:

```bash
phpcs --standard=WPTechnix,WPTechnix-Strict src
```

```bash
phpcs --standard=WPTechnix-PSR4,WPTechnix-Strict src
```

```bash
phpcs --standard=WPTechnix-PSR,WPTechnix-Strict src
```

---

# Project configuration

Create a `phpcs.xml` file in the root of your project.

```xml
<?xml version="1.0"?>
<ruleset name="My Project">
    <description>Project coding standard</description>

    <!-- Choose one -->
    <rule ref="WPTechnix" />
    <!-- <rule ref="WPTechnix-PSR4" /> -->
    <!-- <rule ref="WPTechnix-PSR" /> -->

    <!-- Optional -->
    <rule ref="WPTechnix-Strict" />

    <!-- PHP compatibility target -->
    <!-- 8.2- means PHP 8.2 and newer -->
    <config name="testVersion" value="8.2-" />

    <!-- Configure your text domain -->
    <rule ref="WordPress.WP.I18n">
        <properties>
            <property name="textdomain" value="my-plugin" />
        </properties>
    </rule>

    <!-- Enable project-specific prefix checks -->
    <rule ref="WordPress.NamingConventions.PrefixAllGlobals">
        <properties>
            <property name="prefixes" type="array">
                <element value="myplugin" />
            </property>
        </properties>
    </rule>
</ruleset>
```

Run PHPCS:

```bash
phpcs
```

Or scan a specific directory:

```bash
phpcs src
```

Automatically fix supported issues:

```bash
phpcbf
```

---

# Frequently customized options

Most projects customize only three things:

| Option              | Purpose                                                    |
| ------------------- | ---------------------------------------------------------- |
| `testVersion`       | Select the minimum supported PHP version.                  |
| `WordPress.WP.I18n` | Configure your plugin text domain.                         |
| `PrefixAllGlobals`  | Enable global prefix validation using your project prefix. |

Everything else works with the default configuration.

---

# Requirements

* PHP 8.0 or later
* Composer

All PHPCS dependencies are installed automatically through Composer.

---

# Contributing

Bug reports, suggestions, and pull requests are welcome.

If you discover a false positive or believe a sniff should be configured differently, please open an issue describing the problem together with a reproducible example.

---

# License

MIT
