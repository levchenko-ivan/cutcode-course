#!/bin/bash

set -e;

service nginx start;

tail -f /home/entrypoint.sh;
