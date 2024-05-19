
# Products List

## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)

## Getting Started

To start the project, follow these steps:

1. **Clone the Repository**

   ```sh
   git clone https://github.com/DanielPalmSie/prof-bit.git
   cd your-repository
   ```

2. **Run the Start Script**

   Execute the provided shell script to set up and launch the application:

   ```sh
   sh start.sh
   ```

   This script will build and start all necessary Docker containers for the project.


3. **Configure the Hosts File**

   To access the application via `application.local`, you need to add the following entry to your hosts file:

   ```
   127.0.0.1 application.local
   ```

   On Windows, the hosts file is located at `C:\Windows\System32\drivers\etc\hosts`.
   On macOS and Linux, it is located at `/etc/hosts`.

## Accessing the Application

Once the setup is complete, you can access the application at the following URL:

- [http://application.local/products](http://application.local/products)

This URL will take you directly to the products page of the application.
