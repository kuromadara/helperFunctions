Springboot works on Controller-Service-Repository pattern

layers:

Controller ->  Service -> Service Implemention -> Repository

Controller: The Controller is responsible for handling HTTP requests and returning HTTP responses. It is the entry point to your application and is responsible for routing requests to the correct Service. In the Controller, you define the endpoints that your clients can use to interact with your application.

Service: The Service is responsible for implementing the business logic of your application. It encapsulates complex logic and transactions, and is used to coordinate interactions between multiple Repositories. The Service defines the contract for how your application should operate, and provides an abstraction layer between the Controller and Repository layers. In the Service, you define the methods that implement the business logic of your application.

Service Implementation: The Service Implementation is a concrete implementation of the Service interface. It provides the implementation for the methods defined in the Service interface, and is responsible for performing the actual business logic of your application. The Service Implementation calls the appropriate methods in the Repository to retrieve and manipulate data.

Repository: The Repository is responsible for managing the data persistence of your application. It provides an abstraction layer over the underlying database or data store, and is responsible for performing CRUD (Create, Read, Update, Delete) operations on the data. The Repository defines the interface for accessing the data store, and provides methods for retrieving and manipulating data.
