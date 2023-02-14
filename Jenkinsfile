pipeline {
    agent any
    stages {
        stage ('Checkout') {
            steps {
                git branch: 'main', credentialsId: 'd16b712d-e5f4-41b9-ad6d-1517229e2b1c', url: 'https://github.com/rapidplast/absensi-hris.git'
            } 
        }
        stage ('Build') {
            steps {
                sh 'cd /var/lib/docker/volumes/absensi-hris/_data/ && git pull'  
            }
        }
        stage ('Test') {
            steps {
                withSonarQubeEnv('sonarqube') {
                    sh "sh sonar-scanner -Dsonar.projectKey=absensi-hris -Dsonar.sources=. -Dsonar.host.url=http://192.168.0.85:9001 -Dsonar.login=squ_ecffe88bd1340dc3b68f54d585b9f3d1253b0899"
                }
            }
        }
    }
    post {
        success {
            slackSend message: "Horraayy.. Build Successfully!! => ${JOB_NAME} ${BUILD_NUMBER} ${BUILD_URL}"
        }
        failure {
            slackSend message: "Ups.. Build failed :( => ${JOB_NAME} ${BUILD_NUMBER} ${BUILD_URL}"
        }
    }
}

//sonar-scanner -Dsonar.projectKey=absensi-hris -Dsonar.sources=. -Dsonar.host.url=http://192.168.0.148:9001 -Dsonar.login=squ_175ecda06fd371771c341a2afad612bb9839deac
//mail body: "Dear All, Please check the ${BUILD_URL} ASAP!!" , cc: '', from: 'NoReplyJenkins', subject: "Job ${JOB_NAME} (${BUILD_NUMBER}) is FAILURE :(", to: 'hafid.rosianto@rapidplast.co.id'
//mail body: "Dear All, The build is success on ${BUILD_URL}" , cc: '', from: 'NoReplyJenkins', subject: "Job ${JOB_NAME} (${BUILD_NUMBER}) is SUCCESS :D", to: 'hafid.rosianto@rapidplast.co.id'
