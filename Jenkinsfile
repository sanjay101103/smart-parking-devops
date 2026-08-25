pipeline {
    agent any

    environment {
        AWS_REGION = 'ap-south-1'
        ECR_REPO = '861885769722.dkr.ecr.ap-south-1.amazonaws.com/smart-parking'
        EKS_CLUSTER = 'smart-parking-eks'
        K8S_NAMESPACE = 'smart-parking'
        K8S_DEPLOYMENT = 'smart-parking'
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

        stage('Configure EKS') {
            steps {
                sh '''
                    aws eks update-kubeconfig \
                      --region $AWS_REGION \
                      --name $EKS_CLUSTER
                '''
            }
        }

        stage('Deploy to EKS') {
            steps {
                sh '''
                    kubectl set image deployment/$K8S_DEPLOYMENT \
                      app=$ECR_REPO:$IMAGE_TAG \
                      -n $K8S_NAMESPACE

                    kubectl rollout status deployment/$K8S_DEPLOYMENT \
                      -n $K8S_NAMESPACE \
                      --timeout=5m
                '''
            }
        }

        stage('Verify Deployment') {
            steps {
                sh '''
                    kubectl get pods -n $K8S_NAMESPACE -o wide
                    kubectl get deployment $K8S_DEPLOYMENT \
                      -n $K8S_NAMESPACE \
                      -o jsonpath='{.spec.template.spec.containers[0].image}'
                    echo
                '''
            }
        }
    }

    post {
        success {
            echo 'Smart Parking EKS CI/CD deployment successful!'
        }

        failure {
            echo 'Smart Parking EKS CI/CD deployment failed!'
        }
    }
}
