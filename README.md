
##ARP Survey

A simple PHP survey application

### Installation

Clone the survey application

    git clone https://github.com/alex-patterson-webdev/arp-survey.git

Bring up the required containers using Docker

    # cd arp-survey/
    # docker build .
    # docker-composer up -d

You can now visit `http://localhost:8080` in your browser to begin completing your survey

### Unit tests

Unit tests can be executed using composer

    composer arp:unit-test


