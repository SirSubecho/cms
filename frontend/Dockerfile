FROM node:20-alpine

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install dependencies if node_modules doesn't exist
RUN if [ ! -d "node_modules" ]; then npm install; fi

# Expose port
EXPOSE 9000

# Start development server
CMD ["npx", "quasar", "dev", "--host", "0.0.0.0"]