FROM mcr.microsoft.com/devcontainers/php:7-bullseye

# Setup the keys again for apt-get, seems to be an issue with php 7 package
ENV YARNKEY=yarn-keyring.gpg
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo gpg --dearmour -o /usr/share/keyrings/$YARNKEY && \
  echo "deb [signed-by=/usr/share/keyrings/$YARNKEY] https://dl.yarnpkg.com/debian stable main" | sudo tee /etc/apt/sources.list.d/yarn.list

# Install libzip and libpng (needed for GD)
RUN apt-get update && apt-get install -y --no-install-recommends \
  libzip-dev libpng-dev \ 
  && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install gd
RUN docker-php-ext-install gd