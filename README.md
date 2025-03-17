# geminstaller
installer package for gemvc framework

## Overview
GEMVC Framework is built on top of GEMVC Library (v3.27.8), providing a structured approach to building microservice-based RESTful APIs. The framework adds additional features and conventions on top of the library's core functionality.

## Installation
```bash
# Install with project name folder
composer create-project gemvc/installer [your_project_name]

# Install in current folder
composer create-project gemvc/installer .
```

## Framework Structure

### Core Components
All core framework components are located in the `Gemvc\Core` namespace:

```php
use Gemvc\Core\Auth;           // Authentication and authorization
use Gemvc\Core\ApiService;     // Base service class
use Gemvc\Core\Controller;     // Base controller class
use Gemvc\Core\CRUDTable;      // Base table class for CRUD operations
use Gemvc\Core\Table;          // Base table class
use Gemvc\Core\Bootstrap;      // Framework bootstrap
```

### Namespace Structure
```
Gemvc\
├── Core\           # Core framework components
│   ├── Auth.php
│   ├── ApiService.php
│   ├── Controller.php
│   ├── CRUDTable.php
│   └── Bootstrap.php
└── Http\           # HTTP handling components
    ├── Request.php
    └── JsonResponse.php
```

### Application Structure
The framework follows a layered architecture pattern:

```
/app
├── api/         # API service layer - handles endpoints and request validation
├── controller/  # Business logic layer - implements application logic
├── model/       # Data models - represents data structures
├── table/       # Database table definitions - handles database operations
└── .env         # Environment configuration - stores application settings
```

#### Layer Responsibilities
- **API Layer** (`/app/api`): 
  - Handles HTTP requests and responses
  - Validates input data
  - Routes requests to appropriate controllers
  - Implements API documentation

- **Controller Layer** (`/app/controller`):
  - Contains business logic
  - Processes validated requests
  - Interacts with models
  - Returns processed results

- **Model Layer** (`/app/model`):
  - Defines data structures
  - Implements data validation rules
  - Handles data relationships

- **Table Layer** (`/app/table`):
  - Manages database operations
  - Implements CRUD operations
  - Handles database relationships

#### Environment Configuration
The framework uses Symfony's Dotenv component for environment management:
```php
// index.php
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/app/.env');
```

### Important Notes
1. Always use `Gemvc\Core\Auth` for authentication (not `Gemvc\Auth\Auth`)
2. Core components are in the `Core` namespace
3. HTTP components are in the `Http` namespace
4. Database components are in the `Database` namespace
5. When manually setting POST parameters, use array syntax: `$request->post['key'] = $value` (not `setPost()` method)
6. Auth token user ID is accessed via `$auth->token->user_id` (not `$auth->token->id`)
7. For string validation with length constraints, use `validateStringPosts()` with format: `['field'=>'min|max']`
8. For email validation, use `validatePosts()` with format: `['email'=>'email']`
9. The Auth class automatically handles invalid tokens by returning a 403 response and stopping execution

### Input Validation Best Practices
The framework provides different validation methods for different types of input:

#### Authentication
```php
// Auth class automatically handles invalid tokens
$auth = new Auth($this->request);
// If token is invalid, execution stops with 403 response
// If token is valid, you can safely access user data
$this->request->post['id'] = $auth->token->user_id;
```

#### Basic Validation
```php
// For email and basic type validation
$this->validatePosts([
    'email' => 'email',
    'password' => 'string'
]);
```

#### String Length Validation
```php
// For string validation with length constraints
$this->validateStringPosts([
    'password' => '6|15'  // min length 6, max length 15
]);
```

#### Validation Flow
1. Always validate authentication first - Auth class will handle invalid tokens automatically
2. Validate input before processing
3. Use appropriate validation method based on input type
4. Set additional parameters after validation
5. Pass validated request to controller

