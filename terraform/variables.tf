variable "project_name" {
  description = "Project name"
  type        = string
  default     = "smart-parking"
}

variable "region" {
  description = "AWS region"
  type        = string
  default     = "ap-south-1"
}
variable "db_password" {
  description = "RDS database password"
  type        = string
  sensitive   = true
}
