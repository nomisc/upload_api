# Get the Code

- Pull the code from the repository:

```bash
git clone git@github.com:nomisc/upload_api.git
cd upload_api 
```

# Versions

There are 3 versions in the Git repository, each in a separate branch. The basic functionality is the same, but the difference lies in how users authenticate and how API keys are managed.

To access all branches:

```bash
git fetch --all
git checkout web_versin 
git checkout cli_version 
git checkout basic_version 
```

# Installation

Basic commands to set up the project:

```bash
composer install 
cp .env.example .env 
php artisan migrate  //confirm to create database 
php artisan key:generate 
php artisan serve --port=xxxx
```

## basic_version

In the basic_version, a custom string is entered in the .env file under the key "API_KEYS". You can add multiple keys, separated by '|'.

example:

```bash
API_KEYS=3N5FhW5YuOvzfg==|snaZ4c+amIvK9QLP+sLO
```

Include one of these keys in the curl header with the key ApiToken.

Curl call example:

```bash 
curl -H 'ApiToken: 3N5FhW5YuOvzfg==' -F "file=@/home/simon/demo.png" -F "title=<title>" -F 'description=<description>" -X POST http://localhost:9500/api/upload
```

## cli_version

In the cli_version, users and keys can be managed in the terminal via the php artisan command. There are two commands available:

Add user: ```app:add-user```

Add user with parameters: ```app:add-user <username> <email> <password>```

If partial information is provided with parameters, additional information can be added during the process in the terminal.

List users and generate a new API key:  ``` app:list-users```

Curl call example:

```bash 
curl -H 'Authorization: Bearer [api key generated in app or cli]' -F "file=@/home/simon/demo.png" -F "title=<title>" -F 'description=<description>" -X POST http://localhost:9500/api/upload
```

## web_version

In the web_version, there's a web interface where users can register their accounts. When the user is logged in, the API key can be set or reset in the profile section.

Curl call example:

```bash 
curl -H 'Authorization: Bearer [api key generated in app or cli]' -F "file=@/home/simon/demo.png" -F "title=<title>" -F 'description=<description>" -X POST http://localhost:9500/api/upload
```

# Response

## Invalid file

```json
{
	"message": "There was error in process of uploading file. Check the messages for details!",
	"errors": {
		"file": [
			"The file field must be a file of type: jpeg, png, mp4, svg."
		]
	}
}
```

## Missing field file:

```json
{
	"message": "There was error in process of uploading file. Check the messages for details!",
	"errors": {
		"file": [
			"The file field is required."
		]
	}
}
```

## OK response:

```json
{
	"data": {
		"original_name": "image.png",
		"file_name": "20240403-165958_image.png",
		"file_path": "/project/upload_api/storage/app/upload/20240403-165958_image.png",
		"file_size": 157182,
		"mime_type": "image/png",
		"extension": "png"
	}
}
```

## Unauthorized access

```json
{
	"error": "Unauthorized"
}
```


## Swiching version

When you switch between web_version and the other two, you need to run:
```bash 
composer install 
 ```

For the web_version, it is required to install Vite:

```bash 
npm install vite --save-dev
npm dev build
``` 
