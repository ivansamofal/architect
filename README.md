# Architecture Project with Docker Compose

This project uses Docker Compose to deploy a multi-component environment, including a web server, a PHP application, a distributed database, a message queue, caching, NoSQL, Elasticsearch with Kibana, and other services. Below are the main components and their purposes.

## Stack and Main Services

- **server (nginx)**
    - Uses the official `nginx:alpine` image.
    - Acts as a reverse proxy.
    - Mounts configuration files, SSL certificates, and the main nginx configuration from local directories.
    - Exposes ports 80 (HTTP) and 443 (HTTPS).

- **webapp (PHP application)**
    - Built using a Dockerfile located at `./config/infrastructure/php/Dockerfile`.
    - Uses environment variables, including database connection settings (using Citus).
    - Mounts local code into the container as well as PHP and Blackfire configuration files.
    - Depends on the `citus-coordinator` and `rabbitmq` services.

- **citus-coordinator and citus-worker (PostgreSQL + Citus)**
    - **citus-coordinator**: The primary coordinator for the distributed database.
    - **citus-worker-1 and citus-worker-2**: Workers for distributed data storage and processing.
    - Uses the `citusdata/citus:12.1.3` images.
    - Enables horizontal scaling of PostgreSQL with the Citus extension.

- **rabbitmq**
    - Image: `rabbitmq:3.12-management`.
    - Manages message queues for asynchronous task processing.
    - Exposes ports 5672 (AMQP) and 15672 (management interface).

- **mongodb**
    - Image: `mongo:6.0`.
    - A NoSQL database for storing documents.
    - Configured with a root user and password; port 27017 is open for access.

- **node_container**
    - Built using a Dockerfile in the `./frontend` directory.
    - Builds and runs the frontend application (runs `npm run dev` and `node server.js`).
    - Mounts the frontend source code for development.
    - Exposes port 3005, which is mapped to the application running inside the container.

- **blackfire**
    - Image: `blackfire/blackfire`.
    - A tool for profiling and monitoring the performance of the PHP application.
    - Uses environment variables for authentication.

- **jmeter**
    - Image: `justb4/jmeter:latest`.
    - Used for load testing.
    - Mounts directories containing test plans (`.jmx` files) and logs for testing.

- **redis**
    - Image: `redis:7-alpine`.
    - Provides caching and fast data access.
    - Exposes port 6379.

- **elasticsearch**
    - Image: `docker.elastic.co/elasticsearch/elasticsearch:8.11.1`.
    - Used as a search engine and backend for logging.
    - Runs in single-node mode (`discovery.type=single-node`).
    - Memory is limited using `ES_JAVA_OPTS`.

- **kibana**
    - Image: `docker.elastic.co/kibana/kibana:8.11.1`.
    - A web interface for visualizing and analyzing Elasticsearch data.
    - Connects to Elasticsearch via the `ELASTICSEARCH_HOSTS` environment variable.

## Networks and Volumes

- **Network `architecht_network`**
    - All services are connected to the common external network `architecht_network` for interaction.

- **Persistent Data Volumes**
    - `citus_coordinator_data` — PostgreSQL data (Citus Coordinator).
    - `rabbitmq_data` — RabbitMQ data.
    - `mongodb_data` — MongoDB data.
    - `esdata` — Elasticsearch data.
    - Other volumes are used for node_modules (if necessary).

## How to Run

1. **Ensure that Docker and Docker Compose are installed** on your machine.

2. **Configure environment variables** in the `.env.local` file (if required).

3. **Start Docker Compose:**

   ```bash
   docker-compose up -d
   ```


3. **Check the status of the containers:**
```bash
docker-compose ps
```

3. **Access the services:**


- The web application will be available via nginx on ports 80 and 443.

- Kibana is available at http://localhost:5601.

- The RabbitMQ management interface is available at http://localhost:15672 (login/password: guest/guest).

## What’s Included
- NGINX as a reverse proxy to distribute incoming requests among services.

- A PHP application with Blackfire support for profiling.

- A distributed database based on Citus for horizontal scaling of PostgreSQL.

- RabbitMQ for asynchronous message processing.

- MongoDB for NoSQL data storage.

- A Node.js container for frontend development and build processes.

- JMeter for load testing.

- Redis for caching.

- Elasticsearch and Kibana for logging and data analysis.

Conclusion
This stack enables you to develop, test, and scale a web application using modern tools and technologies. Each part of the environment is isolated in a container, simplifying dependency management and ensuring flexibility in deployment.
