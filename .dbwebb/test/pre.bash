#!/usr/bin/env bash
case $TESTSUITE in
    kmom01)
        export TARGET_DIR="me/game"
        export LOW_TAG="1.0.0"
        export HIGH_TAG="2.0.0"
        export NUM_TAGS=1
        export NUM_COMMITS=5
        export CHECK_DIRS=".git"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
    kmom02)
        export TARGET_DIR="me/game"
        export LOW_TAG="2.0.0"
        export HIGH_TAG="3.0.0"
        export NUM_TAGS=2
        export NUM_COMMITS=10
        export CHECK_DIRS=".git doc/yatzy"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
    kmom03)
        export TARGET_DIR="me/game"
        export LOW_TAG="3.0.0"
        export HIGH_TAG="4.0.0"
        export NUM_TAGS=3
        export NUM_COMMITS=15
        export CHECK_DIRS=".git doc/yatzy"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
    kmom04)
        export TARGET_DIR="me/framework"
        export LOW_TAG="1.0.0"
        export HIGH_TAG="2.0.0"
        export NUM_TAGS=1
        export NUM_COMMITS=5
        export CHECK_DIRS=".git"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
    kmom05)
        export TARGET_DIR="me/orm"
        export LOW_TAG="5.0.0"
        export HIGH_TAG="6.0.0"
        export NUM_TAGS=2
        export NUM_COMMITS=10
        export CHECK_DIRS=".git"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
    kmom06)
        export TARGET_DIR="me/ci"
        export LOW_TAG="6.0.0"
        export HIGH_TAG="7.0.0"
        export NUM_TAGS=3
        export NUM_COMMITS=15
        export CHECK_DIRS=".git"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
    kmom10)
        export TARGET_DIR="me/proj"
        export LOW_TAG="7.0.0"
        export HIGH_TAG="8.0.0"
        export NUM_TAGS=2
        export NUM_COMMITS=20
        export CHECK_DIRS=".git doc/design"
        export CHECK_FILES="composer.json Makefile README.md"
    ;;
esac
