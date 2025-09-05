<?php
require_once __DIR__ . '/env.php';

// Firebase REST API client - works without gRPC extension
class FirebaseRestClient {
    private $projectId;
    private $databaseUrl;
    private $apiKey;
    
    public function __construct($projectId, $apiKey = null, $databaseUrl = null) {
        $this->projectId = $projectId;
        $this->apiKey = $apiKey;
        $this->databaseUrl = $databaseUrl;
    }
    
    public function isConnected() {
        return !empty($this->projectId);
    }
    
    // Firestore REST API methods
    private function makeFirestoreRequest($method, $path, $data = null) {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents" . $path;
        
        $options = [
            'http' => [
                'method' => $method,
                'header' => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                'ignore_errors' => true,
                'timeout' => 10
            ]
        ];
        
        if ($data) {
            $options['http']['content'] = json_encode($data);
        }
        
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            error_log("Firebase REST request failed: $method $url");
            return null;
        }
        
        return json_decode($response, true);
    }
    
    // Convert Firestore document format to simple array
    private function convertFirestoreDocument($doc) {
        if (!isset($doc['fields'])) return null;
        
        $result = ['id' => basename($doc['name'])];
        
        foreach ($doc['fields'] as $key => $value) {
            if (isset($value['stringValue'])) {
                $result[$key] = $value['stringValue'];
            } elseif (isset($value['integerValue'])) {
                $result[$key] = (int)$value['integerValue'];
            } elseif (isset($value['doubleValue'])) {
                $result[$key] = (float)$value['doubleValue'];
            } elseif (isset($value['booleanValue'])) {
                $result[$key] = (bool)$value['booleanValue'];
            } elseif (isset($value['timestampValue'])) {
                $result[$key] = $value['timestampValue'];
            } elseif (isset($value['nullValue'])) {
                $result[$key] = null;
            }
        }
        
        return $result;
    }
    
    // Convert simple array to Firestore document format
    private function convertToFirestoreDocument($data) {
        $fields = [];
        
        foreach ($data as $key => $value) {
            if ($key === 'id') continue; // Skip ID field
            
            if (is_string($value)) {
                $fields[$key] = ['stringValue' => $value];
            } elseif (is_int($value)) {
                $fields[$key] = ['integerValue' => (string)$value];
            } elseif (is_float($value)) {
                $fields[$key] = ['doubleValue' => $value];
            } elseif (is_bool($value)) {
                $fields[$key] = ['booleanValue' => $value];
            } elseif (is_null($value)) {
                $fields[$key] = ['nullValue' => null];
            } else {
                $fields[$key] = ['stringValue' => (string)$value];
            }
        }
        
        return ['fields' => $fields];
    }
    
    // Get all documents from a collection
    public function getCollection($collection) {
        $response = $this->makeFirestoreRequest('GET', "/$collection");
        
        if (!$response || !isset($response['documents'])) {
            return [];
        }
        
        $results = [];
        foreach ($response['documents'] as $doc) {
            $converted = $this->convertFirestoreDocument($doc);
            if ($converted) {
                $results[] = $converted;
            }
        }
        
        return $results;
    }
    
    // Get a single document
    public function getDocument($collection, $documentId) {
        $response = $this->makeFirestoreRequest('GET', "/$collection/$documentId");
        
        if (!$response) {
            return null;
        }
        
        return $this->convertFirestoreDocument($response);
    }
    
    // Create a new document
    public function createDocument($collection, $data) {
        $firestoreData = $this->convertToFirestoreDocument($data);
        $response = $this->makeFirestoreRequest('POST', "/$collection", $firestoreData);
        
        if (!$response) {
            error_log("Firebase createDocument failed - no response");
            return false;
        }
        
        if (!isset($response['name'])) {
            error_log("Firebase createDocument failed - no 'name' in response: " . json_encode($response));
            return false;
        }
        
        return basename($response['name']);
    }
    
    // Update a document
    public function updateDocument($collection, $documentId, $data) {
        $firestoreData = $this->convertToFirestoreDocument($data);
        $response = $this->makeFirestoreRequest('PATCH', "/$collection/$documentId", $firestoreData);
        
        return $response !== null;
    }
    
    // Delete a document
    public function deleteDocument($collection, $documentId) {
        $response = $this->makeFirestoreRequest('DELETE', "/$collection/$documentId");
        return $response !== null;
    }
    
    // Test connection
    public function testConnection() {
        $response = $this->makeFirestoreRequest('GET', '');
        return $response !== null;
    }
}

// Initialize Firebase REST client
$firebaseProjectId = $_ENV['FIREBASE_PROJECT_ID'] ?? 'aimpact-22bcb';
$firebaseClient = new FirebaseRestClient($firebaseProjectId);

// Create a new helper class that uses the REST client
class FirebaseRestHelper {
    private $client;
    
    public function __construct($client) {
        $this->client = $client;
    }
    
    public function isConnected() {
        return $this->client && $this->client->isConnected();
    }
    
