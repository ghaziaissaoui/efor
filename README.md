# EFOR Group

#### With the CosaVostra project installer
```bash
bash <(curl -s 'https://install.cosavostra.com/') --vhost=efor-group.localhost --path=/var/www/html/efor-group/ --yes "EFOR Group (wordpress)"
```

That's all! You can now access to your local project on http://efor-group.localhost

#### Manual installation:
- Clone project into a dedicated folder
- Download and unzip content of WordPress core:
  ```
  wget https://fr.wordpress.org/wordpress-latest-fr_FR.zip
  unzip -qq wordpress-latest-fr_FR.zip
  rm wordpress-latest-fr_FR.zip
  rsync -a wordpress/ ./
  rm -rf wordpress/
  ```
- Run installation (you can use `php -S localhost:8000` or create a local virtual host).
- See [theme README](wp-content/themes/efor-group/README.md)
