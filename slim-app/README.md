# Δοκιμαστικές κλήσεις 

http://generic.local.dev/public/ping


http://generic.local.dev/public/apikey


http://generic.local.dev/public/docdata/43AHBTWUtcX9a4KhU8eXBg%3D%3D
http://generic.local.dev/public/docdata/43AHBTWUtcX9a4KhU8eXBg%3D%3D/eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIxMDAwMDAwIn0.dW6qmMRJoGL8nA6j5U2zLYJUSc9mnoWioqXsC0D80OE


http://generic.local.dev/public/search
http://generic.local.dev/public/search/incoming
http://generic.local.dev/public/search?date_from=2016-12-01
http://generic.local.dev/public/search?sender_id=100000001&date_from=2016-12-01&date_to=2016-12-22


http://generic.local.dev/public/pdf/Q%2BnehDdzn91TSuVrWOWtoQ%3D%3D
http://generic.local.dev/public/pdf/Q%2BnehDdzn91TSuVrWOWtoQ%3D%3D/eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIxMDAwMDAwIn0.dW6qmMRJoGL8nA6j5U2zLYJUSc9mnoWioqXsC0D80OE
http://generic.local.dev/public/pdf/download/Q%2BnehDdzn91TSuVrWOWtoQ%3D%3D


Αποστολή αρχείου για πρωτοκόλληση 


```sh
#!/bin/sh 

curl -v -X POST \
	--header "User-Agent: MINEDU OSTEAM Tester" \
    -F "theme=Title" \
    -F "mainDoc=@test3-minimal.pdf" \
    -F "otherDoc=@test3-minimal.pdf" \
	"http://localhost/devel/OpenApi-Papyros-PHP-Clients/slim-app/public/protocol"
```

# Σχετικά με την εφαρμογή

Η εφαρμογή δημιουργήθηκε με σημείο εκκίνησης το Slim Framework 3 Skeleton Application.
Περισσότερες λεπτομέρειες στη [σελίδα του Slim-Skeleton](https://github.com/slimphp/Slim-Skeleton)

**Σημαντικό!** Για να τρέξει η εφαρμογή είναι απαραίτητο μετά τη λήψη της
να εκτελέσετε την εντολή `composer install` μέσα στο ριζικό της φάκελο
(\slim-app).
