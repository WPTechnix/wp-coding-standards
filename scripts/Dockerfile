# Minimal, cached toolchain for running Composer + PHP_CodeSniffer locally
# without a host PHP install. Reuses the official Composer image, which already
# ships PHP 8 and Composer 2, so builds take seconds.
#
# Not used at runtime by consumers of this package — it is a developer
# convenience only (see ./scripts/composer and CONTRIBUTING.md).
FROM composer:2.8

# git + unzip let Composer fetch and extract dist packages reliably.
RUN apk add --no-cache git unzip

WORKDIR /app
