# cacti-notifications-api

REST API and WebPush notifications for Cacti network monitoring service.
Used for building mobile applications, tiny web clients etc.

### /login (POST)
Get auth token by cacti's user/password.
```
input:
{
    username: 'user',
    password: 'password'
}

output:
{
    message: '', 
    token: 'password'
}
```
- message - empty or 'NOT_AUTHORIZED'
- token should be set to Http Header  'Token' for each request

### /hosts/all (GET)
Get all hosts from cacti.
```
output:
{
    message: '', 
    hosts: []
}
```
### /hosts/down (GET)
Get only down-state hosts from cacti.
```
output:
{
    message: '', 
    hosts: []
}
```
### /subscription (POST)
Subscribe your browser to WebPush notifications.
```
input:
{
    endpoint: 'your endpoint',
    publicKey: 'your publicKey',
    authToken: 'your authToken',
}

output:
{
    message: ''
}
```
### /subscription (PUT)
Update subscription.
```
input:
{
    endpoint: 'your endpoint',
    publicKey: 'your publicKey',
    authToken: 'your authToken',
}

output:
{
    message: ''
}
```
### /subscription (DELETE)
Unsubscribe your browser from WebPush notifications.
```
input:
{
    endpoint: 'your endpoint'
}

output:
{
    message: ''
}
```
## .envs
Copy and edit following configuration files:
```
cp compose/confs_web/.env.example compose/confs_web/.env

cp deploy/.env.example deploy/.env

cp deploy/inventory.example deploy/inventory
```

## PWA keys:
```
cd certs && make pwakeys
```
## Run dev container:
```
make up &
make migrate 
```
## Deploy to server:
```
git checkout -b deploy
git merge main
cd deploy && make deploy
```
