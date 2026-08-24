pipeline {
    agent any

    environment {
        AWS_REGION = 'ap-south-1'
        ECR_REPO = '861885769722.dkr.ecr.ap-south-1.amazonaws.com/smart-parking'
        ECS_CLUSTER = 'smart-parking-cluster'
        ECS_SERVICE = 'smart-parking-service'
        IMAGE_TAG = "${BUILD_NUMBER}"
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                    docker build -t $ECR_REPO:$IMAGE_TAG .
                    docker tag $ECR_REPO:$IMAGE_TAG $ECR_REPO:latest
                '''
            }
        }

        stage('Login to ECR') {
            steps {
                sh '''
                    aws ecr get-login-password \
                      --region $AWS_REGION | \
                    docker login \
                      --username AWS \
                      --password-stdin $ECR_REPO
                '''
            }
        }

        stage('Push to ECR') {
            steps {
                sh '''
                    docker push $ECR_REPO:$IMAGE_TAG
                    docker push $ECR_REPO:latest
                '''
            }
        }

        stage('Deploy to ECS') {
            steps {
                sh '''
                    aws ecs update-service \
                      --cluster $ECS_CLUSTER \
                      --service $ECS_SERVICE \
                      --force-new-deployment \
                      --region $AWS_REGION
                '''
            }
        }

        stage('Wait for ECS') {
            steps {
                sh '''
                    aws ecs wait services-stable \
                      --cluster $ECS_CLUSTER \
                      --services $ECS_SERVICE \
                      --region $AWS_REGION
                '''
            }
        }
    }

    post {
        success {
            echo 'Smart Parking CI/CD deployment successful!'
        }

        failure {
            echo 'Smart Parking CI/CD deployment failed!'
        }
    }
}
