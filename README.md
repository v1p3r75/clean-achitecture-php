# Blog Project - Clean Architecture

This repository contains a **blog project** built using **PHP** and following the **Clean Architecture** principles. The goal is to create a modular, testable, and maintainable application structure.

## 📁 Project Structure

The project is divided into four main layers, each having a specific responsibility:

### Application :

- Contains Use Cases, Services, and Contracts that orchestrate application logic and workflows.
- This layer doesn't depend on any external technology.

### Domain :

- Contains the core business logic of the application.
- Includes Entities, Value Objects, and Repositories.

### Infrastructure :

- Implements the technical details and external concerns.
- For example, database implementations, HTTP clients, or external services.

### Presentation :

- Contains all user-facing components, including ViewModels and Presenters.
- Responsible for converting data into formats usable by the API or frontend.

````markdown
src/
│
├── Application/
│   ├── Contract/        # Interfaces and abstraction for the application layer
│   ├── Presenter/       # Application-level Presenters
│   ├── Request/User/    # User-specific request DTOs
│   ├── Response/        # Response objects for use cases
│   ├── Service/         # Application services (e.g., business workflows)
│   └── UseCase/         # Use cases for the application logic
│
├── Domain/
│   ├── Entity/          # Core domain entities
│   ├── Exception/       # Custom domain exceptions
│   ├── Repository/      # Interfaces for repositories
│   ├── Service/         # Domain services
│   └── ValueObject/     # Immutable Value Objects
│
├── Infrastructure/      # Implementation of external dependencies (DB, APIs, etc.)
│
├── Presentation/        # Contains all user-facing components, including ViewModels and Presenters.
│
├── tests/               # Unit and integration tests
````

## 🛠️ Technologies Used

- PHP (Core language)
- Composer (Dependency management)
- Pest (Testing framework)

## 🧩 Key Principles

This project follows Clean Architecture to ensure:

- Separation of Concerns: Each layer has a distinct responsibility.
- Testability: Core logic is decoupled and easy to test.
- Maintainability: Adding new features or modifying existing ones is straightforward.
- Scalability: The architecture allows the application to grow without breaking.