pipeline {
    agent any

    options {
        disableConcurrentBuilds()
        timestamps()
    }

    stages {
        stage('Build') {
            steps {
                sh '''
                    set -eu

                    php -v
                    composer --version

                    composer install \
                        --no-interaction \
                        --prefer-dist \
                        --no-progress

                    composer check-platform-reqs
                '''
            }
        }

        stage('Test') {
            steps {
                sh '''
                    set -eu

                    cp .env.example .env
                    php artisan config:clear

                    APP_ENV=testing \
                    APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= \
                    DB_CONNECTION=sqlite \
                    DB_DATABASE=:memory: \
                    SESSION_DRIVER=array \
                    CACHE_STORE=array \
                    QUEUE_CONNECTION=sync \
                    php artisan test
                '''
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                    set -eu
                    umask 0002

                    target=/var/www/jenkinslab

                    rsync -rlt --delete \
                        --exclude='.git/' \
                        --exclude='.env' \
                        --exclude='vendor/' \
                        --exclude='node_modules/' \
                        --exclude='storage/' \
                        --exclude='bootstrap/cache/' \
                        --exclude='database/*.sqlite*' \
                        ./ "$target/"

                    cd "$target"

                    composer install \
                        --no-dev \
                        --no-interaction \
                        --prefer-dist \
                        --no-progress \
                        --optimize-autoloader

                    php artisan config:clear
                    php artisan migrate --force
                    php artisan config:cache
                    php artisan view:cache

                    chmod -R g+rwX storage bootstrap/cache

                    curl --fail --silent --show-error \
                        --resolve 98.93.211.129:80:127.0.0.1 \
                        http://98.93.211.129/ > /dev/null

                    echo "Deployment successful."
                '''
            }
        }
    }

    post {
        success {
            echo 'Build, Test and Deploy completed successfully!'
        }

        failure {
            echo 'Pipeline failed. Check Console Output.'
        }
    }
}
