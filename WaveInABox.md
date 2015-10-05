# windows version #

## run-config.bat ##
```
REM!/bin/bash

REM Configuration for Wave in a Box run scripts without federation support.  To add
REM federation support see run-config.sh.example.

REM Domain name of the wave server
set WAVE_SERVER_DOMAIN_NAME=h.com

REM A comma separated list of address on which to listen for connections.
REM Each address is a comma separated host:port pair.
set HTTP_SERVER_PUBLIC_ADDRESS=h.com:9898
set HTTP_SERVER_ADDRESSES=%HTTP_SERVER_PUBLIC_ADDRESS%

REM The version of Wave in a Box, extracted from the build.properties file
REM set WAVEINABOX_VERSION=`grep ^waveinabox.version= build.properties | cut -f2 -d=`
set WAVEINABOX_VERSION=0.3

REM Disabled federation, as promised.
set ENABLE_FEDERATION=false

REM These are not used but have to be set to non-empty values.
set XMPP_SERVER_SECRET=opensesame
set PRIVATE_KEY_FILENAME=%WAVE_SERVER_DOMAIN_NAME%.key
set CERTIFICATE_FILENAME_LIST=%WAVE_SERVER_DOMAIN_NAME%.crt
set CERTIFICATE_DOMAIN_NAME=%WAVE_SERVER_DOMAIN_NAME%
set XMPP_SERVER_HOSTNAME=%WAVE_SERVER_DOMAIN_NAME%
set XMPP_SERVER_PORT=5275
set XMPP_SERVER_PING=wavesandbox.com
set XMPP_SERVER_IP=%XMPP_SERVER_HOSTNAME%
set WAVESERVER_DISABLE_VERIFICATION=false
set WAVESERVER_DISABLE_SIGNER_VERIFICATION=true

REM Settings for the different persistence stores. Currently supported: 'memory' and 'mongodb'
set SIGNER_INFO_STORE_TYPE=memory

REM Currently supported attachment types: mongodb, disk
set ATTACHMENT_STORE_TYPE=disk

REM The location where attachments are stored on disk. This should be changed.
REM Note: This is only used when using the disk attachment store. It is ignored
REM for other data store types.
set ATTACHMENT_STORE_DIRECTORY=_attachments

REM Currently supported Account store types: fake, memory, file, mongodb
set ACCOUNT_STORE_TYPE=memory

REM Set true to use Socket.IO instead of raw WebSockets in the webclient.
set USE_SOCKETIO=false
```

## run-server.bat ##

```
set ARGC=0
set SUSPEND="n"
set DEBUG_MODE="off"
set DEBUG_PORT="not set"
set DEBUG_FLAGS=-Xrunjdwp:transport=dt_socket,server=y,suspend=%SUSPEND%,address=%DEBUG_PORT%

java %DEBUG_FLAGS% -Dorg.eclipse.jetty.util.log.DEBUG=false  -Djava.security.auth.login.config=jaas.config  -jar dist/waveinabox-server-%WAVEINABOX_VERSION%.jar  --wave_server_domain=%WAVE_SERVER_DOMAIN_NAME%  --xmpp_component_name=wave  --xmpp_jid=wave.%WAVE_SERVER_DOMAIN_NAME%  --xmpp_server_description="Wave in a Box"  --xmpp_server_hostname=%XMPP_SERVER_HOSTNAME%  --xmpp_server_ip=%XMPP_SERVER_IP%  --xmpp_server_port=%XMPP_SERVER_PORT%  --xmpp_server_secret %XMPP_SERVER_SECRET%  --xmpp_server_ping=%XMPP_SERVER_PING%  --certificate_private_key=%PRIVATE_KEY_FILENAME%  --certificate_files=%CERTIFICATE_FILENAME_LIST%  --certificate_domain=%CERTIFICATE_DOMAIN_NAME%  --waveserver_disable_verification=%WAVESERVER_DISABLE_VERIFICATION%  --waveserver_disable_signer_verification=%WAVESERVER_DISABLE_SIGNER_VERIFICATION%  --http_frontend_public_address=%HTTP_SERVER_PUBLIC_ADDRESS%  --http_frontend_addresses=%HTTP_SERVER_ADDRESSES%  --enable_federation=%ENABLE_FEDERATION%  --signer_info_store_type=%SIGNER_INFO_STORE_TYPE% --signer_info_store_directory=%SIGNER_INFO_STORE_DIRECTORY%  --attachment_store_type=%ATTACHMENT_STORE_TYPE%  --attachment_store_directory=%ATTACHMENT_STORE_DIRECTORY%  --account_store_type=%ACCOUNT_STORE_TYPE%  --account_store_directory=%ACCOUNT_STORE_DIRECTORY%  --use_socketio=%USE_SOCKETIO%
```