#!/usr/bin/env sh

#
# replace YOUR_PROJECT_ROOT, YOUR_DEBUG_DIR and YOUR_SPHINX_BIN with your paths
#

YOUR_PROJECT_ROOT/order db:sphinx -r
echo ''

cp -f YOUR_PROJECT_ROOT/drafts/sphinx/sphinx.conf.mj ./sphinx.conf.mj
sed -i "s/@CONFDIR@/YOUR_DEBUG_DIR/g" sphinx.conf.mj

YOUR_SPHINX_BIN/indexer --config sphinx.conf.mj --all
YOUR_SPHINX_BIN/searchd --config sphinx.conf.mj

# on windows .exe may be required