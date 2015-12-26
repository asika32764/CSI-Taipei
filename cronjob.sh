#!/bin/bash

wget -O /dev/null http://localhost/csi/?option=com_csi&task=queue.execute

sleep 20s

wget -O /dev/null http://localhost/csi/?option=com_csi&task=queue.execute

sleep 20s

wget -O /dev/null http://localhost/csi/?option=com_csi&task=queue.execute
