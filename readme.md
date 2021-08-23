<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

This application contains an example of how to deploy Laravel 8.x as a lambda function in aws. The resources that you will create in your aws account after run `serverless deploy` are the following.

- Laravel Function.
- Artisan Function.
- HTTP entry point using AWS API Gateway.

### Prerequisites

- AWS account and a user with [programmatic access via API](https://docs.aws.amazon.com/rekognition/latest/dg/setting-up.html#setting-up-iam) with the necessary permissions.
- Composer
- Node.js

### Get started

#### Clone the repository and configure it.

```sh
# Clone this project
git clone --depth 1 https://github.com/gregorip02/laravel-lambda.git

cd laravel-lambda

# Setup environment file
cp .env.example .env

# Generate an application key and copy it to your environment variables file.
echo "base64:$(openssl rand -base64 32)"
```

```dotenv
# .env
APP_KEY=base64:e4IiYMsTe+n+NZMjgPZyCL4kKWJ2y0itnYGqk2ZBJ7c=
```

#### Configure your serverless credentials using:

```sh
npx serverless config credentials --provider aws --key YOUR-AWS-KEY --secret YOUR-AWS-SECRET -o
```

#### Deploy.

```sh
make deploy
```
