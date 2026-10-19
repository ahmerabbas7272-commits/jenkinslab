pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Starting Laravel Build...'

                sh '''
                    php -v
                    composer --version
                    composer install --no-interaction --prefer-dist --no-progress
                '''
            }
        }

        stage('Test') {
            steps {
                echo 'Running Laravel Tests...'

                sh '''
                    cp .env.example .env
                    php artisan key:generate

                    APP_ENV=testing \
                    DB_CONNECTION=sqlite \
                    DB_DATABASE=:memory: \
                    php artisan test
                '''
            }
        }

        stage('Deploy') {
            steps {
                echo 'Deployment Stage Started'
                echo 'AWS EC2 deployment will be configured next'
            }
        }
    }

    post {
        success {
            echo 'Jenkins Pipeline Completed Successfully!'
        }

        failure {
            echo 'Jenkins Pipeline Failed!'
        }
    }
}