Example of a secure endpoint:
```php
public function updatePassword(): JsonResponse
{
    // 1. Check authentication - automatically stops with 403 if token is invalid
    $auth = new Auth($this->request);
    
    // 2. Validate input with length constraints
    $this->validateStringPosts(['password'=>'6|15']);
    
    // 3. Set additional parameters - safe to do after Auth check
    $this->request->post['id'] = $auth->token->user_id;
    
    // 4. Process request
    return (new UserController($this->request))->updatePassword();
}
```

## Documentation
The complete API documentation for your application is available at:
```
http://your-domain/index/document
```

This documentation is automatically generated from your code's PHPDoc comments and mock responses.

## Database Setup
Create the users table with the following structure:
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(50) NOT NULL DEFAULT 'user'
);
```

## API Documentation Generation

### Mock Response System
The GEMVC Framework includes an automatic API documentation generation system using the `mockResponse` static method. This feature helps maintain accurate and up-to-date API documentation.

#### How to Implement
1. Add a static `mockResponse` method to your API service class:
```php
/**
 * Generates mock responses for API documentation
 * 
 * @param string $method The API method name
 * @return array<mixed> Example response data for the specified method
 * @hidden
 */
public static function mockResponse(string $method): array
{
    return match($method) {
        'yourMethod' => [
            'response_code' => 200,
            'message' => 'OK',
            'count' => 1,
            'service_message' => 'Operation successful',
            'data' => [
                // Your example response data
            ]
        ],
        default => [
            'success' => false,
            'message' => 'Unknown method'
        ]
    };
}
```

#### Response Structure
Your mock responses should follow this structure:
```php
[
    'response_code' => int,      // HTTP status code
    'message' => string,         // Status message
    'count' => int,             // Number of items returned
    'service_message' => string, // Detailed service message
    'data' => mixed            // Response data
]
```

#### Best Practices
1. Always include the `@hidden` annotation to mark the method as internal
2. Provide realistic example data that matches your actual response structure
3. Include all possible response variations (success, error cases)
4. Keep the example data up to date with your actual API responses
5. Use proper type hints and return type declarations

#### Example
```php
public static function mockResponse(string $method): array
{
    return match($method) {
        'create' => [
            'response_code' => 201,
            'message' => 'created',
            'count' => 1,
            'service_message' => 'Resource created successfully',
            'data' => [
                'id' => 1,
                'name' => 'Example Resource'
            ]
        ],
        'error' => [
            'response_code' => 400,
            'message' => 'Bad Request',
            'count' => 0,
            'service_message' => 'Invalid input data',
            'data' => null
        ],
        default => [
            'success' => false,
            'message' => 'Unknown method'
        ]
    };
}
```

## AI Assistant Support
The GEMVC Framework includes comprehensive AI Assistant rules to ensure consistent and secure development assistance. These rules are defined in `GEMVCAIAssistantRules.json` and cover:

### Key AI Assistant Guidelines
1. **Core Principles**
   - Security-first approach
   - Strict type safety (PHPStan level 9)
   - Respect for layered architecture
   - Framework convention adherence

2. **Architecture Understanding**
   - Layer-specific responsibilities
   - Proper inheritance requirements
   - Access control between layers
   - Component relationships

3. **Security Enforcement**
   - Authentication patterns
   - Input validation methods
   - Parameter handling
   - Token validation

4. **Response Standards**
   - Consistent response formats
   - HTTP status code mapping
   - Error handling patterns

### AI Assistant Resources
The framework provides several resources to support AI-assisted development:

1. **Framework AI Assist**
   - Location: `vendor/gemvc/framework/GEMVCFrameworkAIAssist.jsonc`
   - Purpose: Framework-specific AI assistance rules
   - Features: Architecture patterns, security rules, best practices

2. **Library AI Assist**
   - Location: `vendor/gemvc/library/AIAssist.jsonc`
   - Purpose: Core library AI assistance rules
   - Features: Component usage, error handling, security patterns

3. **API References**
   - Framework: `vendor/gemvc/framework/GEMVCFrameworkAPIReference.json`
   - Library: `vendor/gemvc/library/GEMVCLibraryAPIReference.json`
   - Purpose: Detailed API documentation for AI assistance

### AI Assistant Best Practices
When working with AI assistants, follow these guidelines:

1. **Code Generation**
   - Always verify generated code against framework rules
   - Ensure proper layer separation
   - Validate security implementations
   - Check type safety compliance

2. **Documentation**
   - Use PHPDoc comments for all public methods
   - Include mock responses for API endpoints
   - Provide clear examples in comments
   - Follow framework documentation standards

3. **Security**
   - Verify authentication implementations
   - Validate input handling
   - Check parameter setting methods
   - Ensure proper error responses

## Additional Resources
- [GEMVC Framework Documentation](vendor/gemvc/framework/Documentation.md)
- [GEMVC Framework API Reference](vendor/gemvc/framework/GEMVCFrameworkAPIReference.json)
- [GEMVC Framework AI Assist](vendor/gemvc/framework/GEMVCFrameworkAIAssist.jsonc)
- [GEMVC Library Documentation](vendor/gemvc/library/Documentation.md)
- [GEMVC Library API Reference](vendor/gemvc/library/GEMVCLibraryAPIReference.json)
- [GEMVC Library AI Assist](vendor/gemvc/library/AIAssist.jsonc)
- [GEMVC AI Assistant Rules](GEMVCAIAssistantRules.json)

#### Table Layer Implementation
The table layer must follow strict implementation rules:

1. **Class Structure**
   ```php
   /**
    * Table class for handling database operations
    * 
    * @property int $id Unique identifier
    * @property string $field Field description
    */
   class TableName extends CRUDTable 
   {
       public int $id;
       public string $field;

       public function __construct()
       {
           parent::__construct();
       }

       public function getTable(): string
       {
           return 'table_name';
       }

       /**
        * @return null|static
        * null or TableName Object
        */
       public function selectById(int $id): null|static
       {
           $result = $this->select()->where('id', $id)->limit(1)->run();
           return $result[0] ?? null;
       }
   }
   ```

2. **Required Elements**
   - Public property declarations for all columns
   - Constructor with `parent::__construct()`
   - `getTable()` method returning table name
   - PHPDoc with `@property` annotations
   - Type hints for all properties and methods
   - Return type declarations for all methods
   - Custom select methods for specific queries

3. **Forbidden Practices**
   - Protected/private properties for columns
   - Missing type declarations
   - Missing PHPDoc comments
   - Missing return type declarations
   - Direct table name property
   - Using `where()` with LIKE operator
   - Manual string concatenation for LIKE queries

4. **Query Methods**
   The framework provides specific methods for common query operations. Always use these methods instead of raw SQL operators:

   ```php
   // Correct usage:
   $this->select()->whereLike('name', $name)->run();
   $this->select()->whereIn('id', $ids)->run();
   $this->select()->whereNull('deleted_at')->run();
   $this->select()->whereNotNull('active')->run();
   $this->select()->whereBetween('price', [$min, $max])->run();
   $this->select()->whereExists($subquery)->run();

   // Incorrect usage:
   $this->select()->where('name', 'LIKE', "%$name%")->run();  // Don't use raw LIKE
   $this->select()->where('id', 'IN', $ids)->run();          // Don't use raw IN
   $this->select()->where('deleted_at', 'IS NULL')->run();   // Don't use raw IS NULL
   ```

5. **Best Practices**
   - Use descriptive method names
   - Include comprehensive PHPDoc comments
   - Implement specific select methods for common queries
   - Follow consistent return type patterns
   - Maintain proper type safety
   - Use framework-provided query methods
   - Avoid raw SQL operators
   - Keep queries simple and readable

#### Model Layer Implementation
The model layer must follow strict implementation rules:

1. **Naming Convention**
   - Class names must end with 'Model' suffix (e.g., `ProductModel`, `UserModel`)
   - File names must match class names exactly (e.g., `ProductModel.php`)
   - Non-database properties must start with underscore (e.g., `$_created_at`)

2. **Class Structure**
   ```php
   /**
    * Entity model class for handling entity data
    * 
    * @property int $id Entity's unique identifier
    * @property string $name Entity's name
    * @property string $_created_at Creation timestamp
    */
   class EntityNameModel extends EntityNameTable
   {
       public function __construct()
       {
           parent::__construct();
       }
   }
   ```

3. **Required Elements**
   - Must extend the corresponding Table class (e.g., `ProductModel extends ProductTable`)
   - Class-level PHPDoc with `@property` annotations
   - Constructor with `parent::__construct()`
   - Type hints for all properties
   - Return type declarations for all methods

4. **Forbidden Practices**
   - Class names without 'Model' suffix
   - Missing type declarations
   - Missing PHPDoc comments
   - Missing return type declarations
   - Protected/private properties
   - Non-underscore prefixed non-DB properties
   - File names not matching class names
   - Redefining properties that exist in parent Table class
   - Redefining methods that exist in parent Table class
   - Implementing `fromTable()` method (not needed when extending Table class)
   - Implementing `selectById()` or similar methods (already in Table class)

5. **Best Practices**
   - Use descriptive property names
   - Include comprehensive PHPDoc comments
   - Keep properties public for framework access
   - Use type hints consistently
   - Follow PSR-4 autoloading standards
   - Maintain proper file naming
   - Document all properties and methods
   - Leverage inherited functionality from Table class
   - Only add model-specific methods that don't exist in Table class

### Controller Layer Best Practices

1. **Controller Rules**
- Only called by Services
- Use mapPost for data binding
- Return JsonResponse
- Keep business logic isolated
- Follow single responsibility
- Use createList() for list operations

2. **Type Safety**
```php
class UserController extends Controller {
    public function create(): JsonResponse {
        $model = new UserModel();
        $this->mapPost($model);  // Type-safe mapping
        return $model->createWithJsonResponse();
    }
}
```

3. **List Operations**
```php
class ProductController extends Controller {
    public function list(): JsonResponse {
        $model = new ProductModel();
        return $this->createList($model);  // Handles pagination, sorting, filtering
    }
}
```

The `createList` method provides:
- Automatic pagination handling
- Built-in sorting support
- Filtering capabilities
- Standard response formatting
- Proper error handling

4. **Controller Guidelines**
- Create new model instances per method
- Never store model instances as properties
- Let models handle business logic
- Use framework-provided methods (mapPost, createList)
- Keep controllers thin and focused
- Avoid direct database operations
- Avoid manual response formatting

### Model Layer Implementation

1. **Required Methods**
```php
class ProductModel extends ProductTable {
    public function createModel(): JsonResponse {
        return $this->insert()->withJsonResponse();
    }

    public function readModel(): JsonResponse {
        return $this->select()->withJsonResponse();
    }

    public function updateModel(): JsonResponse {
        return $this->update('id', $this->id)->withJsonResponse();
    }

    public function deleteModel(): JsonResponse {
        $this->delete($this->id);
        return new JsonResponse(['success' => true]);
    }
}
```

2. **Model Guidelines**
- Extend corresponding Table class
- Implement all CRUD methods with JsonResponse return type
- Use withJsonResponse() for standard response formatting
- Keep business logic in model layer
- Don't redefine inherited properties or methods
- Use type hints and return type declarations
- Add PHPDoc comments for all properties
- Never override parent class CRUD methods with different return types

3. **Best Practices**
- Leverage inherited functionality from Table class
- Only add model-specific methods that don't exist in Table class
- Use withJsonResponse() for consistent API responses
- Keep models focused on business logic
- Avoid direct database operations
- Use proper type declarations
