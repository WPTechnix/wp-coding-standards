# Changelog

All notable changes to this project are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [1.1.1] — 2026-07-28

### Fixed

* **composer.json**: Removed `config.platform.php` entry to fix dependency resolution on PHP 8.1+ — Composer now uses the actual runtime version instead of a hardcoded 8.0 baseline.

### Changed

* **composer.json**: Restricted the PHP requirement to `^8.0` (was `>=8.0`) to guard against untested PHP 9.x installations.

## [1.1.0] — 2026-07-16

### Changed

* **WPTechnix**: Relaxed PHPDoc enforcement by disabling `Generic.Commenting.DocComment.MissingShort`, `Squiz.Commenting.FunctionComment.MissingParamTag`, and `Squiz.Commenting.FunctionComment.MissingReturnTag`. This avoids requiring redundant short descriptions and duplicate parameter or return documentation for inherited methods.
* **WPTechnix**: Disabled `Squiz.Commenting.FunctionComment.IncorrectTypeHint` to support modern PHPDoc syntax, including advanced PHPStan-compatible types such as `list`, `array<TKey, TValue>`, `class-string`, and other generic type declarations.

## [1.0.3] — 2026-07-11

### Changed

* **WPTechnix**: Moved `ReferenceThrowableOnly`, `StrictCall`, and `RequireNumericLiteralSeparator` from WPTechnix-Strict into the base WPTechnix ruleset with appropriate configuration. Added `Squiz.Commenting.FunctionComment` with `skipIfInheritdoc=true` to avoid redundant docblock enforcement on inherited methods.

### Fixed

* **WPTechnix-Strict**: Commented out `SlevomatCodingStandard.TypeHints.ClassConstantTypeHint` and `UselessConstantTypeHint` — these sniffs require PHP 8.3+ to be effective and were producing irrelevant warnings on the PHP 8.0 baseline.

## [1.0.2] — 2026-07-11

### Fixed

* **WPTechnix-Strict**: Prevented phpcbf from automatically removing intentional PHPDoc annotations that duplicate native PHP type hints. Added severity-0 overrides for `ParameterTypeHint.UselessAnnotation`, `ReturnTypeHint.UselessAnnotation`, and `PropertyTypeHint.UselessAnnotation` to stop automated fixers from stripping explicit documentation.

## [1.0.1] — 2026-07-11

### Changed

* **WPTechnix**: Removed deprecated `SlevomatCodingStandard.TypeHints.UnionTypeHintFormat` sniff (deprecated since Slevomat CS 8.16.0). The replacement `DNFTypeHintFormat` sniff was already configured with equivalent property values — no behavior change.

## [1.0.0] — 2026-07-08

### Added

* **WPTechnix** — Base WordPress coding standard. Inherits `WordPress-Extra` and `WordPress-Docs`, then layers on a platform-agnostic VIPCS subset (security, escaping, performance, hooks), `PHPCompatibilityWP` (default PHP floor: 8.0), and a curated Slevomat selection: dead catch detection, useless variable elimination, import hygiene, null-coalescing enforcement, and modern PHP formatting (attributes, enums, arrow functions, union/DNF types). WordPress conventions throughout: tab indentation, short arrays. Yoda conditions are not enforced.

* **WPTechnix-PSR4** — PSR-4 file naming standard. Silences `WordPress.Files.FileName` and the redundant `@package` tag so classes live as `Plugin.php` rather than `class-plugin.php`. Inherits the base.

* **WPTechnix-PSR** — Unified PSR standard combining PSR-4 file naming with PSR-12 formatting: 4-space indent, next-line braces, no `snake_case` enforcement. References `PSR12` (excluding `PSR1.Files.SideEffects`), enables `SlevomatCodingStandard.PHP.ShortList`, and silences conflicting WordPress formatting sniffs via severity overrides rather than exclusions to ensure correct merge resolution regardless of combination order. Inherits the base.

* **WPTechnix-Strict** — WordPress-independent static analysis standard for any PHP 8.0+ codebase. Enforces parameter, return, property, and class constant type hints; cognitive (warn 12 / error 20), cyclomatic (10), and nesting (5) complexity limits; `abstract`/`final` on non-interface classes, `self` references, and readonly-allowed public property restrictions; early exit, null-safe operator, unused variable, strict call, and non-capturing catch rules; and mandatory import of all namespaced references. Standalone — does not depend on WPTechnix.

* `README.md` documenting architecture, layering model, standard selection guidance, comparison table, and usage.

* `CHANGELOG.md` — this file.

* `composer.json` declaring `wptechnix/wp-coding-standards` (type: `phpcodesniffer-standard`) and requiring `wp-coding-standards/wpcs: ^3.3.0`, `automattic/vipwpcs: ^3.0.1`, `phpcompatibility/phpcompatibility-wp: ^2.1.8`, `slevomat/coding-standard: ~8.22.0`, `squizlabs/php_codesniffer: ^3.13.5`, and `dealerdirect/phpcodesniffer-composer-installer: ^1.1.2`.

* Composer scripts for listing registered standards, explaining resolved sniff sets, validating all rule combinations (`validate-rulesets`), and linting formatting fixtures (`lint:fixtures`).

* CI workflow (`.github/workflows/rulesets.yml`) that runs `composer validate`, `composer validate-rulesets`, and `composer lint:fixtures` on PHP 8.0 and 8.3 for every push and pull request to `main`.

* Commit lint workflow (`.github/workflows/commitlint.yml`) enforcing conventional commit format.

* Wiki sync workflow (`.github/workflows/wiki.yml`) publishing `docs/` to the repository wiki on push.

* Dependabot configuration (`.github/dependabot.yml`) for weekly Composer and GitHub Actions updates.

* Docker-based Composer runner (`scripts/composer`, `scripts/Dockerfile`) using the official `composer:2.8` image with a persistent cache volume, removing the need for a host PHP installation.

* Test fixtures (`tests/fixtures/wp-style.php`, `tests/fixtures/psr-style.php`) exercising both formatting regimes to confirm deadlock-free operation across all standard combinations.

[1.0.0]: https://github.com/WPTechnix/wp-coding-standards/releases/tag/v1.0.0
[1.0.1]: https://github.com/WPTechnix/wp-coding-standards/releases/tag/v1.0.1
[1.0.2]: https://github.com/WPTechnix/wp-coding-standards/releases/tag/v1.0.2
[1.0.3]: https://github.com/WPTechnix/wp-coding-standards/releases/tag/v1.0.3
[1.1.1]: https://github.com/WPTechnix/wp-coding-standards/releases/tag/v1.1.1
[1.1.0]: https://github.com/WPTechnix/wp-coding-standards/releases/tag/v1.1.0

One small suggestion: I'd group the first three bullets into a single item about inherited PHPDoc and keep the advanced type support as a separate bullet. That makes the changelog slightly shorter while conveying the same information.
