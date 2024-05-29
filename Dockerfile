FROM nixos/nix

# Copy project files
COPY . .

# Install PHP and necessary extensions
RUN nix-env -iA nixpkgs.php81 nixpkgs.php81Extensions.fileinfo nixpkgs.pecl_http nixpkgs.mysql \
    && nix-collect-garbage -d \
    && composer install

# Expose the port your app runs on
EXPOSE 8000

# Command to run your app
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
