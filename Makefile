dependencies:
	# Install Composer dependencies optimized for production.
	composer install --prefer-dist --optimize-autoloader --no-dev

	# Install Node.js dependencies and optimize the assets for production.
	npm install

deploy: dependencies
	# Optimize the application for serverless environments.
	php artisan optimize:serverless

	# Start deployment
	npx serverless deploy --verbose

	# Run other tasks after the deployment is finished.
	# vendor/bin/bref cli laravel-production-artisan migrate -- --force

	# Fix local development
	php artisan optimize:clear