    public function testConnection() {
        if (!$this->isConnected()) return false;
        return $this->client->testConnection();
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
            $blogs = $this->client->getCollection('blogs');
            
            // If no blogs found in Firebase, use fallback data
            if (empty($blogs)) {
                require_once __DIR__ . '/fallback_data.php';
                $blogs = FallbackData::getSampleBlogs();
            }
            
            // Filter by status if specified
            if ($status) {
                $blogs = array_filter($blogs, function($blog) use ($status) {
                    return isset($blog['status']) && $blog['status'] === $status;
                });
            }
            
            // Sort by created_at DESC
            usort($blogs, function($a, $b) {
                $aTime = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
                $bTime = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
                return $bTime - $aTime;
            });
            
            return array_values($blogs);
        } catch (Exception $e) {
            error_log("Firebase REST getAllBlogs failed: " . $e->getMessage());
            require_once __DIR__ . '/fallback_data.php';
            $blogs = FallbackData::getSampleBlogs();
            // Filter by status if specified for fallback data
            if ($status) {
                return array_filter($blogs, function($blog) use ($status) {
                    return isset($blog['status']) && $blog['status'] === $status;
                });
            }
            return $blogs;
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
            return $this->client->getDocument('blogs', $id);
        } catch (Exception $e) {
            error_log("Firebase REST getBlogById failed: " . $e->getMessage());
            return null;
        }
    }
    
    public function addBlog($data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            return $this->client->createDocument('blogs', $data);
        } catch (Exception $e) {
            error_log("Firebase REST addBlog failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateBlog($id, $data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            return $this->client->updateDocument('blogs', $id, $data);
        } catch (Exception $e) {
            error_log("Firebase REST updateBlog failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteBlog($id) {
        if (!$this->isConnected()) return false;
        
        try {
            return $this->client->deleteDocument('blogs', $id);
        } catch (Exception $e) {
            error_log("Firebase REST deleteBlog failed: " . $e->getMessage());
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
            $testimonials = $this->client->getCollection('testimonials');
            
            // Filter by status if specified
            if ($status) {
                $testimonials = array_filter($testimonials, function($testimonial) use ($status) {
                    return isset($testimonial['status']) && $testimonial['status'] === $status;
                });
            }
            
            // Sort by featured DESC, then created_at DESC
            usort($testimonials, function($a, $b) {
                $aFeatured = isset($a['featured']) ? (int)$a['featured'] : 0;
                $bFeatured = isset($b['featured']) ? (int)$b['featured'] : 0;
                
                if ($aFeatured !== $bFeatured) {
                    return $bFeatured - $aFeatured;
                }
                
                $aTime = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
                $bTime = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
                return $bTime - $aTime;
            });
            
            return array_values($testimonials);
        } catch (Exception $e) {
            error_log("Firebase REST getAllTestimonials failed: " . $e->getMessage());
            require_once __DIR__ . '/fallback_data.php';
            return FallbackData::getSampleTestimonials();
        }
    }
    
    public function addTestimonial($data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['status'] = $data['status'] ?? 'pending';
            return $this->client->createDocument('testimonials', $data);
        } catch (Exception $e) {
            error_log("Firebase REST addTestimonial failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateTestimonial($id, $data) {
        if (!$this->isConnected()) return false;
        
        try {
            if (isset($data['status']) && $data['status'] === 'approved') {
                $data['approved_at'] = date('Y-m-d H:i:s');
            }
            return $this->client->updateDocument('testimonials', $id, $data);
        } catch (Exception $e) {
            error_log("Firebase REST updateTestimonial failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteTestimonial($id) {
        if (!$this->isConnected()) return false;
        
        try {
            return $this->client->deleteDocument('testimonials', $id);
        } catch (Exception $e) {
            error_log("Firebase REST deleteTestimonial failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function getTestimonialById($id) {
        if (!$this->isConnected()) return null;
        
        try {
            return $this->client->getDocument('testimonials', $id);
        } catch (Exception $e) {
            error_log("Firebase REST getTestimonialById failed: " . $e->getMessage());
            return null;
        }
    }
    
    // Submission operations
    public function addSubmission($data) {
        if (!$this->isConnected()) return false;
        
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->client->createDocument('submissions', $data);
        } catch (Exception $e) {
            error_log("Firebase REST addSubmission failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllSubmissions() {
        if (!$this->isConnected()) return [];
        
        try {
            $submissions = $this->client->getCollection('submissions');
            
            // Sort by created_at DESC
            usort($submissions, function($a, $b) {
                $aTime = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
                $bTime = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
                return $bTime - $aTime;
            });
            
            return array_values($submissions);
        } catch (Exception $e) {
            error_log("Firebase REST getAllSubmissions failed: " . $e->getMessage());
            return [];
        }
    }
    
    // Search operations
    public function searchBlogs($search = '', $category = '') {
        // Get all blogs first, then filter (Firestore REST doesn't support complex queries easily)
        $blogs = $this->getAllBlogs('published');
        
        if ($search) {
            $searchLower = strtolower($search);
            $blogs = array_filter($blogs, function($blog) use ($searchLower) {
                $titleLower = strtolower($blog['title'] ?? '');
                $contentLower = strtolower($blog['content'] ?? '');
                
                return (strpos($titleLower, $searchLower) !== false || 
                        strpos($contentLower, $searchLower) !== false);
            });
        }
        
        return array_values($blogs);
    }
}

// Initialize the helper
$firebaseRestHelper = new FirebaseRestHelper($firebaseClient);
?>