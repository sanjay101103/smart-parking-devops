# Smart Parking DevOps Final Demo

Architecture:
GitHub -> Jenkins -> Docker -> ECR -> ECS Fargate + EKS -> Load Balancer -> Auto Scaling -> CloudWatch -> CloudTrail -> Lambda -> Route 53.

The original hard-coded Twilio credentials were removed from `config.php`. Use environment variables for secrets.

## Fast deployment order

1. Create RDS MySQL database `slot_booking` and import `db/slot_booking.sql`.
2. Create ECR repository `smart-parking`.
3. Build/test locally:
   `docker compose up -d --build`
   `curl http://localhost:8080/health.php`
4. Push this folder to GitHub.
5. Jenkins on EC2 needs Docker, AWS CLI and (for EKS) kubectl.
6. Jenkins IAM role needs ECR push, ECS update/describe, EKS access and required CloudWatch permissions.
7. Create ECS Fargate cluster, ALB, target group on port 80, health check `/health.php`, desired tasks 2.
8. Create `/ecs/smart-parking` CloudWatch log group and register `deploy/ecs/task-definition.json` after replacing RDS/ECS role/password placeholders.
9. Configure ECS Service Auto Scaling: min 2, max 5, CPU target 60%.
10. Create EKS cluster and run:
   `kubectl create namespace smart-parking`
   `kubectl -n smart-parking create secret generic smart-parking-db --from-literal=password='YOUR_RDS_PASSWORD'`
   Edit `deploy/k8s/all.yaml` with ECR URI and RDS endpoint, then `kubectl apply -f deploy/k8s/all.yaml`.
11. Configure Jenkins Pipeline from SCM using `Jenkinsfile`. Change region/cluster names if needed.
12. GitHub webhook triggers Jenkins.
13. Jenkins builds Docker, pushes ECR, forces ECS deployment, and updates EKS.
14. CloudWatch shows ECS logs; CloudTrail shows AWS API activity.
15. Deploy `deploy/lambda/lambda_function.py` as Python 3.12 with ECS permissions and an EventBridge 5-minute trigger.
16. Route 53 A/AAAA Alias -> ECS ALB. For HTTPS, use ACM certificate + ALB HTTPS listener.

## Jenkins pipeline stages

Checkout -> Docker Build/Test -> ECR Push -> ECS Deploy -> EKS Deploy.

## Final examiner demo

GitHub commit -> Jenkins starts -> Docker image built -> ECR image -> ECS tasks -> ALB -> website -> Auto Scaling -> EKS pods/HPA -> CloudWatch logs -> CloudTrail API event -> Lambda automation -> Route 53 domain.

## Useful commands

```bash
aws ecr describe-images --repository-name smart-parking --region us-east-1
aws ecs list-tasks --cluster smart-parking-cluster --region us-east-1
aws ecs describe-services --cluster smart-parking-cluster --services smart-parking-service --region us-east-1
aws logs tail /ecs/smart-parking --follow --region us-east-1
kubectl -n smart-parking get pods -o wide
kubectl -n smart-parking get svc
kubectl -n smart-parking get hpa
```

### Important
Do not put database passwords, AWS keys or Twilio tokens in GitHub. For the quickest final demo, use ECS ALB as the primary Route 53 endpoint and show the EKS LoadBalancer endpoint separately.
