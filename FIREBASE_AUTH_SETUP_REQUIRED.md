# 🔥 URGENT: Firebase Authentication Setup Required

## ❌ Current Error: `Firebase: Error (auth/invalid-api-key)`

**The Firebase Authentication service is not enabled in your Firebase Console.**

## 🚨 REQUIRED STEPS TO FIX:

### Step 1: Enable Firebase Authentication

1. **Go to Firebase Console**: https://console.firebase.google.com/project/aimpact-22bcb
2. **Click "Authentication"** in the left sidebar
3. **Click "Get started"** button
4. **Go to "Sign-in method" tab**
5. **Enable "Email/Password"** provider:
   - Click on "Email/Password"
   - Toggle "Enable" to ON
   - Click "Save"

### Step 2: Create Admin User

1. **Go to "Users" tab** in Authentication
2. **Click "Add user"** 
3. **Enter details**:
   - Email: `admin@aimpact.com` (or your preferred email)
   - Password: `your-secure-password`
4. **Click "Add user"**

### Step 3: Set Admin Custom Claims

You need to give your user admin privileges. **Temporarily**, you can skip this step and we'll set it up later with Firebase Functions or Admin SDK.

### Step 4: Test the Setup

1. **Visit**: http://localhost/AImpact/admin/test_firebase_auth.html
2. **Check browser console** - should show "Firebase initialized successfully"
3. **Visit**: http://localhost/AImpact/admin/login.php
4. **Try logging in** with the email/password you created

## 🔧 Current Status:

✅ **Environment variables** - Working correctly
✅ **Firebase project** - Exists (aimpact-22bcb)  
❌ **Authentication service** - NOT ENABLED
❌ **Admin user** - NOT CREATED

## 🚦 Why This Error Occurs:

The error `auth/invalid-api-key` typically means:
1. **Firebase Authentication is not enabled** in your project
2. **API key doesn't have Authentication permissions**
3. **Project doesn't exist** (but yours does exist)

## ⚡ Quick Fix Test:

After enabling Authentication in Firebase Console, test with:

```
http://localhost/AImpact/admin/test_firebase_auth.html
```

You should see "Firebase initialized successfully!" instead of errors.

## 📱 Next Steps After Setup:

1. **Test login page**: http://localhost/AImpact/admin/login.php
2. **Create custom claims** for admin privileges
3. **Apply production Firestore rules**
4. **Test admin dashboard functionality**

---

## 🎯 **PRIORITY: Enable Firebase Authentication in Console**

**This is the main blocker. Once Authentication is enabled, everything else will work.**

**Your Firebase project exists, your code is correct, you just need to enable the Authentication service.** 🔥