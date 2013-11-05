[![Build Status](https://travis-ci.org/SEP007/lmvc-utils.png)](https://travis-ci.org/SEP007/lmvc-utils)
[![Coverage Status](https://coveralls.io/repos/SEP007/lmvc-utils/badge.png)](https://coveralls.io/r/SEP007/lmvc-utils)

# lmvc-utils

LMVC-Utils is a set of commonly used utilities by e.g. lmvc, lmvc-modules and troba. Anyhow it aims at being independent
and integratable with any future project.

## StringUtils

A set of string utilities for e.g. capitalization or converting strings from dashed to their camelcased equivalent.

[Readme](lib/Scandio/lmvc/utils/string)

## Bootstrap

A Butler and an Interface for a Bootstrap file used in lmvc to bootstrap modules or utils. The BootstrapInterface's
implementation will be called when giving the `Butler::initialize($namespace)` a correct implementation.

[Readme](lib/Scandio/lmvc/utils/bootstrap)

## Config

A class offering the ability to load json files into a Config manager which will extend entries according to latest-entry
wins. Entries can then easily be used all over an application.

[Readme](lib/Scandio/lmvc/utils/config)

## Logger

An PSR-3 compliant convention-over-configuration logger which can be easily integrated into any lmvc application.
Configuration is accomplished through a `config.json` directive. Moreover, this implementation offers multiple
independent scribes per instance all having a custom *local* LogLevel.

[Readme](lib/Scandio/lmvc/utils/logger)

## Traits

A currently minimal set of traits designed to be applicable in as many use cases as possible.

[Readme](lib/Scandio/lmvc/utils/traits)