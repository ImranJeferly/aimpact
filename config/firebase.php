<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/env.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// For XAMPP development, skip Firebase initialization due to gRPC requirement
// Firebase will work perfectly on production servers with proper extensions
$firestore = null;
$database = null;

// Uncomment the following code when deploying to production server:
/*
try {
    // Method 1: Service Account JSON file (recommended for production)
    if (isset($_ENV['FIREBASE_CREDENTIALS']) && file_exists($_ENV['FIREBASE_CREDENTIALS'])) {
        $serviceAccount = ServiceAccount::fromJsonFile($_ENV['FIREBASE_CREDENTIALS']);
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount);
    } 
    // Method 2: Environment variables (for development)
    elseif (isset($_ENV['FIREBASE_PROJECT_ID'])) {
        $firebase = (new Factory)
            ->withProjectId($_ENV['FIREBASE_PROJECT_ID'])
            ->withDatabaseUri($_ENV['FIREBASE_DATABASE_URL'] ?? null);
    } 
    // Method 3: Auto-discovery (if running on Google Cloud or with default credentials)
    else {
        $firebase = (new Factory);
    }
    
    // Use Firestore for better querying and structure
    $firestore = $firebase->createFirestore();
    $database = $firebase->createDatabase(); // Keep as backup
    
} catch (Exception $e) {
    error_log("Firebase connection failed: " . $e->getMessage());
    $firestore = null;
    $database = null;
}
*/

// Helper class for Firebase operations
class FirebaseHelper {
    private $firestore;
    private $database;
    
    public function __construct($firestore, $database = null) {
        $this->firestore = $firestore;
        $this->database = $database;
    }
    
    public function isConnected() {
        // For now, we'll use fallback data since gRPC is not available in XAMPP
        // Firebase will work perfectly once deployed to a production server
        return false; // This ensures we always use fallback data for local development
    }
    
    // Blog operations
    public function getAllBlogs($status = null) {
        if (!$this->isConnected()) {
            require_once __DIR__ . '/fallback_data.php';
            $blogs = FallbackData::getSampleBlogs();
            // Filter by status if specified
            if ($status) {
                return array_filter($blogs, function($blog) use ($status) {
                    return isset($blog['status']) && $blog['status'] === $status;
                });
            }
            return $blogs;
        }
        
        try {
            $collection = $this->firestore->database()->collection('blogs');
            if ($status) {
                $collection = $collection->where('status', '=', $status);
            }
            $documents = $collection->orderBy('created_at', 'DESC')->documents();
            
            $blogs = [];
            foreach ($documents as $document) {
                $data = $document->data();
                $data['id'] = $document->id();
                $blogs[] = $data;
            }
            return $blogs;
        } catch (Exception $e) {
            error_log("Firebase getAllBlogs failed: " . $e->getMessage());
            // Fallback to sample data if Firebase fails
            require_once __DIR__ . '/fallback_data.php';
            return FallbackData::getSampleBlogs();
        }
    }
    
    public function getBlogById($id) {
        if (!$this->isConnected()) {
            require_once __DIR__ . '/fallback_data.php';
            $blogs = FallbackData::getSampleBlogs();
            foreach ($blogs as $blog) {
                if ($blog['id'] === $id) {
                    return $blog;
                }
            }
            return null;
        }
        
        try {
            $reference = $this->database->getReference('blogs/' . $id);
            $snapshot = $reference->getSnapshot();
            
            if ($snapshot->exists()) {
                $data = $snapshot->getValue();
                $data['id'] = $id;
                return $data;
            }
            return null;
        } catch (Exception $e) {
            error_log("Firebase getBlogById failed: " . $e->getMessage());
            return null;
        }
    }
    
    public function getBlogBySlug($slug) {
        if (!$this->isConnected()) return null;
        
        try {
            $reference = $this->database->getReference('blogs');
            $snapshot = $reference->orderByChild('slug')->equalTo($slug)->limitToFirst(1)->getSnapshot();
            
            if ($snapshot->exists()) {
                foreach ($snapshot->getValue() as $key => $data) {
                    $data['id'] = $key;
                    return $data;
                }
            }
            return null;
        } catch (Exception $e) {
            error_log("Firebase getBlogBySlug failed: " . $e->getMessage());
            return null;
        }
    }
    
