#!/bin/sh 

curl -v -X POST \
	--header "User-Agent: MINEDU OSTEAM Tester" \
    -F "theme=Title" \
    -F "mainDoc=@test3-minimal.pdf" \
    -F "otherDoc=@test3-minimal.pdf" \
	"http://localhost/devel/OpenApi-Papyros-PHP-Clients/slim-app/public/protocol"
