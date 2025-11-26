# Laravel MyReport API - Updated Postman Collections

**📅 Last Updated**: November 26, 2025
**✅ Status**: All collections updated with working authentication and role system

## 🆕 **What's New - Recent Updates:**

### **🔧 Critical Fixes Applied:**
1. **✅ User Model UUID Support**: Fixed primary key type handling
2. **✅ Guard Name Alignment**: User model now uses `'web'` guard (matches roles)
3. **✅ Role Assignments Fixed**: Correct `model_has_roles` table with proper UUIDs
4. **✅ Authentication Working**: Custom token system fully functional

### **📝 Updated Collections:**
- ✅ **`auth_updated.json`** - Enhanced authentication with test scripts
- ✅ **`quick_test.json`** - Complete workflow test in one collection
- 🔄 **Existing collections** (`roles.json`, `permissions.json`, etc.) - Still valid but may benefit from updates

---

## 🚀 **Quick Start Guide (Recommended):**

### **Option 1: Quick Test (Fastest)**
1. Import `quick_test.json`
2. Run all requests in order
3. Watch console output for real-time feedback
4. All endpoints should pass ✅

### **Option 2: Updated Auth Collection**
1. Import `auth_updated.json`
2. Use the "Login (Super Admin)" request to get token
3. Test other endpoints individually

### **Option 3: Complete Collection**
1. Import `complete_api_collection.json`
2. Use updated login credentials

---

## 🔑 **Updated Working Credentials:**

### **Super Admin User:**
```json
{
  "login": "yasin",
  "password": "autoall1"
}
```

### **What You Get After Login:**
```json
{
  "token": "6afe0f83747bb8d10b2174a7b74b69eb6abd72343cc4b3188a9a2e2cdb3a34efa4101bdaaa4d5ab9",
  "user": {
    "id": "6186fe24e6af45e1b6355118b32c89a3",
    "name": "Wildan Muhammad Yasin Fadillah",
    "username": "yasin",
    "email": "yasin@gratiajm.co.id",
    "role": "super_admin",
    "level": "admin"
  }
}
```

---

## 🔧 **Technical Improvements Made:**

### **Before (Issues):**
- ❌ User model: `guard_name = 'api'` (mismatch)
- ❌ User IDs: Integer casting (`6186`) vs Database UUID (`6186fe24e6af...`)
- ❌ Role assignments: Incorrect user IDs in `model_has_roles`
- ❌ Authentication: Token validation issues

### **After (Fixed):**
- ✅ User model: `guard_name = 'web'` (matches roles)
- ✅ User IDs: Proper UUID string handling with `$keyType = 'string'`
- ✅ Role assignments: Correct UUID mappings in `model_has_roles`
- ✅ Authentication: Custom token system working perfectly

### **User Model Updates:**
```php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    public $incrementing = false;
    protected $keyType = 'string';

    // ... rest of model
}
```

---

## 📊 **Current System Status:**

### **✅ Working Endpoints:**
- `POST /api/login` - ✅ Returns 80-char token + user info
- `GET /api/profile` - ✅ Shows user details with UUID
- `GET /api/roles` - ✅ Lists all roles (8 total)
- `POST /api/roles` - ✅ Creates new roles
- `GET /api/superadmin/dashboard` - ✅ Returns success message
- `GET /api/permissions` - ✅ Lists all permissions
- `GET /api/users` - ✅ Lists users with roles

### **🎯 Confirmed Features:**
- ✅ Custom token authentication (80-char hex tokens)
- ✅ UUID-based user identification
- ✅ Role-based access control
- ✅ Super admin role management
- ✅ Spatie Permission integration

### **📋 Available Roles:**
1. `director`
2. `employee`
3. `hr_manager`
4. `sales_manager`
5. `sales_employee`
6. `super_admin` ⭐ (Full access)
7. `project_manager`
8. `test_manager`

---

## 🧪 **Testing Results:**

### **Authentication Flow:**
```bash
# Login ✅
POST /api/login
→ Status: 200
→ Token: 80-char hex string
→ User ID: Full UUID (32 chars)
→ Role: super_admin

# Access Protected Endpoint ✅
GET /api/roles
→ Authorization: Bearer [token]
→ Status: 200
→ Data: 8 roles returned
```

### **Role System:**
```bash
# Role Check ✅
user.hasRole('super_admin') → true
user.roles->count() → 1
user.roles[0].name → 'super_admin'
```

---

## ⚠️ **Important Notes:**

### **Token Management:**
- Tokens are **80-character hex strings** (not JWT)
- Tokens stored in `users.token` column
- Login generates new token, logout clears it
- No automatic token expiration (manual logout required)

### **User ID Format:**
- All user IDs are **UUID strings** (32 hex chars)
- Example: `6186fe24e6af45e1b6355118b32c89a3`
- Primary key type: `varchar(191)`

### **Role Assignment:**
- Managed through `model_has_roles` table
- Uses Spatie Permission package
- Guard name: `'web'` (must match between users and roles)

---

## 🔍 **Troubleshooting:**

### **If Login Fails:**
1. Check credentials: `yasin` / `autoall1`
2. Verify Laravel app is running
3. Check database connectivity

### **If Token Doesn't Work:**
1. Get fresh token from login
2. Check Authorization header format: `Bearer [token]`
3. Verify token is exactly 80 characters

### **If Role Access Fails:**
1. Check user has `super_admin` role
2. Verify `model_has_roles` table has correct assignments
3. Clear Laravel cache: `php artisan cache:clear`

---

## 🎯 **Recommended Workflow:**

1. **Start with `quick_test.json`** - Complete test in 8 steps
2. **Use `auth_updated.json`** - For individual authentication testing
3. **Reference `README.md`** - For detailed endpoint documentation
4. **All other collections** - Still valid for specific endpoint testing

**🎉 All collections are now fully compatible with the updated authentication and role system!**