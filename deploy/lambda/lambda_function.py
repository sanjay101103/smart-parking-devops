import os, boto3
ecs=boto3.client("ecs")
CLUSTER=os.environ.get("ECS_CLUSTER","smart-parking-cluster")
SERVICE=os.environ.get("ECS_SERVICE","smart-parking-service")
MIN_COUNT=int(os.environ.get("MIN_COUNT","2"))
def lambda_handler(event, context):
    r=ecs.describe_services(cluster=CLUSTER,services=[SERVICE])
    services=r.get("services",[])
    if not services: return {"status":"service-not-found"}
    s=services[0]; desired=s.get("desiredCount",0); running=s.get("runningCount",0)
    if desired<MIN_COUNT or running<MIN_COUNT:
        ecs.update_service(cluster=CLUSTER,service=SERVICE,desiredCount=MIN_COUNT,forceNewDeployment=True)
        return {"action":"scaled","desired":desired,"running":running,"newDesired":MIN_COUNT}
    return {"action":"no-change","desired":desired,"running":running}
