#!/bin/bash

echo "🚀 Starting CMS Application Setup..."
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker and try again."
    exit 1
fi

# Build and start containers
echo "📦 Building Docker containers..."
docker-compose up -d --build

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
until docker-compose exec -T mysql mysqladmin ping -h localhost --silent; do
    printf '.'
    sleep 2
done
echo ""
echo "✅ MySQL is ready!"

# Wait a bit more to ensure MySQL is fully initialized
sleep 5

# Generate Laravel application key
echo "🔑 Generating Laravel application key..."
docker-compose exec -T backend php artisan key:generate

# Run migrations
echo "📊 Running database migrations..."
docker-compose exec -T backend php artisan migrate --force

# Seed database
echo "🌱 Seeding database with admin user..."
docker-compose exec -T backend php artisan db:seed --force

# Optional: Seed test customers
read -p "Do you want to create 50 test customers? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "👥 Creating test customers..."
    docker-compose exec -T backend php artisan db:seed --class=CustomerMockDataSeeder --force
fi

echo ""
echo "✨ Setup complete!"
echo ""
echo "🌐 Your application is now running:"
echo "   Frontend: http://localhost:9000"
echo "   Backend:  http://localhost:8000"
echo ""
echo "🔐 Default login credentials (check backend/.env):"
echo "   Email:    admin@example.com"
echo "   Password: password"
echo ""
echo "📝 Useful commands:"
echo "   View logs:        docker-compose logs -f"
echo "   Stop services:    docker-compose down"
echo "   Restart:          docker-compose restart"
echo ""