#!/usr/bin/env bash
##
# Copyright (C) 2021 Merchant's Edition GbR
#
# NOTICE OF LICENSE
#
# This source file is subject to the Academic Free License (AFL 3.0)
# that is bundled with this package in the file LICENSE.md
# It is also available through the world-wide-web at this URL:
# http://opensource.org/licenses/afl-3.0.php
# If you did not receive a copy of the license and are unable to
# obtain it through the world-wide-web, please send an email
# to contact@merchantsedition.com so we can send you a copy immediately.
#
# @author    Merchant's Edition <contact@merchantsedition.com>
# @copyright 2021 Merchant's Edition GbR
# @license   Academic Free License (AFL 3.0)

function usage {
  echo "Usage: validatecore.sh [-h|--help] [-v|--verbose]"
  echo
  echo "This script runs a couple of plausibility and conformance tests on"
  echo "Merchant's Edition sources contained in the Git repository. Note that"
  echo "files checked into the repository get validated, not the ones on disk."
  echo
  echo "    -h, --help            Show this help and exit."
  echo
  echo "    -v, --verbose         Show (hopefully) helpful hints regarding the"
  echo "                          errors found, like diffs for file content"
  echo "                          mismatches and/or script snippets to fix such"
  echo "                          misalignments."
  echo
  echo "Example:"
  echo
  echo "  cd <repository root>"
  echo "  tools/validatecore.sh"
  echo
}


### Cleanup.
#
# Triggered by a trap to clean on unexpected exit as well.

function cleanup {
  if [ -n ${REPORT} ]; then
    rm -f ${REPORT}
  fi
}
trap cleanup 0


### Options parsing.

OPTION_VERBOSE='false'

while [ ${#} -ne 0 ]; do
  case "${1}" in
    '-h'|'--help')
      usage
      exit 0
      ;;
    '-v'|'--verbose')
      OPTION_VERBOSE='true'
      ;;
    *)
      echo "Unknown option '${1}'. Try ${0} --help."
      exit 1
      ;;
  esac
  shift
done


### Preparations.

# We write into a report file to allow us to a) collect multiple findings and
# b) evaluate the collection before exiting.
REPORT=$(mktemp)
export REPORT

. "${0%/*}/validatecommon.sh"


### File maintenance.

validate_filepermissions

validate_whitespace


### Documentation files.

validate_documentation


### index.php files.

validate_indexphp

# Each index.php should match either the version for thirty bees or the version
# for thirty bees and PrestaShop combined.
COMPARE_1="${TEMPLATES_DIR}/index.php.me.core"
COMPARE_2="${TEMPLATES_DIR}/index.php.metb.core"
COMPARE_3="${TEMPLATES_DIR}/index.php.metbps.core"
COMPARE_SKIP=0
COMPARE_HINT=''
# All index.php files, except those with actual code. See also next step.
COMPARE_LIST=($(${FIND} . \
| grep 'index\.php$' \
| grep -v -e '^index\.php$' \
          -e '^admin-dev/index\.php$' \
          -e '^install-dev/index\.php$' \
          -e '^install-dev/dev/index\.php$'
))
templatecompare


### Code file headers.
#
# Each code file's header is compared against the template for either thirty
# bees or thirty bees and PrestaShop combined and should match one of them.

# PHP and PHTML files.
COMPARE_1="${TEMPLATES_DIR}/header.php-js-css.me.core"
COMPARE_2="${TEMPLATES_DIR}/header.php-js-css.metb.core"
COMPARE_3="${TEMPLATES_DIR}/header.php-js-css.metbps.core"
COMPARE_SKIP=1
COMPARE_HINT='header'
# index.php were validated earlier already.
# lang.php are autogenerated.
# Files in tests/_support/override/ are too short to justify a header.
# Files install-dev/langs/<lang>/install.php are autogenerated.
LIST=($(${FIND} . \
| grep -e '\.php$' \
       -e '\.phtml$' \
| grep -v -e '/index\.php$' \
          -e '/lang\.php$' \
          -e '^tests/_support/override/' \
          -e '^install-dev/langs/../install\.php'
))
COMPARE_LIST=()
for F in "${LIST[@]}"; do
  testignore "${F}" && continue
  COMPARE_LIST+=("${F}")
done
unset LIST
# Add index.php actually containing code. Those excluded in the previous step.
COMPARE_LIST+=('index.php')
COMPARE_LIST+=('admin-dev/index.php')
COMPARE_LIST+=('install-dev/index.php')
COMPARE_LIST+=('install-dev/dev/index.php')
templatecompare

# JS, CSS, Sass and SCSS files.
COMPARE_1="${TEMPLATES_DIR}/header.php-js-css.me.core"
COMPARE_2="${TEMPLATES_DIR}/header.php-js-css.metb.core"
COMPARE_3="${TEMPLATES_DIR}/header.php-js-css.metbps.core"
COMPARE_SKIP=0
COMPARE_HINT='header'
# date-range-picker.js is a bootstrap vendor file.
# js/date.js is (probably) from jQuery.datePicker.
# js/fileuploader.js is apparently an independent vendor file.
# js/rtl.js as well.
# js/validate.js as well, but only the upper half !?!
# Files in admin-dev/themes/default/css are autogenerated.
# All excluded Sass files are independent vendor files.
LIST=($(${FIND} . \
| grep -e '\.js$' \
       -e '\.css$' \
       -e '\.sass$' \
       -e '\.scss$' \
| grep -v -e '^admin-dev/themes/default/js/date-range-picker\.js$' \
          -e '^js/date\.js$' \
          -e '^js/fileuploader\.js$' \
          -e '^js/rtl\.js$' \
          -e '^js/validate\.js$' \
          -e '^admin-dev/themes/default/css' \
          -e '^admin-dev/themes/default/sass/vendor/' \
          -e '^admin-dev/themes/default/sass/partials/_growl.sass$' \
          -e '^admin-dev/themes/default/sass/partials/_ladda.sass$' \
          -e '^admin-dev/themes/default/sass/partials/_select2.scss$' \
          -e '^admin-dev/themes/default/sass/partials/_switch.sass$'
))
COMPARE_LIST=()
for F in "${LIST[@]}"; do
  testignore "${F}" && continue
  COMPARE_LIST+=("${F}")
done
unset LIST
templatecompare


### Evaluation of findings.

cat ${REPORT}

if grep -q '^  Error:' ${REPORT}; then
  if [ ${OPTION_VERBOSE} = 'true' ]; then
    echo
    echo "If these errors were introduced with your last commit, fix them,"
    echo "then use 'git commit --amend' to correct that last commit."
  else
    echo "Errors found. Use --verbose for additional hints."
  fi

  exit 1
else
  echo "Validation succeeded."
  exit 0
fi
