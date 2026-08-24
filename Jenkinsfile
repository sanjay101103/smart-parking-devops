pipeline {
  agent any
  environment {
    AWS_REGION='us-east-1'
    ECR_REPO='smart-parking'
    ECS_CLUSTER='smart-parking-cluster'
    ECS_SERVICE='smart-parking-service'
    EKS_CLUSTER='smart-parking-eks'
    K8S_NAMESPACE='smart-parking'
    K8S_DEPLOYMENT='smart-parking'
    IMAGE_TAG="${BUILD_NUMBER}"
  }
  stages {
    stage('Checkout'){ steps{ checkout scm } }
    stage('Build & Test'){
      steps{
        sh 'docker build -t ${ECR_REPO}:${IMAGE_TAG} .'
        sh 'docker run --rm ${ECR_REPO}:${IMAGE_TAG} php -l index.php'
        sh 'docker run --rm ${ECR_REPO}:${IMAGE_TAG} php -l config.php'
      }
    }
    stage('Push Image to ECR'){
      steps{
        sh '''
          ACCOUNT_ID=$(aws sts get-caller-identity --query Account --output text)
          ECR_URI=${ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com/${ECR_REPO}
          aws ecr describe-repositories --repository-names ${ECR_REPO} --region ${AWS_REGION} >/dev/null 2>&1 || aws ecr create-repository --repository-name ${ECR_REPO} --region ${AWS_REGION}
          aws ecr get-login-password --region ${AWS_REGION} | docker login --username AWS --password-stdin ${ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com
          docker tag ${ECR_REPO}:${IMAGE_TAG} ${ECR_URI}:${IMAGE_TAG}
          docker tag ${ECR_REPO}:${IMAGE_TAG} ${ECR_URI}:latest
          docker push ${ECR_URI}:${IMAGE_TAG}
          docker push ${ECR_URI}:latest
        '''
      }
    }
    stage('Deploy ECS'){
      steps{
        sh '''
          aws ecs update-service --cluster ${ECS_CLUSTER} --service ${ECS_SERVICE} --force-new-deployment --region ${AWS_REGION}
          aws ecs wait services-stable --cluster ${ECS_CLUSTER} --services ${ECS_SERVICE} --region ${AWS_REGION}
        '''
      }
    }
    stage('Deploy Kubernetes'){
      steps{
        sh '''
          aws eks update-kubeconfig --name ${EKS_CLUSTER} --region ${AWS_REGION}
          kubectl get namespace ${K8S_NAMESPACE} >/dev/null 2>&1 || kubectl create namespace ${K8S_NAMESPACE}
          ACCOUNT_ID=$(aws sts get-caller-identity --query Account --output text)
          ECR_URI=${ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com/${ECR_REPO}
          kubectl apply -f deploy/k8s/
          kubectl -n ${K8S_NAMESPACE} set image deployment/${K8S_DEPLOYMENT} app=${ECR_URI}:${IMAGE_TAG}
          kubectl -n ${K8S_NAMESPACE} rollout status deployment/${K8S_DEPLOYMENT} --timeout=180s
        '''
      }
    }
  }
  post { always { sh 'docker image prune -f || true' } }
}
