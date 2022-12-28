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
                    sh "sh sonar-scanner -Dsonar.projectKey=absensi-hris -Dsonar.sources=. -Dsonar.host.url=http://192.168.0.85:9001 -Dsonar.login=squ_e102487f7b721199ffa8029d071e1c16d613725c"
                }
            }
        }
    }
    post {
        success {
            slackSend "Build deployed successfully - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)"
        }
        failure {
            slackSend failOnError:true message:"Build failed  - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)"
        }
        // failure {
        //     mail body: "Dear All, Please check the ${BUILD_URL} ASAP!!" , cc: '', from: 'NoReplyJenkins', subject: "Job ${JOB_NAME} (${BUILD_NUMBER}) is FAILURE :(", to: 'hafid.rosianto@rapidplast.co.id'
        // }
        // success {
        //     mail body: "Dear All, The build is success on ${BUILD_URL}" , cc: '', from: 'NoReplyJenkins', subject: "Job ${JOB_NAME} (${BUILD_NUMBER}) is SUCCESS :D", to: 'hafid.rosianto@rapidplast.co.id'
        // }
    }
}

//sonar-scanner -Dsonar.projectKey=absensi-hris -Dsonar.sources=. -Dsonar.host.url=http://192.168.0.148:9001 -Dsonar.login=squ_175ecda06fd371771c341a2afad612bb9839deac
