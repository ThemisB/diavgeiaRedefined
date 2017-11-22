#!/bin/sh
mongo admin --eval 'db.shutdownServer()' > /dev/null
kill -9 $(ps aux |  grep [f]useki | awk '{print $2}')
