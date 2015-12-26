#!/bin/bash

wget -O /dev/null http://localhost/csi/?task=queue.execute

sleep 20s

wget -O /dev/null http://localhost/csi/?task=queue.execute

sleep 20s

wget -O /dev/null http://localhost/csi/?task=queue.execute
