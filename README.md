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
    password VARCHAR(255)
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

## Additional Resources
- [GEMVC Framework Documentation](vendor/gemvc/framework/Documentation.md)
- [GEMVC Framework API Reference](vendor/gemvc/framework/GEMVCFrameworkAPIReference.json)
- [GEMVC Framework AI Assist](vendor/gemvc/framework/GEMVCFrameworkAIAssist.jsonc)
- [GEMVC Library Documentation](vendor/gemvc/library/Documentation.md)
- [GEMVC Library API Reference](vendor/gemvc/library/GEMVCLibraryAPIReference.json)
- [GEMVC Library AI Assist](vendor/gemvc/library/AIAssist.jsonc)