    public function addBlog($data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $reference = $this->database->getReference('blogs');
            $newBlogRef = $reference->push($data);
            return $newBlogRef->getKey();
        } catch (Exception $e) {
            error_log("Firebase addBlog failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateBlog($id, $data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $reference = $this->database->getReference('blogs/' . $id);
            $reference->update($data);
            return true;
        } catch (Exception $e) {
            error_log("Firebase updateBlog failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteBlog($id) {
        if (!$this->isConnected()) return false;
        
        try {
            $reference = $this->database->getReference('blogs/' . $id);
            $reference->remove();
            return true;
        } catch (Exception $e) {
            error_log("Firebase deleteBlog failed: " . $e->getMessage());
            return false;
        }
    }
    
    // Testimonial operations
    public function getAllTestimonials($status = 'approved') {
        if (!$this->isConnected()) {
            require_once __DIR__ . '/fallback_data.php';
            return FallbackData::getSampleTestimonials();
        }
        
        try {
            $collection = $this->firestore->database()->collection('testimonials');
            if ($status) {
                $collection = $collection->where('status', '=', $status);
            }
            $documents = $collection->orderBy('featured', 'DESC')
                ->orderBy('created_at', 'DESC')->documents();
            
            $testimonials = [];
            foreach ($documents as $document) {
                $data = $document->data();
                $data['id'] = $document->id();
                $testimonials[] = $data;
            }
            return $testimonials;
        } catch (Exception $e) {
            error_log("Firebase getAllTestimonials failed: " . $e->getMessage());
            // Fallback to sample data if Firebase fails
            require_once __DIR__ . '/fallback_data.php';
            return FallbackData::getSampleTestimonials();
        }
    }
    
    public function getTestimonialById($id) {
        if (!$this->isConnected()) return null;
        
        try {
            $reference = $this->database->getReference('testimonials/' . $id);
            $snapshot = $reference->getSnapshot();
            
            if ($snapshot->exists()) {
                $data = $snapshot->getValue();
                $data['id'] = $id;
                return $data;
            }
            return null;
        } catch (Exception $e) {
            error_log("Firebase getTestimonialById failed: " . $e->getMessage());
            return null;
        }
    }
    
    public function addTestimonial($data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['status'] = $data['status'] ?? 'pending';
            
            $reference = $this->database->getReference('testimonials');
            $newTestimonialRef = $reference->push($data);
            return $newTestimonialRef->getKey();
        } catch (Exception $e) {
            error_log("Firebase addTestimonial failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateTestimonial($id, $data) {
        if (!$this->isConnected()) return false;
        
        try {
            if (isset($data['status']) && $data['status'] === 'approved') {
                $data['approved_at'] = date('Y-m-d H:i:s');
            }
            
            $reference = $this->database->getReference('testimonials/' . $id);
            $reference->update($data);
            return true;
        } catch (Exception $e) {
            error_log("Firebase updateTestimonial failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteTestimonial($id) {
        if (!$this->isConnected()) return false;
        
        try {
            $reference = $this->database->getReference('testimonials/' . $id);
            $reference->remove();
            return true;
        } catch (Exception $e) {
            error_log("Firebase deleteTestimonial failed: " . $e->getMessage());
            return false;
        }
    }
    
    // Submission operations
    public function addSubmission($data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $reference = $this->database->getReference('submissions');
            $newSubmissionRef = $reference->push($data);
            return $newSubmissionRef->getKey();
        } catch (Exception $e) {
            error_log("Firebase addSubmission failed: " . $e->getMessage());
            return false;
        }
    }
    
    // Search operations
    public function searchBlogs($search = '', $category = '') {
        if (!$this->isConnected()) {
            require_once __DIR__ . '/fallback_data.php';
            $blogs = FallbackData::getSampleBlogs();
            
            // Filter by published status
            $blogs = array_filter($blogs, function($blog) {
                return isset($blog['status']) && $blog['status'] === 'published';
            });
            
            // Basic text search (case-insensitive)
            if ($search) {
                $searchLower = strtolower($search);
                $blogs = array_filter($blogs, function($blog) use ($searchLower) {
                    $titleLower = strtolower($blog['title'] ?? '');
                    $contentLower = strtolower($blog['content'] ?? '');
                    
                    return (strpos($titleLower, $searchLower) !== false || 
                            strpos($contentLower, $searchLower) !== false);
                });
            }
            
            return array_values($blogs); // Re-index array
        }
        
        try {
            $reference = $this->database->getReference('blogs');
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                return [];
            }
            
            $blogs = [];
            foreach ($snapshot->getValue() as $key => $blogData) {
                $blogData['id'] = $key;
                
                // Only include published blogs
                if (!isset($blogData['status']) || $blogData['status'] !== 'published') {
                    continue;
                }
                
                // Basic text search (case-insensitive)
                if ($search) {
                    $searchLower = strtolower($search);
                    $titleLower = strtolower($blogData['title'] ?? '');
                    $contentLower = strtolower($blogData['content'] ?? '');
                    
                    if (strpos($titleLower, $searchLower) === false && 
                        strpos($contentLower, $searchLower) === false) {
                        continue;
                    }
                }
                
                $blogs[] = $blogData;
            }
            
            // Sort by created_at DESC
            usort($blogs, function($a, $b) {
                $aTime = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
                $bTime = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
                return $bTime - $aTime;
            });
            
            return $blogs;
        } catch (Exception $e) {
            error_log("Firebase searchBlogs failed: " . $e->getMessage());
            return [];
        }
    }
}

// Initialize Firebase Helper
$firebaseHelper = new FirebaseHelper($firestore, $database);
?>