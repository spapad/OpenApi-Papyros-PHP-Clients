#!/bin/sh 

curl -v -X POST \
	--header "User-Agent: MINEDU OSTEAM Tester" \
    -F "theme=Title" \
    -F "mainDoc=@test2-minimal.pdf" \
    -F "otherDoc=@test3-minimal.pdf" \
	"http://generic.local.dev/public/protocol"
