
```
sudo apt-get install rake ruby-bundler mysql-client libmysqlclient-dev libmagickwand-dev libapache2-mod-fcgid libapache2-mod-passenger
bundle
```

```
specifying adapter mysql2 instead of mysql in config/database.yml
```


## incompatible character encodings: ASCII-8BIT and UTF-8 ##

> The real problem isn't in redmine or the packaging, but there's a bug in the rails rake task which ignores settings in the config.paths["tmp"], not to mention session\_store, etc. and just mindlessly deletes "tmp/cache" content