FROM php:8.3-cli

WORKDIR /app

# Copy test runner and dependencies (none).
COPY ./tests/ /app/

CMD ["php", "/app/instanceof_test.php"]

