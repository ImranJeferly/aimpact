# Firebase Security Rules Setup Instructions

## 1. Firestore Database Rules

1. Go to your Firebase Console: https://console.firebase.google.com/
2. Select your project: `aimpact-7be8a`
3. Navigate to **Firestore Database** > **Rules**
4. Replace the existing rules with the content from `firebase-firestore-rules.txt`
5. Click **Publish**

## 2. Firebase Storage Rules

1. In the same Firebase Console
2. Navigate to **Storage** > **Rules**
3. Replace the existing rules with the content from `firebase-storage-rules.txt`
4. Click **Publish**

## 3. What These Rules Do

### Firestore Rules:
- **Blogs**: Everyone can read, only authenticated users can create/update/delete
- **Testimonials**: Everyone can read, only authenticated users can create/update/delete
- **Submissions**: Everyone can create (contact form), only authenticated users can read/manage
- **Categories**: Everyone can read, only authenticated users can manage
- Includes data validation (required fields, valid email format, rating ranges)

### Storage Rules:
- **Blog Images**: Everyone can read, only authenticated users can upload
- **Testimonial Images**: Everyone can read, only authenticated users can upload
- **File Validation**: Only image files allowed, max 5MB size
- **Supported Formats**: JPEG, JPG, PNG, GIF, WebP

## 4. Testing the Rules

After deploying the rules, test:

1. **Public Read**: Try accessing your website - images and content should load
2. **Admin Upload**: Try uploading images through admin panel (should work when authenticated)
3. **Unauthorized Upload**: Try accessing admin handlers without authentication (should fail)

## 5. Security Features

- **File Type Validation**: Only image files allowed for uploads
- **Size Limits**: 5MB for images, 10MB for general uploads
- **Authentication Required**: All write operations require valid Firebase Auth token
- **Data Validation**: Required fields and format validation for all collections
- **Public Read Access**: Website visitors can view content without authentication

## 6. Production Considerations

- Ensure your admin authentication is properly implemented
- Consider adding IP restrictions for admin operations
- Monitor usage through Firebase Console Analytics
- Set up alerting for unusual access patterns
- Regularly review and update rules as needed

## 7. Emergency Access

If you get locked out, you can temporarily set permissive rules:

```javascript
// EMERGENCY ONLY - DO NOT USE IN PRODUCTION
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read, write: if true;
    }
  }
}
```

Remember to revert to secure rules immediately after resolving the issue!