PWA_KEYCERT=.secrets/pwa_private_key.pem
PWA_KEYPUB=.secrets/pwa_public_key.txt
PWA_KEYPRIV=.secrets/pwa_private_key.txt

SSL_DOMAIN="local.my"
SSL_KEYCERT=.secrets/ssl_$(SSL_DOMAIN).crt
SSL_KEY=.secrets/ssl_$(SSL_DOMAIN).key
	
pwakeys:
	openssl ecparam -genkey -name prime256v1 -out $(PWA_KEYCERT)
	openssl ec -in $(PWA_KEYCERT) -pubout -outform DER|tail -c 65|base64|tr -d '='|tr '/+' '_-'|tr -d '\n' >> $(PWA_KEYPUB)
	openssl ec -in $(PWA_KEYCERT) -outform DER|tail -c +8|head -c 32|base64|tr -d '='|tr '/+' '_-'|tr -d '\n' >> $(PWA_KEYPRIV)

mkcert:
	mkcert -install
	mkcert -cert-file $(SSL_KEYCERT) -key-file $(SSL_KEY) $(SSL_DOMAIN)
