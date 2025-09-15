<?php
/**
 * Firebase Storage Helper
 * Handles file uploads to Firebase Storage
 */

class FirebaseStorageHelper {
    private $projectId;
    private $storageBucket;
    
    public function __construct($projectId, $storageBucket = null) {
        $this->projectId = $projectId;
        $this->storageBucket = $storageBucket ?: $projectId . '.appspot.com';
    }
    
    /**
     * Upload file to Firebase Storage
     * 
     * @param array $file The $_FILES array element
     * @param string $folder Storage folder (e.g., 'blogs', 'testimonials')
     * @param string $prefix Optional prefix for filename
     * @return array Result with success, message, and download URL
     */
    public function uploadFile($file, $folder, $prefix = '') {
        $result = [
            'success' => false,
            'message' => '',
            'downloadUrl' => null,
            'filename' => null
        ];
        
        // Validate upload
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            $result['message'] = 'No file uploaded or upload error occurred';
            return $result;
        }
        
        // Validate file type (images only)
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $result['message'] = 'Invalid file type. Only images are allowed.';
            return $result;
        }
        
        // Validate file size (5MB max)
        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $result['message'] = 'File size too large. Maximum 5MB allowed.';
            return $result;
        }
        
        // Generate secure filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safePrefix = $prefix ? preg_replace('/[^a-zA-Z0-9_-]/', '', $prefix) . '_' : '';
        $filename = $safePrefix . uniqid() . '.' . strtolower($extension);
        $storagePath = $folder . '/' . $filename;
        
        try {
            // Read file content
            $fileContent = file_get_contents($file['tmp_name']);
            if ($fileContent === false) {
                $result['message'] = 'Failed to read uploaded file';
                return $result;
            }
            
            // Upload to Firebase Storage using REST API
            $uploadUrl = "https://firebasestorage.googleapis.com/v0/b/{$this->storageBucket}/o?name=" . urlencode($storagePath);
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $uploadUrl,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $fileContent,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: ' . $mimeType,
                    'Content-Length: ' . strlen($fileContent)
                ]
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200) {
                $responseData = json_decode($response, true);
                
                // Make file publicly accessible
                $downloadUrl = $this->makeFilePublic($storagePath);
                
                if ($downloadUrl) {
                    $result['success'] = true;
                    $result['message'] = 'File uploaded successfully';
                    $result['downloadUrl'] = $downloadUrl;
                    $result['filename'] = $filename;
                } else {
                    $result['message'] = 'File uploaded but failed to make public';
                }
            } else {
                $result['message'] = 'Firebase Storage upload failed: HTTP ' . $httpCode;
                error_log("Firebase Storage upload error: " . $response);
            }
            
        } catch (Exception $e) {
            $result['message'] = 'Upload failed: ' . $e->getMessage();
            error_log("Firebase Storage upload exception: " . $e->getMessage());
        }
        
        return $result;
    }
    
    /**
     * Make uploaded file publicly accessible
     * 
     * @param string $storagePath Path in Firebase Storage
     * @return string|null Public download URL
     */
    private function makeFilePublic($storagePath) {
        try {
            // For now, return the public URL format
            // In production, you'd need to set proper IAM permissions or use signed URLs
            $encodedPath = urlencode($storagePath);
            return "https://firebasestorage.googleapis.com/v0/b/{$this->storageBucket}/o/{$encodedPath}?alt=media";
            
        } catch (Exception $e) {
            error_log("Error making file public: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Delete file from Firebase Storage
     * 
     * @param string $storagePath Path in Firebase Storage
     * @return bool Success status
     */
    public function deleteFile($storagePath) {
        try {
            $deleteUrl = "https://firebasestorage.googleapis.com/v0/b/{$this->storageBucket}/o/" . urlencode($storagePath);
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $deleteUrl,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_RETURNTRANSFER => true
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            return $httpCode === 204; // 204 No Content indicates successful deletion
            
        } catch (Exception $e) {
            error_log("Firebase Storage delete error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get public URL for a file
     * 
     * @param string $storagePath Path in Firebase Storage
     * @return string Public download URL
     */
    public function getPublicUrl($storagePath) {
        $encodedPath = urlencode($storagePath);
        return "https://firebasestorage.googleapis.com/v0/b/{$this->storageBucket}/o/{$encodedPath}?alt=media";
    }
}
?>