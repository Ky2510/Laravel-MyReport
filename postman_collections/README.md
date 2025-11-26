# Laravel MyReport API - Postman Collections

This directory contains comprehensive Postman collections for testing the Laravel MyReport API with custom token authentication.

## 📁 Available Collections

### 1. **Individual Collections**
- `auth.json` - Authentication endpoints (register, login, profile, logout)
- `roles.json` - Role management CRUD operations
- `permissions.json` - Permission management CRUD operations
- `users.json` - User management CRUD operations
- `dashboards.json` - Dashboard endpoints (superadmin, admin)

### 2. **Complete Collection**
- `complete_api_collection.json` - All endpoints in one organized collection

## 🚀 Quick Start

### Step 1: Import Collections
1. Open Postman
2. Click **Import** → **Choose Files**
3. Select the collection files you want to import
4. For complete testing, import `complete_api_collection.json`

### Step 2: Login to Get Token
1. Use the **Login** endpoint in the **Authentication** folder
2. Default credentials:
   ```json
   {
     "login": "yasin",
     "password": "autoall1"
   }
   ```
3. The token will be automatically saved to Postman variables

### Step 3: Test APIs
1. After login, the token is automatically used for all authenticated requests
2. All endpoints requiring authentication will work seamlessly

## 🔐 Authentication Setup

All collections are configured with:
- **Custom Token Authentication**: Uses `Bearer {{token}}` header
- **Base URL**: `http://127.0.0.1:8000` (configurable via variables)
- **Auto Token Management**: Login saves token, logout clears it

## 📋 Available Roles
- `super_admin` - Full system access
- `director` - Management access
- `hr_manager` - HR related access
- `sales_manager` - Sales management access
- `sales_employee` - Sales staff access
- `employee` - Basic user access

## 🛠️ Variables Used

| Variable | Description | Default Value |
|----------|-------------|---------------|
| `base_url` | API base URL | `http://127.0.0.1:8000` |
| `token` | Authentication token | Empty (filled by login) |
| `roleId` | Role ID for operations | Replace with actual ID |
| `permissionId` | Permission ID for operations | Replace with actual ID |
| `userId` | User ID for operations | Replace with actual ID |

## 📊 Endpoint Overview

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - User login (returns token)
- `GET /api/profile` - Get current user profile
- `POST /api/logout` - User logout

### Role Management (super_admin only)
- `GET /api/roles` - List all roles
- `POST /api/roles` - Create new role
- `GET /api/roles/{id}` - Get specific role
- `PUT /api/roles/{id}` - Update role
- `DELETE /api/roles/{id}` - Delete role

### Permission Management (super_admin only)
- `GET /api/permissions` - List all permissions
- `POST /api/permissions` - Create new permission
- `PUT /api/permissions/{id}` - Update permission
- `DELETE /api/permissions/{id}` - Delete permission

### User Management (super_admin only)
- `GET /api/users` - List all users with roles
- `POST /api/users` - Create new user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

### Dashboards
- `GET /api/superadmin/dashboard` - Super admin dashboard (super_admin only)
- `GET /api/admin/dashboard` - Admin dashboard (admin or super_admin)

## ⚠️ Important Notes

1. **Authentication Required**: All endpoints except register and login need authentication
2. **Role-Based Access**: Different endpoints require different roles
3. **Custom Token System**: Uses custom token authentication (not JWT)
4. **ID Replacement**: For update/delete operations, replace placeholder IDs with actual IDs from list endpoints
5. **Database Schema**: The app uses custom database schema with UUID/string IDs

## 🔧 Testing Tips

1. **Start with Login**: Always login first to get the authentication token
2. **Check User Roles**: Use `/api/profile` to verify your role and permissions
3. **Get IDs First**: For update/delete operations, first use list endpoints to get valid IDs
4. **Error Handling**: Check response messages for detailed error information
5. **Token Expiry**: If requests start failing, login again to get a fresh token

## 🐛 Troubleshooting

### Authentication Issues
- Ensure you're logged in and have a valid token
- Check that the token is correctly set in the `token` variable
- Verify your user has the required role for the endpoint

### Permission Issues
- Check if your user has the required role (super_admin for management endpoints)
- Use the `/api/profile` endpoint to see your assigned roles
- Contact an admin to assign appropriate roles if needed

### Database Issues
- Ensure the Laravel application is running
- Check database migrations are complete
- Verify the custom authentication system is configured correctly

## 📞 Support

For issues with:
- **Authentication**: Check token and user roles
- **Database**: Verify migrations and custom schema setup
- **Permissions**: Ensure proper role assignments
- **API Errors**: Check Laravel logs for detailed error information