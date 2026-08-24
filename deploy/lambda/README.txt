Runtime: Python 3.12
Environment: ECS_CLUSTER=smart-parking-cluster, ECS_SERVICE=smart-parking-service, MIN_COUNT=2
IAM: ecs:DescribeServices, ecs:UpdateService
Trigger: EventBridge Scheduler every 5 minutes.
