# ResourceByUrl

The module add a new api endpoint to get resource (Product or Category) key url

## Install

In the magento root folder, run the following commands:

```sh
mkdir -p app/code/Hendel
```

```sh
git clone https://github.com/Hendel-Tecnologia/Magento-ResourceByUrl.git app/code/Hendel/ResourceByUrl
```

```
php bin/magento setup:upgrade
```

## Usage

```
GET /V1/hendel/resourceByUrl/:url
```

The url most be escaped caracter "/" to "%2F".

Example: 
